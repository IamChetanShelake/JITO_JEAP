<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: dejavusans, Arial, sans-serif;
            font-size: 10px;
            color: #222;
            background: #fff;
        }

        .page-title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            color: #1f497d;
            margin-bottom: 14px;
            letter-spacing: 0.5px;
        }

        .card {
            border: 1px solid #bbb;
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .brand-bar {
            width: 100%;
            background: #fff;
            border-bottom: 1px solid #ddd;
            padding: 5px 8px;
            height: 58px;
        }

        .brand-bar-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            height: 58px;
        }

        .brand-cell-left {
            width: 15%;
            vertical-align: top;
            text-align: left;
        }

        .brand-cell-mid {
            width: 70%;
            vertical-align: middle;
            text-align: center;
        }

        .brand-cell-right {
            width: 15%;
            vertical-align: top;
            text-align: right;
        }

        .brand-name {
            font-size: 11px;
            font-weight: bold;
            color: #1f497d;
            letter-spacing: 0.5px;
        }

        .brand-logo-img {
            height: 45px;
            width: auto;
            display: block;
        }

        .jito-logo {
            display: inline-block;
            font-size: 10px;
            font-weight: bold;
            border: 1px solid #ccc;
            padding: 1px 3px;
        }

        .jito-j {
            color: #1f497d;
        }

        .jito-i {
            color: #ff0000;
        }

        .jito-t {
            color: #ffc000;
        }

        .jito-o {
            color: #70ad47;
        }

        .card-body {
            padding: 10px 12px;
        }

        .chart-title-white {
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 4px 6px;
            text-align: center;
        }

        th {
            background-color: #dce6f1;
            font-weight: bold;
            color: #1f497d;
        }

        .td-dom {
            text-align: left;
            color: #ed7d31;
            font-weight: bold;
        }

        .td-for {
            text-align: left;
            color: #ffc000;
            font-weight: bold;
        }

        .td-bold {
            text-align: left;
            font-weight: bold;
        }

        .td-name {
            text-align: left;
            color: #1f497d;
            font-weight: bold;
        }

        .td-zone {
            color: #1f497d;
            font-weight: bold;
        }

        .total-bar {
            text-align: center;
            color: #1f497d;
            font-weight: bold;
            font-size: 10px;
            background: #e2efda;
            padding: 4px;
            margin-top: 4px;
            border: 1px solid #a9c47a;
        }
    </style>
</head>

