<?php

namespace App\Traits;

use App\Models\Logs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait LogsUserActivity
{
    /**
     * Core activity logger
     */
    // protected function logUserActivity(
    //     string $processType,
    //     string $processAction,
    //     ?string $processDescription = null,
    //     ?string $module = null,
    //     ?array $oldValues = null,
    //     ?array $newValues = null,
    //     ?array $additionalData = null,
    //     ?int $userId = null,               // 🎯 Target user (application owner)
    //     ?string $processByName = null,     // 👮 Actor name
    //     ?string $processByRole = null,     // 👮 Actor role
    //     ?int $processById = null           // 👮 Actor id
    // ): void {
    //     try {
    //         // 🔹 Actor (Admin / System)
    //         $currentUser = Auth::user();

    //         $actorName = $processByName ?? ($currentUser?->name ?? 'System');
    //         $actorRole = $processByRole ?? ($currentUser?->role ?? 'system');
    //         $actorId   = $processById   ?? ($currentUser?->id ?? null);

    //         // 🔹 Target user (Applicant / Record owner)
    //         $targetUser = $userId ? User::find($userId) : null;

    //         // 🔹 Prepare log payload
    //         Logs::create([
    //             // 🎯 Target User
    //             'user_id'    => $targetUser?->id,
    //             'user_name'  => $targetUser?->name,
    //             'user_email' => $targetUser?->email,

    //             // 🔄 Process info
    //             'process_type'        => $processType,
    //             'process_action'      => $processAction,
    //             'process_description' => $processDescription,

    //             // 👮 Actor info
    //             'process_by_name' => $actorName,
    //             'process_by_role' => $actorRole,
    //             'process_by_id'   => $actorId,

    //             // 📦 Meta
    //             'module'          => $module,
    //             'action_url'      => request()->fullUrl(),
    //             'old_values'      => $oldValues,
    //             'new_values'      => $newValues,
    //             'additional_data' => $additionalData,
    //             'process_date'    => now(),
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error('User activity log failed', [
    //             'error' => $e->getMessage(),
    //             'process_type' => $processType,
    //             'process_action' => $processAction,
    //             'user_id' => $userId,
    //         ]);
    //     }
    // }


    protected function logUserActivity(
        string $processType,
        string $processAction,
        ?string $processDescription = null,
        ?string $module = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $additionalData = null,

        // 🎯 TARGET USER (MANDATORY)
        int $targetUserId,

        // 👮 ACTOR (MANDATORY)
        int $actorId,
        string $actorName,
        string $actorRole
    ) {
        try {
            $targetUser = \App\Models\User::findOrFail($targetUserId);

            Logs::create([
                // 🎯 TARGET USER
                'user_id'    => $targetUser->id,
                'user_name'  => $targetUser->name,
                'user_email' => $targetUser->email,

                // PROCESS
                'process_type'        => $processType,
                'process_action'      => $processAction,
                'process_description' => $processDescription,
                'module'              => $module,

                // 👮 ACTOR
                'process_by_id'   => $actorId,
                'process_by_name' => $actorName,
                'process_by_role' => $actorRole,

                'old_values'      => $oldValues,
                'new_values'      => $newValues,
                'additional_data' => $additionalData,
                'action_url'      => request()->fullUrl(),
                'process_date'    => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Log failed', ['error' => $e->getMessage()]);
        }
    }


    /* -----------------------------------------------------------------
     |  Helper Methods
     |-----------------------------------------------------------------*/

    protected function logUserRegistration(int $userId): void
    {
        $this->logUserActivity(
            'user_registration',
            'created',
            'User registered for JEAP application',
            'user',
            userId: $userId,
            processByName: 'User',
            processByRole: 'applicant'
        );
    }

    protected function logApplicationSubmission(int $userId, string $loanType): void
    {
        $this->logUserActivity(
            'application_submission',
            'submitted',
            "User submitted {$loanType} loan application",
            'application',
            additionalData: ['loan_type' => $loanType],
            userId: $userId
        );
    }

    protected function logStepCompletion(int $userId, string $step, string $stepName): void
    {
        $this->logUserActivity(
            'step_completion',
            'completed',
            "User completed step {$step}: {$stepName}",
            'application',
            additionalData: ['step' => $step, 'step_name' => $stepName],
            userId: $userId
        );
    }

    protected function logDocumentUpload(int $userId, array $uploadedFiles): void
    {
        $this->logUserActivity(
            'document_upload',
            'uploaded',
            'User uploaded application documents',
            'document',
            additionalData: ['files' => $uploadedFiles],
            userId: $userId
        );
    }

    protected function logAdminApproval(
        int $userId,
        string $stage,
        string $remark = null
    ): void {
        $this->logUserActivity(
            'admin_approval',
            'approved',
            $remark ?? "Application approved at {$stage} stage",
            'workflow',
            additionalData: ['stage' => $stage],
            userId: $userId
        );
    }

    protected function logAdminRejection(
        int $userId,
        string $stage,
        string $reason
    ): void {
        $this->logUserActivity(
            'admin_rejection',
            'rejected',
            $reason,
            'workflow',
            additionalData: ['stage' => $stage],
            userId: $userId
        );
    }

    protected function logAdminHold(
        int $userId,
        string $stage,
        string $reason
    ): void {
        $this->logUserActivity(
            'admin_hold',
            'held',
            $reason,
            'workflow',
            additionalData: ['stage' => $stage],
            userId: $userId
        );
    }

    protected function logPdcApproval(
        int $userId,
        int $chequeCount
    ): void {
        $this->logUserActivity(
            'pdc_approval',
            'approved',
            "PDC approved with {$chequeCount} cheques",
            'pdc',
            additionalData: ['cheque_count' => $chequeCount],
            userId: $userId
        );
    }

    protected function logPdcCorrection(
        int $userId,
        string $reason
    ): void {
        $this->logUserActivity(
            'pdc_correction',
            'correction_required',
            $reason,
            'pdc',
            userId: $userId
        );
    }

    protected function logDataUpdate(
        int $userId,
        string $module,
        string $dataType,
        array $oldValues,
        array $newValues
    ): void {
        $this->logUserActivity(
            'data_update',
            'updated',
            "User updated {$dataType}",
            $module,
            oldValues: $oldValues,
            newValues: $newValues,
            userId: $userId
        );
    }

    protected function logDonorAction(
        string $action,
        string $donorName,
        ?int $donorId = null,
        ?array $additionalData = null
    ): void {
        $this->logUserActivity(
            'donor_action',
            $action,
            "Donor {$donorName} performed {$action}",
            'donor',
            additionalData: $additionalData,
            processByName: $donorName,
            processByRole: 'donor',
            processById: $donorId
        );
    }
}
