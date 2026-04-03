@extends('admin.layouts.master')

@section('title', 'Applications Dynamic View')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dynamic View System</h3>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="d-flex align-items-center">
                            <span>Group By: </span>
                            <span id="group-by-selected" class="ml-2 text-muted" style="font-size: 20px;"></span>
                        </h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="toggle-group-fields-btn"
                            data-toggle="modal" data-target="#groupFieldsModal">
                            Add Custom Group
                        </button>
                        <div id="group-list" class="mt-2"></div>
                    </div>
                    {{-- <div class="col-md-6">
                        <h5>Filters (JSON)</h5>
                        <textarea class="form-control" rows="4" id="filters-json"
                            placeholder='{"status":"approved"}'></textarea>
                    </div> --}}
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <button class="btn btn-success" id="apply-grouping-btn">Apply Grouping</button>
                        <button class="btn btn-outline-secondary" id="reset-view-btn">Reset</button>
                        <button class="btn btn-info" id="export-view-btn">Export</button>
                    </div>
                    <div class="d-flex">
                        <select class="form-control form-control-sm mr-2" id="saved-view-select">
                            <option value="">Select Saved View</option>
                        </select>
                        <button class="btn btn-sm btn-outline-primary mr-2" id="load-view-btn">Load View</button>
                        <input type="text" class="form-control form-control-sm mr-2" id="view-name"
                            placeholder="Favorite View Name">
                        <button class="btn btn-sm btn-primary" id="save-view-btn">Save View</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="applications-table">
                        <thead>
                            <tr id="table-head-row">
                                @foreach ($defaultColumns as $col)
                                    <th>{{ $availableColumns[$col] ?? $col }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach ($records as $record)
                                <tr class="record-row" data-url="{{ $record['detail_url'] ?? '' }}">
                                    @foreach ($defaultColumns as $col)
                                        <td>{{ $record[$col] ?? '' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .group-row {
            background: #f6f8fb;
            font-weight: 600;
        }

        .group-toggle {
            cursor: pointer;
            margin-right: 6px;
        }

        .group-indent {
            display: inline-block;
            width: 16px;
        }

        .record-row {
            background: #fff;
            cursor: pointer;
        }

        .group-field-category {
            font-weight: 600;
            margin-top: 10px;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e0e0e0;
            color: #444;
        }

        #group-fields-container {
            max-height: 360px;
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 8px;
            background: #fff;
        }

        .group-field-item {
            padding: 6px 10px;
            margin: 4px 0;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .group-field-item:hover {
            background: #e9ecef;
            border-color: #adb5bd;
        }

        .group-field-item.selected {
            background: #d1ecf1;
            border-color: #0c5460;
        }
    </style>

    <!-- Group Fields Modal -->
    <div class="modal fade" id="groupFieldsModal" tabindex="-1" role="dialog" aria-labelledby="groupFieldsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="groupFieldsModalLabel">Add Custom Group</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control form-control-sm mb-2" id="group-field-search"
                        placeholder="Search fields...">
                    <div id="group-fields-container">
                        <div class="text-muted">Loading fields...</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            const availableColumns = @json($availableColumns);
            const defaultColumns = @json($defaultColumns);
            const csrfToken = '{{ csrf_token() }}';
            const reportsFieldsUrl = '{{ route('admin.reports.fields') }}';
            const savedViewsUrl = '{{ url('/views') }}';
            const groupList = [];
            let groupRowCounter = 0;
            let groupFieldCategories = {};
            let groupFieldLabels = {};
            let groupFieldSearch = '';
            let currentColumns = defaultColumns.slice();

            const getSelectedColumns = () => currentColumns;

            const parseFilters = () => {
                const filterEl = document.getElementById('filters-json');
                if (!filterEl) {
                    return {};
                }
                const raw = filterEl.value.trim();
                if (!raw) {
                    return {};
                }
                try {
                    return JSON.parse(raw);
                } catch (e) {
                    alert('Invalid JSON in filters. Please fix and try again.');
                    throw e;
                }
            };

            const renderGroupList = () => {
                const container = document.getElementById('group-list');
                if (!groupList.length) {
                    container.innerHTML = '<span class="text-muted">No groups selected</span>';
                    document.getElementById('group-by-selected').textContent = '';
                    return;
                }
                const labels = groupList.map((field, idx) => {
                    const label = groupFieldLabels[field] || availableColumns[field] || field;
                    return label;
                });
                document.getElementById('group-by-selected').textContent = labels.join(', ');

                container.innerHTML = groupList.map((field, idx) => {
                    const label = groupFieldLabels[field] || availableColumns[field] || field;
                    return `<div class="badge badge-info mr-1">${idx + 1}. ${label}
                        <span data-idx="${idx}" class="ml-1 remove-group" style="cursor:pointer;">&times;</span>
                    </div>`;
                }).join('');
            };

            const updateTableHead = (columns) => {
                const headRow = document.getElementById('table-head-row');
                headRow.innerHTML = columns.map((col) => `<th>${availableColumns[col] || col}</th>`).join('');
            };

            const renderFlatRows = (records, columns) => {
                const body = document.getElementById('table-body');
                body.innerHTML = records.map((row) => {
                    const url = row.detail_url || '';
                    return `<tr class="record-row" data-url="${url}">` +
                        columns.map((col) => `<td>${row[col] ?? ''}</td>`).join('') +
                        `</tr>`;
                }).join('');
            };

            const formatNumber = (value) => {
                const num = Number(value || 0);
                return num.toLocaleString('en-IN');
            };

            const renderGroupedRows = (nodes, columns, level, parentId) => {
                let html = '';
                nodes.forEach((node) => {
                    const groupId = `group_${groupRowCounter++}`;
                    const indent = '&nbsp;'.repeat(level * 4);
                    const totalApproved = formatNumber(node.total_approved || 0);
                    const totalPaid = formatNumber(node.total_paid || 0);
                    const groupLabel = groupFieldLabels[node.group] || availableColumns[node.group] || node.group;

                    html += `
                        <tr class="group-row" data-group-id="${groupId}" data-parent-id="${parentId || ''}">
                            <td colspan="${columns.length}">
                                ${indent}<span class="group-toggle" data-target="${groupId}">+</span>
                                ${groupLabel}: ${node.value}
                                <span class="text-muted ml-2">(${node.count} records)</span>
                                <span class="ml-2">Approved: ${totalApproved}</span>
                                <span class="ml-2">Paid: ${totalPaid}</span>
                            </td>
                        </tr>
                    `;

                    if (node.children && node.children.length) {
                        html += renderGroupedRows(node.children, columns, level + 1, groupId);
                    } else if (node.records && node.records.length) {
                        node.records.forEach((record) => {
                            html += `
                                <tr class="record-row" data-parent-id="${groupId}" data-url="${record.detail_url || ''}" style="display:none;">
                                    ${columns.map((col) => `<td>${record[col] ?? ''}</td>`).join('')}
                                </tr>
                            `;
                        });
                    }
                });

                return html;
            };

            const collapseChildren = (groupId, shouldHide) => {
                const rows = document.querySelectorAll(`[data-parent-id="${groupId}"]`);
                rows.forEach((row) => {
                    if (shouldHide) {
                        row.style.display = 'none';
                    } else {
                        if (row.classList.contains('group-row')) {
                            row.style.display = 'table-row';
                        } else {
                            row.style.display = 'table-row';
                        }
                    }
                    const childGroupId = row.getAttribute('data-group-id');
                    if (childGroupId) {
                        collapseChildren(childGroupId, shouldHide);
                    }
                });
            };

            const renderGroupFieldsPanel = () => {
                const container = document.getElementById('group-fields-container');
                let html = '';
                const query = groupFieldSearch.trim().toLowerCase();
                Object.keys(groupFieldCategories).forEach((category) => {
                    const fields = groupFieldCategories[category] || {};
                    let fieldHtml = '';
                    Object.keys(fields).forEach((fieldKey) => {
                        const label = fields[fieldKey];
                        if (query && !label.toLowerCase().includes(query) && !fieldKey.toLowerCase().includes(query)) {
                            return;
                        }
                        const isSelected = groupList.includes(fieldKey);
                        fieldHtml += `<div class="group-field-item ${isSelected ? 'selected' : ''}" data-field="${fieldKey}">${label}</div>`;
                    });
                    if (fieldHtml) {
                        html += `<div class="group-field-category">${category}</div>` + fieldHtml;
                    }
                });
                container.innerHTML = html || '<div class="text-muted">No fields available</div>';
            };

            const loadGroupFields = async () => {
                try {
                    const response = await fetch(reportsFieldsUrl);
                    const data = await response.json();
                    groupFieldCategories = data || {};
                    groupFieldLabels = {};
                    Object.keys(groupFieldCategories).forEach((category) => {
                        Object.keys(groupFieldCategories[category] || {}).forEach((key) => {
                            groupFieldLabels[key] = groupFieldCategories[category][key];
                        });
                    });
                    renderGroupFieldsPanel();
                } catch (e) {
                    document.getElementById('group-fields-container').innerHTML =
                        '<div class="text-danger">Failed to load fields.</div>';
                }
            };

            $('#groupFieldsModal').on('shown.bs.modal', function() {
                if (!Object.keys(groupFieldCategories).length) {
                    loadGroupFields();
                }
                document.getElementById('group-field-search').focus();
            });

            document.getElementById('toggle-group-fields-btn').addEventListener('click', () => {
                if (typeof $ !== 'undefined' && $('#groupFieldsModal').modal) {
                    $('#groupFieldsModal').modal('show');
                }
            });

            document.getElementById('group-fields-container').addEventListener('click', (e) => {
                const target = e.target.closest('.group-field-item');
                if (!target) {
                    return;
                }
                const field = target.getAttribute('data-field');
                if (!field) {
                    return;
                }
                if (groupList.includes(field)) {
                    groupList.splice(groupList.indexOf(field), 1);
                } else {
                    groupList.push(field);
                }
                renderGroupList();
                renderGroupFieldsPanel();
            });

            document.getElementById('group-list').addEventListener('click', (e) => {
                if (!e.target.classList.contains('remove-group')) {
                    return;
                }
                const idx = Number(e.target.getAttribute('data-idx'));
                groupList.splice(idx, 1);
                renderGroupList();
                renderGroupFieldsPanel();
            });

            document.getElementById('group-field-search').addEventListener('input', (e) => {
                groupFieldSearch = e.target.value || '';
                renderGroupFieldsPanel();
            });

            const applyCurrentView = async () => {
                const columns = getSelectedColumns();
                if (!columns.length) {
                    alert('Please select at least one column.');
                    return;
                }

                let filters = {};
                try {
                    filters = parseFilters();
                } catch (e) {
                    return;
                }

                const response = await fetch('{{ url('/applications/group') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        columns: columns,
                        group_by: groupList,
                        filters: filters
                    })
                });

                const result = await response.json();
                updateTableHead(columns);

                const body = document.getElementById('table-body');
                groupRowCounter = 0;
                if (!groupList.length) {
                    renderFlatRows(result.data || [], columns);
                    return;
                }

                body.innerHTML = renderGroupedRows(result.data || [], columns, 0, '');
            };

            document.getElementById('apply-grouping-btn').addEventListener('click', applyCurrentView);

            document.getElementById('reset-view-btn').addEventListener('click', () => {
                window.location.reload();
            });

            document.getElementById('save-view-btn').addEventListener('click', async () => {
                const viewName = document.getElementById('view-name').value.trim();
                if (!viewName) {
                    alert('Please provide a view name.');
                    return;
                }

                let filters = {};
                try {
                    filters = parseFilters();
                } catch (e) {
                    return;
                }

                const response = await fetch('{{ url('/views/save') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        view_name: viewName,
                        columns_json: getSelectedColumns(),
                        group_by_json: groupList,
                        filters_json: filters
                    })
                });

                if (!response.ok) {
                    const text = await response.text();
                    alert('Save failed: ' + (text || response.statusText));
                    return;
                }

                const result = await response.json();
                if (result.success) {
                    alert('View saved successfully. View ID: ' + result.view.id);
                    loadSavedViews(result.view.id);
                    return;
                }
                alert('Save failed. Please try again.');
            });

            document.getElementById('export-view-btn').addEventListener('click', async () => {
                const columns = getSelectedColumns();
                let filters = {};
                try {
                    filters = parseFilters();
                } catch (e) {
                    return;
                }

                const response = await fetch('{{ url('/applications/export') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        columns: columns,
                        group_by: groupList,
                        filters: filters
                    })
                });

                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = 'Applications_View.xlsx';
                document.body.appendChild(link);
                link.click();
                window.URL.revokeObjectURL(url);
                link.remove();
            });

            document.getElementById('table-body').addEventListener('click', (e) => {
                const recordRow = e.target.closest('.record-row');
                if (recordRow) {
                    const url = recordRow.getAttribute('data-url');
                    if (url) {
                        window.location.href = url;
                    }
                    return;
                }

                if (!e.target.classList.contains('group-toggle')) {
                    return;
                }
                const targetId = e.target.getAttribute('data-target');
                const isCollapsed = e.target.textContent === '+';
                e.target.textContent = isCollapsed ? '-' : '+';
                collapseChildren(targetId, !isCollapsed);
            });

            const loadSavedViews = async (selectedId = '') => {
                try {
                    const response = await fetch(savedViewsUrl);
                    const data = await response.json();
                    const select = document.getElementById('saved-view-select');
                    select.innerHTML = '<option value="">Select Saved View</option>';
                    if (data.success && Array.isArray(data.views)) {
                        data.views.forEach((view) => {
                            const opt = document.createElement('option');
                            opt.value = view.id;
                            opt.textContent = view.view_name;
                            if (String(view.id) === String(selectedId)) {
                                opt.selected = true;
                            }
                            select.appendChild(opt);
                        });
                    }
                } catch (e) {
                    // Ignore list load failures.
                }
            };

            document.getElementById('load-view-btn').addEventListener('click', async () => {
                const viewId = document.getElementById('saved-view-select').value;
                if (!viewId) {
                    alert('Please select a saved view.');
                    return;
                }
                const response = await fetch('{{ url('/views') }}/' + viewId);
                const data = await response.json();
                if (!data.success || !data.view) {
                    alert('Failed to load saved view.');
                    return;
                }

                const view = data.view;
                currentColumns = Array.isArray(view.columns_json) && view.columns_json.length ?
                    view.columns_json : defaultColumns.slice();

                groupList.length = 0;
                if (Array.isArray(view.group_by_json)) {
                    view.group_by_json.forEach((f) => groupList.push(f));
                }

                const filterEl = document.getElementById('filters-json');
                if (filterEl) {
                    filterEl.value = view.filters_json ? JSON.stringify(view.filters_json) : '';
                }

                renderGroupList();
                renderGroupFieldsPanel();
                applyCurrentView();
            });

            loadSavedViews();
            renderGroupList();
        })();
    </script>
@endsection
