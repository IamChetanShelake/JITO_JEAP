@extends('website.layout.main')

@section('content')
    <style>
        .jitoMember-item1 p {
            font-family: 'Poppins';
            font-weight: 400;
            font-size: clamp(16px, 2.67vw, 20px);
            color: #5B5B5B;
        }

        .jitoMember-item3 p {
            font-family: 'Poppins';
            font-weight: 400;
            font-size: clamp(14px, 2.4vw, 18px);
            color: #5B5B5B;

        }


        .jitoMember-item3 ul {
            list-style-type: disc;
            padding-left: clamp(15px, 4vw, 25px);
            margin-top: 5px;
            /* important for proper bullet alignment */
        }

        .jitoMember-item3 ul li {
            font-family: 'Poppins';
            font-weight: 400;
            font-size: clamp(14px, 2.4vw, 18px);
            color: #5B5B5B;
            padding-left: 10px;
            display: list-item !important;
            list-style-type: disc !important;
        }

        .jitoMember-item3 a {
            text-decoration: underline;
            color: #5B5B5B;
        }

        .numbering {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .numbering p {
            font-family: 'Poppins';
            font-weight: 500;
            font-size: clamp(32px, 6.4vw, 48px);
            color: white;
        }

        .jitoMember {
            padding: clamp(10px, 2vw, 15px);
        }
    </style>
    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px;        max-width: 1400px;">

            .

            <!-- Header and Search Bar Row -->
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3 gap-lg-0 mb-4 mt-0"
                style="margin-top:-40px !important;">
                <!-- Header -->
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">Domestic</span> <span style="color: #393186;">(200 nirf)</span>
                    </h2>
                </div>

                <!-- Search Bar -->
                <div style="min-width: 300px; max-width: 400px;width: 100%;">
                    <div style="position: relative;">
                        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..."
                            style="width: 100%; padding: 12px 45px 12px 15px; border: 2px solid #1a237e; border-radius: 15px; font-family: 'Poppins'; font-size: 16px; outline: none; background-color: #ffffff;">
                        <i class="fas fa-search"
                            style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #1a237e; font-size: 18px;"></i>
                    </div>
                </div>
            </div>


            <div class="row  " style="margin-top:0px;">

                <!-- Entries Per Page Dropdown -->
                <div class="col-12 mb-3">
                    <div style="display: flex; align-items: center; gap: 10px; font-family: 'Poppins'; font-size: 16px; color: #5B5B5B;">
                        <span>Entries per page:</span>
                        <select id="entriesPerPage" onchange="updateEntries()" style="padding: 8px 35px 8px 12px; border: 1px solid #ccc; border-radius: 6px; font-family: 'Poppins'; font-size: 15px; cursor: pointer;">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="all">All</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 ">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th
                                        style="background-color: #393186; color: white; padding: 12px; text-align: left; font-family: 'Poppins'; font-weight: 500; font-size: 16px; border-right: 4px solid white;">
                                        Sr.No</th>
                                    <th
                                        style="background-color: #393186; color: white; padding: 12px; text-align: left; font-family: 'Poppins'; font-weight: 500; font-size: 16px; border-right: 4px solid white;">
                                        University Name</th>
                                    <th
                                        style="background-color: #393186; color: white; padding: 12px; text-align: left; font-family: 'Poppins'; font-weight: 500; font-size: 16px; border-right: 4px solid white;">
                                        City</th>
                                    <th
                                        style="background-color: #393186; color: white; padding: 12px; text-align: left; font-family: 'Poppins'; font-weight: 500; font-size: 16px;">
                                        State</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @forelse($universities as $index => $university)
                                <tr class="tableRow">
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        {{ $index + 1 }}</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        {{ $university->university_name }}</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        {{ $university->city ?? 'N/A' }}</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        {{ $university->state ?? 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr class="tableRow">
                                    <td colspan="4" style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px; text-align: center;">
                                        No domestic universities found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </section>
    <script>
        function updateEntries() {
            var selectedValue = document.getElementById('entriesPerPage').value;
            var rows = document.querySelectorAll('.tableRow');
            var count = 0;
            
            rows.forEach(function(row) {
                if (selectedValue === 'all') {
                    row.style.display = '';
                } else {
                    if (count < selectedValue) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                    count++;
                }
            });
        }

        function searchTable() {
            var input = document.getElementById('searchInput');
            var filter = input.value.toLowerCase();
            var rows = document.querySelectorAll('.tableRow');
            
            rows.forEach(function(row) {
                var text = row.textContent || row.innerText;
                if (text.toLowerCase().indexOf(filter) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Initialize with 10 entries
        updateEntries();
    </script>
@endsection
