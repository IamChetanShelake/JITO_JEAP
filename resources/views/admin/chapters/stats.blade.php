@extends('admin.layouts.master')

@section('title', 'Chapter Statistics - JitoJeap Admin')

@section('styles')
<style>
    :root {
        --primary-green: #4CAF50;
        --primary-purple: #393185;
        --primary-blue: #2196F3;
        --primary-yellow: #FFC107;
        --primary-red: #f44336;
        --text-dark: #2c3e50;
        --text-light: #7f8c8d;
        --bg-light: #f8f9fa;
        --border-color: #e9ecef;
    }

    .page-header {
        margin-bottom: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    @media (min-width: 768px) {
        .page-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .page-title-section {
        display: flex;
        flex-direction: column;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary-purple);
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
    }

    @media (min-width: 768px) {
        .page-title {
            font-size: 1.75rem;
        }
    }

    .page-subtitle {
        color: var(--text-light);
        font-size: 0.9rem;
    }

    @media (min-width: 768px) {
        .page-subtitle {
            font-size: 0.95rem;
        }
    }

    .back-btn {
        background-color: var(--primary-purple);
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 2px 8px rgba(57, 49, 133, 0.3);
        width: 100%;
        font-size: 0.9rem;
    }

    @media (min-width: 768px) {
        .back-btn {
            width: auto;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }
    }

    .back-btn:hover {
        background-color: #4a40a8;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(57, 49, 133, 0.4);
    }

    .back-btn i {
        font-size: 0.9rem;
    }

    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table-container {
        position: relative;
        width: 100%;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: var(--primary-green) transparent;
    }

    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: var(--primary-purple);
        border-radius: 3px;
    }

    .table {
        width: 100%;
        min-width: 800px;
        margin-bottom: 0;
        color: var(--text-dark);
    }

    .table thead th {
        background-color: var(--bg-light);
        color: var(--text-light);
        font-weight: 500;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border-color);
        padding: 1rem;
        vertical-align: middle;
        white-space: nowrap;
        position: sticky;
        top: 0;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        color: #555;
        font-size: 0.9rem;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
    }

    .status-badge {
        padding: 0.35rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .status-approved {
        background: #e8f5e9;
        color: var(--primary-green);
    }

    .status-pending {
        background: #fff8e1;
        color: var(--primary-yellow);
    }

    .status-hold {
        background: #ffebee;
        color: var(--primary-red);
    }

    .status-draft {
        background: #f5f5f5;
        color: #9e9e9e;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 0.1rem;
        transition: all 0.2s ease;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .action-btn.view-btn {
        background-color: #e3f2fd;
        color: var(--primary-blue);
    }

    .action-btn.view-btn:hover {
        background-color: var(--primary-blue);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #999;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #e0e0e0;
    }

    .actions-cell {
        display: flex;
        justify-content: center;
        gap: 0.2rem;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-section">
        <h1 class="page-title">
            <i class="fas fa-chart-bar" style="color: var(--primary-purple); margin-right: 0.5rem;"></i>
            Chapter Statistics
        </h1>
        <p class="page-subtitle">Overview of application statistics across all chapters</p>

         @php
            $totals = [
                'total_applied' => array_sum(array_column($chapterStats, 'total_applied')),
                'approved' => array_sum(array_column($chapterStats, 'approved')),
                'pending' => array_sum(array_column($chapterStats, 'pending')),
                'hold' => array_sum(array_column($chapterStats, 'hold')),
            ];
        @endphp

        <div class="card text-left">
          <img class="card-img-top"" alt="">
          <div class="card-body">
            <h4 class="card-title">Total Applications</h4>
            <p class="card-text">{{ $totals['total_applied'] }}</p>
          </div>
        </div>
    </div>
    <a href="{{ route('admin.home') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<div class="card">
    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%;">Seq</th>
                        <th style="width: 25%;">Chapter Name</th>
                        <th style="width: 12%;">Total Applied</th>
                        <th style="width: 12%;">zone</th>
                        <th style="width: 12%;">Chapter Head</th>
                        <th style="width: 12%;">City</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 7%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($chapterStats as $index => $stat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $stat['chapter']->chapter_name }}</strong>
                            @if($stat['chapter']->chapter_contact)
                                <br><small style="color: #666;">{{ $stat['chapter']->chapter_contact }}</small>
                            @endif
                        </td>
                        <td class="amount-cell">{{ $stat['total_applied'] }}</td>
                        <td class="amount-cell">{{ $stat['chapter']->zone->zone_name }}</td>
                        <td class="amount-cell">{{  $stat['chapter']->chapter_head  }}</td>
                        <td class="amount-cell">{{  $stat['chapter']->city }}</td>
                        <td>
                            @php
                                $status = 'Active';
                                $statusClass = 'status-approved';
                                $statusIcon = 'fas fa-check-circle';

                                if ($stat['total_applied'] == 0) {
                                    $status = 'No Applications';
                                    $statusClass = 'status-draft';
                                    $statusIcon = 'fas fa-minus-circle';
                                } elseif ($stat['approved'] > $stat['pending'] + $stat['hold']) {
                                    $status = 'High Performance';
                                    $statusClass = 'status-approved';
                                    $statusIcon = 'fas fa-trophy';
                                } elseif ($stat['pending'] > $stat['approved']) {
                                    $status = 'Needs Attention';
                                    $statusClass = 'status-pending';
                                    $statusIcon = 'fas fa-exclamation-triangle';
                                }
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                <i class="{{ $statusIcon }}" style="font-size: 0.6rem;"></i>
                                {{ $status }}
                            </span>
                        </td>
                        <td class="actions-cell">
                            <a href="{{ route('admin.chapter.details', $stat['chapter']->id) }}" class="action-btn view-btn" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="fas fa-chart-bar"></i>
                            <p>No chapter data available.</p>
                        </td>
                    </tr>
                    @endforelse

                    <!-- Totals Row -->
                    @if($chapterStats && count($chapterStats) > 0)
                    @php
                        $totals = [
                            'total_applied' => array_sum(array_column($chapterStats, 'total_applied')),
                            'approved' => array_sum(array_column($chapterStats, 'approved')),
                            'pending' => array_sum(array_column($chapterStats, 'pending')),
                            'hold' => array_sum(array_column($chapterStats, 'hold')),
                        ];
                    @endphp
                    {{-- <tr style="background-color: #f8f9fa; font-weight: 600;">
                        <td colspan="2"><strong>Total Across All Chapters</strong></td>
                        <td class="amount-cell">{{ $totals['total_applied'] }}</td>
                        <td class="amount-cell">{{ $totals['approved'] }}</td>
                        <td class="amount-cell">{{ $totals['pending'] }}</td>
                        <td class="amount-cell">{{ $totals['hold'] }}</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> --}}
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
