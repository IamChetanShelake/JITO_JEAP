<?php

namespace App\Traits;

use App\Models\Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait LogsUserActivity
{
    /**
     * Log a user activity
     *
     * @param string $processType
     * @param string $processAction
     * @param string|null $processDescription
     * @param string|null $module
     * @param array|null $oldValues
     * @param array|null $newValues
     * @param array|null $additionalData
     * @param int|null $userId
     * @param string|null $processByName
     * @param string|null $processByRole
     * @param int|null $processById
     * @return void
     */
    protected function logUserActivity(
        string $processType,
        string $processAction,
        ?string $processDescription = null,
        ?string $module = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $additionalData = null,
        ?int $userId = null,
        ?string $processByName = null,
        ?string $processByRole = null,
        ?int $processById = null
    ) {
        try {
            // Get user context
            $currentUser = Auth::user();
            $user = $userId ? \App\Models\User::find($userId) : $currentUser;

            // Determine who performed the action
            $actorName = $processByName ?: ($currentUser ? $currentUser->name : 'System');
            $actorRole = $processByRole ?: ($currentUser ? $currentUser->role : 'system');
            $actorId = $processById ?: ($currentUser ? $currentUser->id : null);

            // Prepare log data
            $logData = [
                'user_id' => $user ? $user->id : null,
                'user_name' => $user ? $user->name : null,
                'user_email' => $user ? $user->email : null,
                'process_type' => $processType,
                'process_action' => $processAction,
                'process_description' => $processDescription,
                'process_by_name' => $actorName,
                'process_by_role' => $actorRole,
                'process_by_id' => $actorId,
                'module' => $module,
                'action_url' => request()->fullUrl(),
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'additional_data' => $additionalData,
                'process_date' => now(),
            ];

            // Create log entry
            Logs::create($logData);

        } catch (\Exception $e) {
            // Log the error but don't fail the main operation
            Log::error('Failed to create user activity log: ' . $e->getMessage(), [
                'process_type' => $processType,
                'process_action' => $processAction,
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Log user registration
     */
    protected function logUserRegistration(int $userId)
    {
        $this->logUserActivity(
            processType: 'user_registration',
            processAction: 'created',
            processDescription: 'User registered for JEAP application',
            module: 'user',
            userId: $userId,
            processByName: 'User',
            processByRole: 'applicant'
        );
    }

    /**
     * Log application submission
     */
    protected function logApplicationSubmission(int $userId, string $loanType)
    {
        $this->logUserActivity(
            processType: 'application_submission',
            processAction: 'submitted',
            processDescription: "User submitted {$loanType} loan application",
            module: 'application',
            userId: $userId,
            additionalData: ['loan_type' => $loanType]
        );
    }

    /**
     * Log step completion
     */
    protected function logStepCompletion(int $userId, string $step, string $stepName)
    {
        $this->logUserActivity(
            processType: 'step_completion',
            processAction: 'completed',
            processDescription: "User completed step {$step}: {$stepName}",
            module: 'application',
            userId: $userId,
            additionalData: ['step' => $step, 'step_name' => $stepName]
        );
    }

    /**
     * Log document upload
     */
    protected function logDocumentUpload(int $userId, array $uploadedFiles)
    {
        $this->logUserActivity(
            processType: 'document_upload',
            processAction: 'uploaded',
            processDescription: 'User uploaded application documents',
            module: 'document',
            userId: $userId,
            additionalData: ['files' => $uploadedFiles]
        );
    }

    /**
     * Log admin approval
     */
    protected function logAdminApproval(int $userId, string $stage, string $approvedBy, string $role)
    {
        $this->logUserActivity(
            processType: 'admin_approval',
            processAction: 'approved',
            processDescription: "Application approved at {$stage} stage",
            module: 'workflow',
            userId: $userId,
            processByName: $approvedBy,
            processByRole: $role
        );
    }

    /**
     * Log admin rejection
     */
    protected function logAdminRejection(int $userId, string $stage, string $rejectedBy, string $role, string $reason)
    {
        $this->logUserActivity(
            processType: 'admin_rejection',
            processAction: 'rejected',
            processDescription: "Application rejected at {$stage} stage: {$reason}",
            module: 'workflow',
            userId: $userId,
            processByName: $rejectedBy,
            processByRole: $role,
            additionalData: ['rejection_reason' => $reason, 'stage' => $stage]
        );
    }

    /**
     * Log admin hold
     */
    protected function logAdminHold(int $userId, string $stage, string $heldBy, string $role, string $reason)
    {
        $this->logUserActivity(
            processType: 'admin_hold',
            processAction: 'held',
            processDescription: "Application put on hold at {$stage} stage: {$reason}",
            module: 'workflow',
            userId: $userId,
            processByName: $heldBy,
            processByRole: $role,
            additionalData: ['hold_reason' => $reason, 'stage' => $stage]
        );
    }

    /**
     * Log PDC approval
     */
    protected function logPdcApproval(int $userId, string $approvedBy, int $chequeCount)
    {
        $this->logUserActivity(
            processType: 'pdc_approval',
            processAction: 'approved',
            processDescription: "PDC details approved with {$chequeCount} cheques",
            module: 'pdc',
            userId: $userId,
            processByName: $approvedBy,
            processByRole: 'admin',
            additionalData: ['cheque_count' => $chequeCount]
        );
    }

    /**
     * Log PDC correction required
     */
    protected function logPdcCorrection(int $userId, string $correctedBy, string $reason)
    {
        $this->logUserActivity(
            processType: 'pdc_correction',
            processAction: 'correction_required',
            processDescription: "PDC details sent back for correction: {$reason}",
            module: 'pdc',
            userId: $userId,
            processByName: $correctedBy,
            processByRole: 'admin',
            additionalData: ['correction_reason' => $reason]
        );
    }

    /**
     * Log data update
     */
    protected function logDataUpdate(int $userId, string $module, string $dataType, array $oldValues, array $newValues)
    {
        $this->logUserActivity(
            processType: 'data_update',
            processAction: 'updated',
            processDescription: "User updated {$dataType} data",
            module: $module,
            userId: $userId,
            oldValues: $oldValues,
            newValues: $newValues,
            additionalData: ['data_type' => $dataType]
        );
    }

    /**
     * Log donor action
     */
    protected function logDonorAction(string $action, string $donorName, ?int $donorId = null, ?array $additionalData = null)
    {
        $this->logUserActivity(
            processType: 'donor_action',
            processAction: $action,
            processDescription: "Donor {$donorName} performed {$action}",
            module: 'donor',
            processByName: $donorName,
            processByRole: 'donor',
            processById: $donorId,
            additionalData: $additionalData
        );
    }
}