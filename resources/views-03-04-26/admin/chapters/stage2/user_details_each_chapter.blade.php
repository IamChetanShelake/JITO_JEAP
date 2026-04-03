@extends('admin.layouts.master')
    @section('content')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .chapter-header {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            border: 1px solid #e0e0e0;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .chapter-title {
            color: #E31E24;
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .status-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .status-button {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
            text-align: center;
        }

        .status-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .status-button.approved {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border-color: #c8e6c9;
        }

        .status-button.pending {
            background: linear-gradient(135deg, #fff8e1 0%, #ffe082 100%);
            border-color: #ffe082;
        }

        .status-button.hold {
            background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
            border-color: #ffcdd2;
        }

        .status-button.total-applied {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-color: #bbdefb;
        }

        .status-button.draft {
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            border-color: #e0e0e0;
        }

        .status-button.apex-pending {
            background: linear-gradient(135deg, #fffde7 0%, #fff9c4 100%);
            border-color: #fff9c4;
        }

        .status-button.working-committee-pending {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-color: #ffe0b2;
        }

        .status-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            border: 3px solid;
            background: rgba(255, 255, 255, 0.3);
            margin: 0 auto 0.75rem;
        }

        .status-icon.approved {
            border-color: #4caf50;
            color: #4caf50;
        }

        .status-icon.pending {
            border-color: #ffc107;
            color: #ffc107;
        }

        .status-icon.hold {
            border-color: #f44336;
            color: #f44336;
        }

        .status-icon.total-applied {
            border-color: #2196f3;
            color: #2196f3;
        }

        .status-icon.draft {
            border-color: #9e9e9e;
            color: #9e9e9e;
        }

        .status-icon.apex-pending {
            border-color: #ffeb3b;
            color: #ffeb3b;
        }

        .status-icon.working-committee-pending {
            border-color: #ff9800;
            color: #ff9800;
        }

        .status-label {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .status-count {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }

        .back-button {
            margin-bottom: 2rem;
        }
    </style>



<div class="container">


    <div class="chapter-header">
        <h1 class="chapter-title">{{ $chapter->chapter_name }}</h1>
        <p class="text-muted">Chapter Statistics & Management</p>
    </div>

    <div class="status-buttons">
        <a href="{{ route('admin.chapter.total-applied') }}?chapter_id={{ $chapter->id }}" class="status-button total-applied" title="View all applied students">
            <div class="status-icon total-applied">
                <i class="fas fa-users"></i>
            </div>
            <div class="status-label">Total Applied</div>
            <div class="status-count">{{
                \App\Models\User::where('role', 'user')
                    ->where('chapter_id', $chapter->id)
                    ->count()
            }}</div>
        </a>
        {{-- <a href="{{ route('admin.chapter.approved') }}?chapter_id={{ $chapter->id }}" class="status-button approved" title="View approved applications">
            <div class="status-icon approved">
                <i class="fas fa-check"></i>
            </div>
            <div class="status-label">Approved</div>
            <div class="status-count">{{
                \App\Models\User::where('role', 'user')
                    ->where('chapter_id', $chapter->id)
                    ->whereHas('workflowStatus', function($q) {
                        $q->where('chapter_status', 'approved');
                    })
                    ->count()
            }}</div>
        </a> --}}

        <a href="{{ route('admin.chapter.pending') }}?chapter_id={{ $chapter->id }}" class="status-button pending" title="View pending applications">
            <div class="status-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="status-label">Pending</div>
            <div class="status-count">{{
               \App\Models\User::where('role', 'user')
            ->where('chapter_id', $chapter->id)
            ->whereHas('workflowStatus', function ($q) {
                $q->where('current_stage', 'chapter')
                  ->where('final_status', 'in_progress');
            })
            ->count()
            }}</div>
        </a>





        <a href="{{ route('admin.chapter.draft') }}?chapter_id={{ $chapter->id }}" class="status-button draft" title="View draft applications">
            <div class="status-icon draft">
                <i class="fas fa-edit"></i>
            </div>
            <div class="status-label">In Draft</div>
            <div class="status-count">{{
                \App\Models\User::where('role', 'user')
                    ->where('chapter_id', $chapter->id)
                    ->where('application_status', 'draft')
                    ->count()
            }}</div>
        </a>

        <a href="{{ route('admin.chapter.apex-pending') }}?chapter_id={{ $chapter->id }}" class="status-button apex-pending" title="View apex pending applications">
            <div class="status-icon apex-pending">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="status-label">Apex Pending</div>
            <div class="status-count">{{
                \App\Models\User::where('role', 'user')
                    ->where('chapter_id', $chapter->id)
                    ->where('submit_status', 'submited')
                    ->where('application_status', 'submitted')
                    ->whereHas('workflowStatus', function($q) {
                $q->where('apex_1_status', 'pending');
                    })
                    ->count()
            }}</div>
        </a>

        <a href="{{ route('admin.chapter.working-committee-pending') }}?chapter_id={{ $chapter->id }}" class="status-button working-committee-pending" title="View working committee pending applications">
            <div class="status-icon working-committee-pending">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="status-label">Working Committee Pending</div>
            <div class="status-count">{{
                \App\Models\User::where('role', 'user')
                    ->where('chapter_id', $chapter->id)
                    ->whereHas('workflowStatus', function($q) {
                        $q->where('chapter_status', 'approved')
                          ->where('working_committee_status', 'pending');
                    })
                    ->count()
            }}</div>
        </a>

        <a href="{{ route('admin.chapter.working-committee-approved') }}?chapter_id={{ $chapter->id }}" class="status-button working-committee-pending" title="View working committee pending applications">
            <div class="status-icon working-committee-pending">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="status-label">Working Committee Approved</div>
            <div class="status-count">{{
                \App\Models\User::where('role', 'user')
                    ->where('chapter_id', $chapter->id)
                    ->whereHas('workflowStatus', function($q) {
                        $q->where('chapter_status', 'approved')
                          ->where('working_committee_status', 'approved');
                    })
                    ->count()
            }}</div>
        </a>

        <a href="{{ route('admin.chapter.resubmit') }}?chapter_id={{ $chapter->id }}" class="status-button hold" title="View resubmit applications">
            <div class="status-icon hold">
                <i class="fas fa-redo"></i>
            </div>
            <div class="status-label">Hold (Resubmit)</div>
            <div class="status-count">{{
                \App\Models\User::where('role', 'user')
                    ->where('chapter_id', $chapter->id)
                    ->whereHas('workflowStatus', function($q) {
                        $q->where('apex_1_status', 'rejected');
                    })
                    ->count()
            }}</div>
        </a>

        <!-- Future buttons can be added here -->
    </div>
</div>
@endsection