<body>

    {{-- PAGE TITLE --}}
    <div class="page-title">SNAPSHOT AS ON Period: From {{ $startDate }} to {{ $endDate }}</div>

    {{-- DONORS CARD --}}
    <div class="card">
        <div class="brand-bar">
            <table class="brand-bar-table">
                <tr>
                    <td class="brand-cell-left">
                        <img src="{{ public_path('image 1.png') }}" alt="Logo" class="brand-logo-img">
                    </td>
                    <td class="brand-cell-mid">
                        <span class="brand-name">JITO EDUCATION ASSISTANCE FOUNDATION</span><br>
                        <span style="font-size:9px; color:#1f497d; font-weight:bold;">FULLY PAID JEAP DONORS WHO
                            CONTRIBUTED 54
                            LACS</span>
                    </td>
                    <td class="brand-cell-right">
                        <img src="{{ public_path('jitojeaplogo.png') }}" alt="Logo" class="brand-logo-img">
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th style="width:7%">SR.NO.</th>
                        <th style="width:65%">NAME</th>
                        <th style="width:28%">ZONE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($committeeMembers as $i => $member)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="td-name">{{ $member['name'] }}</td>
                            <td class="td-zone">{{ $member['zone'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- COURSE TYPE --}}
    @php
        $ugDom = $courseTypeStats['Domestic']['UG'] ?? 0;
        $pgDom = $courseTypeStats['Domestic']['PG'] ?? 0;
        $ugFor = $courseTypeStats['Foreign']['UG'] ?? 0;
        $pgFor = $courseTypeStats['Foreign']['PG'] ?? 0;
        $cW = 500;
        $cH = 280;
        $pL = 50;
        $pR = 15;
        $pT = 20;
        $pB = 60;
        $iW = $cW - $pL - $pR;
        $iH = $cH - $pT - $pB;
        $base = $pT + $iH;
        $groups = [['UNDER GRADUATE COURSE', $ugDom, $ugFor], ['POST GRADUATE COURSE', $pgDom, $pgFor]];
        $gW = $iW / 2;
        $bW = $gW * 0.28;
        $gap = $gW * 0.06;
        $gPad = ($gW - 2 * $bW - $gap) / 2;
        $maxVal = max($ugDom, $pgDom, $ugFor, $pgFor, 1);
        $yStep = ceil($maxVal / 5 / 10) * 10;
        if ($yStep == 0) {
            $yStep = 1;
        }
        $yMax = $yStep * 5;
    @endphp
    <div class="card">
        <div class="brand-bar">
            <table class="brand-bar-table">
                <tr>
                    <td class="brand-cell-left">
                        <img src="{{ public_path('image 1.png') }}" alt="Logo" class="brand-logo-img">
                    </td>
                    <td class="brand-cell-mid">
                        <span class="brand-name">JITO EDUCATION ASSISTANCE FOUNDATION</span>
                    </td>
                    <td class="brand-cell-right">
                        <img src="{{ public_path('jitojeaplogo.png') }}" alt="Logo" class="brand-logo-img">
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-body" style="padding:0;">
            <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#6da946" style="background-color:#6da946;">
                <tr>
                    <td style="padding:10px 12px;">
                        <div class="chart-title-white">COURSE TYPE DISTRIBUTION OF SANCTIONED FA APPLICATIONS</div>
                        <svg width="{{ $cW }}" height="{{ $cH }}"
                            viewBox="0 0 {{ $cW }} {{ $cH }}">
                            @for ($t = 0; $t <= 5; $t++)
                                @php
                                    $yv = $yStep * $t;
                                    $yp = $pT + $iH - ($iH * $yv) / $yMax;
                                @endphp
                                <line x1="{{ $pL }}" y1="{{ $yp }}" x2="{{ $cW - $pR }}"
                                    y2="{{ $yp }}" stroke="rgba(255,255,255,0.35)" stroke-width="0.7" />
                                <text x="{{ $pL - 4 }}" y="{{ $yp + 3.5 }}" text-anchor="end" font-size="9"
                                    fill="#fff">{{ $yv }}</text>
                            @endfor
                            <line x1="{{ $pL }}" y1="{{ $pT }}" x2="{{ $pL }}"
                                y2="{{ $base }}" stroke="#fff" stroke-width="1.2" />
                            <line x1="{{ $pL }}" y1="{{ $base }}" x2="{{ $cW - $pR }}"
                                y2="{{ $base }}" stroke="#fff" stroke-width="1.2" />
                            @foreach ($groups as $gi => $g)
                                @php
                                    $gx = $pL + $gi * $gW + $gPad;
                                    $domX = $gx;
                                    $forX = $gx + $bW + $gap;
                                    $domH = $yMax > 0 ? ($g[1] / $yMax) * $iH : 0;
                                    $forH = $yMax > 0 ? ($g[2] / $yMax) * $iH : 0;
                                @endphp
                                <rect x="{{ $domX }}" y="{{ $base - max($domH, 1) }}"
                                    width="{{ $bW }}" height="{{ max($domH, 1) }}" fill="#ed7d31" />
                                @if ($g[1] > 0)
                                    <text x="{{ $domX + $bW / 2 }}" y="{{ $base - $domH - 4 }}" text-anchor="middle"
                                        font-size="9" fill="#fff" font-weight="bold">{{ $g[1] }}</text>
                                @endif
                                <rect x="{{ $forX }}" y="{{ $base - max($forH, 1) }}"
                                    width="{{ $bW }}" height="{{ max($forH, 1) }}" fill="#ffc000" />
                                @if ($g[2] > 0)
                                    <text x="{{ $forX + $bW / 2 }}" y="{{ $base - $forH - 4 }}" text-anchor="middle"
                                        font-size="9" fill="#fff" font-weight="bold">{{ $g[2] }}</text>
                                @endif
                                @php
                                    $parts = explode(' ', $g[0]);
                                    $mid = $gx + $bW + $gap / 2;
                                @endphp
                                @foreach ($parts as $pi => $part)
                                    <text x="{{ $mid }}" y="{{ $base + 14 + $pi * 11 }}" text-anchor="middle"
                                        font-size="8.5" fill="#fff" font-weight="bold">{{ $part }}</text>
                                @endforeach
                            @endforeach
                            <rect x="{{ $pL }}" y="{{ $cH - 16 }}" width="12" height="12"
                                fill="#ed7d31" />
                            <text x="{{ $pL + 15 }}" y="{{ $cH - 6 }}" font-size="9" fill="#0000"
                                font-weight="bold">DOMESTIC FA</text>
                            <rect x="{{ $pL + 105 }}" y="{{ $cH - 16 }}" width="12" height="12"
                                fill="#ffc000" />
                            <text x="{{ $pL + 120 }}" y="{{ $cH - 6 }}" font-size="9" fill="#0000"
                                font-weight="bold">FOREIGN FA</text>
                        </svg>
                        <table style="background:#fff; margin-top:8px;">
                            <thead>
                                <tr>
                                    <th style="width:30%;text-align:left;"></th>
                                    <th>UNDER GRADUATE COURSE</th>
                                    <th>POST GRADUATE COURSE</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="td-dom">DOMESTIC FA</td>
                                    <td>{{ $ugDom }}</td>
                                    <td>{{ $pgDom }}</td>
                                    <td>{{ $ugDom + $pgDom }}</td>
                                </tr>
                                <tr>
                                    <td class="td-for">FOREIGN FA</td>
                                    <td>{{ $ugFor }}</td>
                                    <td>{{ $pgFor }}</td>
                                    <td>{{ $ugFor + $pgFor }}</td>
                                </tr>
                                <tr>
                                    <td class="td-bold">TOTAL FA</td>
                                    <td>{{ $ugDom + $ugFor }}</td>
                                    <td>{{ $pgDom + $pgFor }}</td>
                                    <td>{{ $totalApplications }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ZONE WISE --}}
    @php
        $zones = $zoneCounts->toArray();
        $zNames = array_keys($zones);
        $zVals = array_values($zones);
        $zMax = max(array_merge($zVals, [1]));
        $zN = count($zones);
        $zBH = 22;
        $zGap = 10;
        $zPL = 110;
        $zPR = 70;
        $zPT = 12;
        $zPB = 30;
        $zCW = 500;
        $zIW = $zCW - $zPL - $zPR;
        $zCH = $zPT + $zPB + $zN * ($zBH + $zGap);
        $zXMax = (ceil($zMax / 50) + 1) * 50;
        if ($zXMax == 0) {
            $zXMax = 10;
        }
    @endphp
    <div class="card">
        <div class="brand-bar">
            <table class="brand-bar-table">
                <tr>
                    <td class="brand-cell-left">
                        <img src="{{ public_path('image 1.png') }}" alt="Logo" class="brand-logo-img">
                    </td>
                    <td class="brand-cell-mid">
                        <span class="brand-name">JITO EDUCATION ASSISTANCE FOUNDATION</span>
                    </td>
                    <td class="brand-cell-right">
                        <img src="{{ public_path('jitojeaplogo.png') }}" alt="Logo" class="brand-logo-img">
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-body" style="background:#e2efda;">
            <svg width="{{ $zCW }}" height="{{ $zCH }}"
                viewBox="0 0 {{ $zCW }} {{ $zCH }}">
                @for ($t = 0; $t <= 5; $t++)
                    @php
                        $xv = round(($zXMax * $t) / 5);
                        $xp = $zPL + ($zIW * $t) / 5;
                    @endphp
                    <line x1="{{ $xp }}" y1="{{ $zPT }}" x2="{{ $xp }}"
                        y2="{{ $zCH - $zPB }}" stroke="rgba(0,0,0,0.1)" stroke-width="0.7" />
                    <text x="{{ $xp }}" y="{{ $zCH - $zPB + 12 }}" text-anchor="middle" font-size="8.5"
                        fill="#555">{{ $xv }}</text>
                @endfor
                @foreach ($zNames as $zi => $zn)
                    @php
                        $bw = $zXMax > 0 ? ($zVals[$zi] / $zXMax) * $zIW : 2;
                        $by = $zPT + $zi * ($zBH + $zGap);
                    @endphp
                    <text x="{{ $zPL - 6 }}" y="{{ $by + $zBH * 0.7 }}" text-anchor="end" font-size="9.5"
                        fill="#1f497d" font-weight="bold">{{ $zn }}</text>
                    <rect x="{{ $zPL }}" y="{{ $by }}" width="{{ max($bw, 3) }}"
                        height="{{ $zBH }}" fill="#548235" rx="2" />
                    <text x="{{ $zPL + max($bw, 3) + 5 }}" y="{{ $by + $zBH * 0.7 }}" font-size="9.5" fill="#1f497d"
                        font-weight="bold">{{ $zVals[$zi] }}</text>
                @endforeach
                <rect x="{{ $zPL }}" y="{{ $zCH - $zPB + 18 }}" width="11" height="11"
                    fill="#548235" />
                <text x="{{ $zPL + 14 }}" y="{{ $zCH - $zPB + 27 }}" font-size="8.5" fill="#555">TOTAL</text>
            </svg>
            <div class="total-bar">TOTAL APPLICATIONS - {{ $totalApplications }}</div>
        </div>
    </div>

    {{-- CHAPTERWISE --}}
    @php
        $chaps = $chapterCounts->toArray();
        $cNames = array_keys($chaps);
        $cVals = array_values($chaps);
        $cMax = max(array_merge($cVals, [1]));
        $cN = count($chaps);
        $cBH = 12;
        $cGap = 4;
        $cPL = 145;
        $cPR = 45;
        $cPT = 10;
        $cPB = 25;
        $cCW = 500;
        $cIW = $cCW - $cPL - $cPR;
        $cCH = $cPT + $cPB + $cN * ($cBH + $cGap);
        $cXMax = (ceil($cMax / 20) + 1) * 20;
        if ($cXMax == 0) {
            $cXMax = 10;
        }
    @endphp
    <div class="card">
        <div class="brand-bar">
            <table class="brand-bar-table">
                <tr>
                    <td class="brand-cell-left">
                        <img src="{{ public_path('image 1.png') }}" alt="Logo" class="brand-logo-img">
                    </td>
                    <td class="brand-cell-mid">
                        <span class="brand-name">CHAPTERWISE APPLICATIONS SANCTIONED</span>
                    </td>
                    <td class="brand-cell-right">
                        <img src="{{ public_path('jitojeaplogo.png') }}" alt="Logo" class="brand-logo-img">
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-body">
            <svg width="{{ $cCW }}" height="{{ $cCH }}"
                viewBox="0 0 {{ $cCW }} {{ $cCH }}">
                @for ($t = 0; $t <= 5; $t++)
                    @php
                        $xv = round(($cXMax * $t) / 5);
                        $xp = $cPL + ($cIW * $t) / 5;
                    @endphp
                    <line x1="{{ $xp }}" y1="{{ $cPT }}" x2="{{ $xp }}"
                        y2="{{ $cCH - $cPB }}" stroke="rgba(0,0,0,0.08)" stroke-width="0.7" />
                    <text x="{{ $xp }}" y="{{ $cCH - $cPB + 11 }}" text-anchor="middle" font-size="7.5"
                        fill="#888">{{ $xv }}</text>
                @endfor
                @foreach ($cNames as $ci => $cn)
                    @php
                        $bw = $cXMax > 0 ? ($cVals[$ci] / $cXMax) * $cIW : 2;
                        $by = $cPT + $ci * ($cBH + $cGap);
                    @endphp
                    <text x="{{ $cPL - 4 }}" y="{{ $by + $cBH * 0.75 }}" text-anchor="end" font-size="7.5"
                        fill="#1f497d">{{ $cn }}</text>
                    <rect x="{{ $cPL }}" y="{{ $by }}" width="{{ max($bw, 2) }}"
                        height="{{ $cBH }}" fill="#4472c4" rx="1" />
                    <text x="{{ $cPL + max($bw, 2) + 4 }}" y="{{ $by + $cBH * 0.75 }}" font-size="7.5"
                        fill="#1f497d">{{ $cVals[$ci] }}</text>
                @endforeach
            </svg>
            <div style="text-align:center; font-size:9px; color:#1f497d; font-weight:bold; margin-top:4px;">TOTAL
                APPLICATIONS - {{ $totalApplications }}</div>
        </div>
    </div>

    {{-- REJECTED --}}
    @php
        $rZones = $rejectedByZone->toArray();
        $rNames = array_keys($rZones);
        $rVals = array_values($rZones);
        $rTotal = array_sum($rVals);
        $rMax = max(array_merge($rVals, [1]));
        $rN = count($rZones);
        $rBH = 22;
        $rGap = 10;
        $rPL = 110;
        $rPR = 70;
        $rPT = 12;
        $rPB = 30;
        $rCW = 500;
        $rIW = $rCW - $rPL - $rPR;
        $rCH = max(80, $rPT + $rPB + $rN * ($rBH + $rGap));
        $rXMax = (ceil($rMax / 10) + 1) * 10;
        if ($rXMax <= 0) {
            $rXMax = 10;
        }
    @endphp
    <div class="card">
        <div class="brand-bar">
            <table class="brand-bar-table">
                <tr>
                    <td class="brand-cell-left">
                        <img src="{{ public_path('image 1.png') }}" alt="Logo" class="brand-logo-img">
                    </td>
                    <td class="brand-cell-mid">
                        <span class="brand-name">JITO EDUCATION ASSISTANCE FOUNDATION</span><br>
                        <span style="font-size:9px; color:#c00; font-weight:bold;">APPLICATIONS REJECTED
                            -{{ $rTotal }}</span>
                    </td>
                    <td class="brand-cell-right">
                        <img src="{{ public_path('jitojeaplogo.png') }}" alt="Logo" class="brand-logo-img">
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-body">
            @if ($rTotal > 0)
                <svg width="{{ $rCW }}" height="{{ $rCH }}"
                    viewBox="0 0 {{ $rCW }} {{ $rCH }}">
                    @for ($t = 0; $t <= 6; $t++)
                        @php
                            $xv = round(($rXMax * $t) / 6);
                            $xp = $rPL + ($rIW * $t) / 6;
                        @endphp
                        <line x1="{{ $xp }}" y1="{{ $rPT }}" x2="{{ $xp }}"
                            y2="{{ $rCH - $rPB }}" stroke="rgba(0,0,0,0.1)" stroke-width="0.7" />
                        <text x="{{ $xp }}" y="{{ $rCH - $rPB + 12 }}" text-anchor="middle"
                            font-size="8.5" fill="#555">{{ $xv }}</text>
                    @endfor
                    @foreach ($rNames as $ri => $rn)
                        @php
                            $bw = $rXMax > 0 ? ($rVals[$ri] / $rXMax) * $rIW : 2;
                            $by = $rPT + $ri * ($rBH + $rGap);
                        @endphp
                        <text x="{{ $rPL - 6 }}" y="{{ $by + $rBH * 0.7 }}" text-anchor="end" font-size="9.5"
                            fill="#1f497d" font-weight="bold">{{ $rn }}</text>
                        <rect x="{{ $rPL }}" y="{{ $by }}" width="{{ max($bw, 3) }}"
                            height="{{ $rBH }}" fill="#e0dede" stroke="#bbb" stroke-width="0.5"
                            rx="2" />
                        <text x="{{ $rPL + max($bw, 3) + 5 }}" y="{{ $by + $rBH * 0.7 }}" font-size="9.5"
                            fill="#1f497d" font-weight="bold">{{ $rVals[$ri] }}</text>
                    @endforeach
                    <rect x="{{ $rPL }}" y="{{ $rCH - $rPB + 18 }}" width="11" height="11"
                        fill="#e0dede" stroke="#bbb" stroke-width="0.5" />
                    <text x="{{ $rPL + 14 }}" y="{{ $rCH - $rPB + 27 }}" font-size="8.5"
                        fill="#555">TOTAL</text>
                </svg>
                <table style="margin-top:8px; font-size:9px;">
                    <tbody>
                        <tr>
                            @foreach ($rNames as $n)
                                <th>{{ $n }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach ($rVals as $v)
                                <td>{{ $v }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            @else
                <div style="text-align:center; color:#999; padding:10px; font-size:9px;">No rejected applications in
                    this period.</div>
            @endif
        </div>
    </div>

    {{-- FINANCIAL SUMMARY --}}
    @php
        $donCr = round(($financialSummary['donations'] ?? 0) / 10000000, 2);
        $sanCr = round(($financialSummary['sanctioned'] ?? 0) / 10000000, 2);
        $disCr = round(($financialSummary['disbursed'] ?? 0) / 10000000, 2);
        $fVals = [$donCr, $sanCr, $disCr];
        $fLabels = [['TOTAL DONATIONS', 'RECEIVED'], ['TOTAL AMOUNT', 'SANCTIONED'], ['TOTAL AMOUNT', 'DISBURSED']];
        $fMax = max(array_merge($fVals, [0.01]));
        $fCeil = ceil($fMax / 5) * 5;
        if ($fCeil == 0) {
            $fCeil = 1;
        }
        $fCW = 500;
        $fCH = 270;
        $fPL = 50;
        $fPR = 15;
        $fPT = 20;
        $fPB = 55;
        $fIW = $fCW - $fPL - $fPR;
        $fIH = $fCH - $fPT - $fPB;
        $fBase = $fPT + $fIH;
        $fN = count($fVals);
        $fBW = $fIW / ($fN * 2.6);
        $fSp = $fIW / $fN;
    @endphp
    <div class="card">
        <div class="brand-bar">
            <table class="brand-bar-table">
                <tr>
                    <td class="brand-cell-left">
                        <img src="{{ public_path('image 1.png') }}" alt="Logo" class="brand-logo-img">
                    </td>
                    <td class="brand-cell-mid">
                        <span class="brand-name">JITO EDUCATION ASSISTANCE FOUNDATION</span><br>
                        <span style="font-size:9px; color:#ed7d31; font-weight:bold;">AMOUNT (RS. IN CRORES)</span>
                    </td>
                    <td class="brand-cell-right">
                        <img src="{{ public_path('jitojeaplogo.png') }}" alt="Logo" class="brand-logo-img">
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-body">
            <svg width="{{ $fCW }}" height="{{ $fCH }}"
                viewBox="0 0 {{ $fCW }} {{ $fCH }}">
                @for ($t = 0; $t <= 5; $t++)
                    @php
                        $yv = round(($fCeil * $t) / 5, 2);
                        $yp = $fPT + $fIH - ($fIH * $t) / 5;
                    @endphp
                    <line x1="{{ $fPL }}" y1="{{ $yp }}" x2="{{ $fCW - $fPR }}"
                        y2="{{ $yp }}" stroke="#ddd" stroke-width="0.8" stroke-dasharray="3,3" />
                    <text x="{{ $fPL - 4 }}" y="{{ $yp + 3.5 }}" text-anchor="end" font-size="8.5"
                        fill="#666">{{ $yv }}</text>
                @endfor
                <line x1="{{ $fPL }}" y1="{{ $fPT }}" x2="{{ $fPL }}"
                    y2="{{ $fBase }}" stroke="#aaa" stroke-width="1.2" />
                <line x1="{{ $fPL }}" y1="{{ $fBase }}" x2="{{ $fCW - $fPR }}"
                    y2="{{ $fBase }}" stroke="#aaa" stroke-width="1.2" />
                @foreach ($fVals as $fi => $fv)
                    @php
                        $bh = $fCeil > 0 ? ($fv / $fCeil) * $fIH : 0;
                        $bx = $fPL + $fi * $fSp + ($fSp - $fBW) / 2;
                    @endphp
                    <rect x="{{ $bx }}" y="{{ $fBase - max($bh, 1) }}" width="{{ $fBW }}"
                        height="{{ max($bh, 1) }}" fill="#4472c4" rx="2" />
                    @if ($bh > 16)
                        <text x="{{ $bx + $fBW / 2 }}" y="{{ $fBase - $bh + 14 }}" text-anchor="middle"
                            font-size="9" fill="#fff" font-weight="bold">{{ $fv }}</text>
                    @else
                        <text x="{{ $bx + $fBW / 2 }}" y="{{ $fBase - max($bh, 1) - 4 }}" text-anchor="middle"
                            font-size="9" fill="#1f497d" font-weight="bold">{{ $fv }}</text>
                    @endif
                    @foreach ($fLabels[$fi] as $li => $lp)
                        <text x="{{ $bx + $fBW / 2 }}" y="{{ $fBase + 14 + $li * 11 }}" text-anchor="middle"
                            font-size="8" fill="#555" font-weight="bold">{{ $lp }}</text>
                    @endforeach
                @endforeach
            </svg>
        </div>
    </div>

</body>

</html>
