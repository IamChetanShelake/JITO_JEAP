<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ApplicationWorkflowStatus;

class WorkflowStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users who don't have workflow status
        $users = User::whereDoesntHave('workflowStatus')
            ->get();

        foreach ($users as $user) {
            ApplicationWorkflowStatus::create([
                'user_id' => $user->id,
                'current_stage' => 'apex_1',
                'final_status' => 'in_progress',
            ]);
        }

        $this->command->info('Created workflow status for ' . $users->count() . ' existing users.');
    }
}
