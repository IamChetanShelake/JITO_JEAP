@extends('admin.layouts.master')

@section('title', 'Graphwise Details Report')

@section('content')
    <div class="container-fluid">
        <div class="report-card">
            <div class="report-header">
                <div>
                    <h2>GRAPHWISE DETAILS REPORT</h2>
                    <p class="text-muted">Financial Assistance Management Report</p>
                </div>
                @if (!$renderForPdf)
                    <a class="btn btn-sm btn-primary"
                        href="{{ route('admin.reports.financial_graph_report', ['format' => 'pdf', 'start_date' => $startDate, 'end_date' => $endDate]) }}">
                        Download PDF
                    </a>
                @endif
            </div>

            <div class="report-meta">
                <div><strong>From:</strong> {{ $startDate }}</div>
                <div><strong>To:</strong> {{ $endDate }}</div>
            </div>

            <div class="section">
                <h4>Course Type Distribution (Domestic vs Foreign)</h4>
                <div class="chart-grid">
                    @if ($renderForPdf)
                        <div class="bar-list">
                            @foreach ($courseTypeStats as $faType => $data)
                                @php
                                    $max = max($data['UG'], $data['PG'], 1);
                                @endphp
                                <div class="bar-row">
                                    <div class="bar-label">{{ $faType }} UG</div>
                                    <div class="bar-track">
                                        <div class="bar-fill" style="width: {{ ($data['UG'] / $max) * 100 }}%;">
                                        </div>
                                    </div>
                                    <div class="bar-value">{{ $data['UG'] }}</div>
                                </div>
                                <div class="bar-row">
                                    <div class="bar-label">{{ $faType }} PG</div>
                                    <div class="bar-track">
                                        <div class="bar-fill" style="width: {{ ($data['PG'] / $max) * 100 }}%;">
                                        </div>
                                    </div>
                                    <div class="bar-value">{{ $data['PG'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <canvas id="courseTypeChart" height="140"></canvas>
                    @endif
                </div>
            </div>

            <div class="section total-apps">
                <h4>Total Applications</h4>
                <div class="big-number">{{ $totalApplications }}</div>
            </div>

            <div class="section">
                <h4>Zone Wise Application Distribution</h4>
                @if ($renderForPdf)
                    <div class="bar-list">
                        @php $max = max($zoneCounts->values()->all() ?: [1]); @endphp
                        @foreach ($zoneCounts as $zone => $count)
                            <div class="bar-row">
                                <div class="bar-label">{{ $zone }}</div>
                                <div class="bar-track">
                                    <div class="bar-fill" style="width: {{ ($count / $max) * 100 }}%;"></div>
                                </div>
                                <div class="bar-value">{{ $count }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <canvas id="zoneChart" height="180"></canvas>
                @endif
            </div>

            <div class="section">
                <h4>Chapter Wise Application Distribution</h4>
                @if ($renderForPdf)
                    <div class="bar-list">
                        @php $max = max($chapterCounts->values()->all() ?: [1]); @endphp
                        @foreach ($chapterCounts as $chapter => $count)
                            <div class="bar-row">
                                <div class="bar-label">{{ $chapter }}</div>
                                <div class="bar-track">
                                    <div class="bar-fill" style="width: {{ ($count / $max) * 100 }}%;"></div>
                                </div>
                                <div class="bar-value">{{ $count }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <canvas id="chapterChart" height="180"></canvas>
                @endif
            </div>

            <div class="section">
                <h4>Rejected Applications (Zone Wise)</h4>
                @if ($renderForPdf)
                    <div class="bar-list">
                        @php $max = max($rejectedByZone->values()->all() ?: [1]); @endphp
                        @foreach ($rejectedByZone as $zone => $count)
                            <div class="bar-row">
                                <div class="bar-label">{{ $zone }}</div>
                                <div class="bar-track">
                                    <div class="bar-fill" style="width: {{ ($count / $max) * 100 }}%;"></div>
                                </div>
                                <div class="bar-value">{{ $count }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <canvas id="rejectedChart" height="160"></canvas>
                @endif
            </div>

            <div class="section">
                <h4>Financial Summary (in Crores)</h4>
                @php
                    $donationsCr = round($financialSummary['donations'] / 10000000, 2);
                    $sanctionedCr = round($financialSummary['sanctioned'] / 10000000, 2);
                    $disbursedCr = round($financialSummary['disbursed'] / 10000000, 2);
                @endphp
                @if ($renderForPdf)
                    <div class="bar-list">
                        @php $max = max([$donationsCr, $sanctionedCr, $disbursedCr, 1]); @endphp
                        <div class="bar-row">
                            <div class="bar-label">Donations</div>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ ($donationsCr / $max) * 100 }}%;"></div>
                            </div>
                            <div class="bar-value">{{ $donationsCr }}</div>
                        </div>
                        <div class="bar-row">
                            <div class="bar-label">Sanctioned</div>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ ($sanctionedCr / $max) * 100 }}%;"></div>
                            </div>
                            <div class="bar-value">{{ $sanctionedCr }}</div>
                        </div>
                        <div class="bar-row">
                            <div class="bar-label">Disbursed</div>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ ($disbursedCr / $max) * 100 }}%;"></div>
                            </div>
                            <div class="bar-value">{{ $disbursedCr }}</div>
                        </div>
                    </div>
                @else
                    <canvas id="financialChart" height="140"></canvas>
                @endif
            </div>

            <div class="section">
                <h4>Committee Members / Donors</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Zone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($committeeMembers as $member)
                            <tr>
                                <td>{{ $member['name'] }}</td>
                                <td>{{ $member['zone'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .report-card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .report-meta {
            display: flex;
            gap: 20px;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 24px;
        }

        .total-apps .big-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1f2937;
        }

        .bar-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .bar-row {
            display: grid;
            grid-template-columns: 160px 1fr 80px;
            gap: 8px;
            align-items: center;
        }

        .bar-label {
            font-size: 0.85rem;
            color: #444;
        }

        .bar-track {
            height: 10px;
            background: #f0f0f0;
            border-radius: 6px;
            overflow: hidden;
        }

        .bar-fill {
            height: 10px;
            background: #4f46e5;
        }

        .bar-value {
            font-size: 0.85rem;
            text-align: right;
            color: #333;
        }
    </style>
@endsection

@if (!$renderForPdf)
    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @php
            $financialSummaryCr = [
                'donations' => round($financialSummary['donations'] / 10000000, 2),
                'sanctioned' => round($financialSummary['sanctioned'] / 10000000, 2),
                'disbursed' => round($financialSummary['disbursed'] / 10000000, 2),
            ];
        @endphp
        <script>
            const courseTypeData = @json($courseTypeStats);
            const zoneCounts = @json($zoneCounts->toArray());
            const chapterCounts = @json($chapterCounts->toArray());
            const rejectedByZone = @json($rejectedByZone->toArray());
            const financialSummary = @json($financialSummaryCr);

            new Chart(document.getElementById('courseTypeChart'), {
                type: 'bar',
                data: {
                    labels: ['UG', 'PG'],
                    datasets: [{
                        label: 'Domestic',
                        data: [courseTypeData.Domestic.UG, courseTypeData.Domestic.PG],
                        backgroundColor: '#4f46e5'
                    }, {
                        label: 'Foreign',
                        data: [courseTypeData.Foreign.UG, courseTypeData.Foreign.PG],
                        backgroundColor: '#22c55e'
                    }]
                }
            });

            new Chart(document.getElementById('zoneChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(zoneCounts),
                    datasets: [{
                        label: 'Applications',
                        data: Object.values(zoneCounts),
                        backgroundColor: '#3b82f6'
                    }]
                },
                options: {
                    indexAxis: 'y'
                }
            });

            new Chart(document.getElementById('chapterChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(chapterCounts),
                    datasets: [{
                        label: 'Applications',
                        data: Object.values(chapterCounts),
                        backgroundColor: '#f59e0b'
                    }]
                }
            });

            new Chart(document.getElementById('rejectedChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(rejectedByZone),
                    datasets: [{
                        label: 'Rejected',
                        data: Object.values(rejectedByZone),
                        backgroundColor: '#ef4444'
                    }]
                }
            });

            new Chart(document.getElementById('financialChart'), {
                type: 'bar',
                data: {
                    labels: ['Donations', 'Sanctioned', 'Disbursed'],
                    datasets: [{
                        label: 'Amount (Cr)',
                        data: [financialSummary.donations, financialSummary.sanctioned, financialSummary.disbursed],
                        backgroundColor: ['#10b981', '#6366f1', '#f97316']
                    }]
                }
            });
        </script>
    @endsection
@endif
