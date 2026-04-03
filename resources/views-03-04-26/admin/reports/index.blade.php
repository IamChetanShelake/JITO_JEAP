@extends('admin.layouts.master')

@section('title', 'Dynamic Reports')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar"></i> Dynamic Report Builder
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Predefined Reports Section -->
                        <div class="mb-4">
                            <h4 class="mb-3">
                                <i class="fas fa-file-alt"></i> Predefined Reports
                            </h4>
                            <div class="row">
                                @foreach ($predefinedReports as $report)
                                    <div class="col-md-3 mb-3">
                                        <div class="card report-card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $report->name }}</h5>
                                                <p class="card-text text-muted small">{{ $report->description }}</p>
                                                <a href="{{ route('admin.reports.templates.export', $report->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-download"></i> Export
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Custom Reports Section -->
                        <div class="mb-4">
                            <h4 class="mb-3">
                                <i class="fas fa-folder"></i> Saved Custom Reports
                            </h4>
                            @if ($customReports->count() > 0)
                                <div class="row">
                                    @foreach ($customReports as $report)
                                        <div class="col-md-3 mb-3">
                                            <div class="card report-card">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $report->name }}</h5>
                                                    <p class="card-text text-muted small">{{ $report->description }}</p>
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.reports.templates.export', $report->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fas fa-download"></i> Export
                                                        </a>
                                                        <button type="button" class="btn btn-info btn-sm load-template-btn"
                                                            data-template-id="{{ $report->id }}">
                                                            <i class="fas fa-edit"></i> Load
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm delete-template-btn"
                                                            data-template-id="{{ $report->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> No custom reports saved yet. Create your first report
                                    below!
                                </div>
                            @endif
                        </div>

                        <!-- Report Builder Section -->
                        <div class="border-top pt-4">
                            <h4 class="mb-3">
                                <i class="fas fa-plus-circle"></i> Create New Report
                            </h4>

                            <div class="row">
                                <!-- Left Panel: Available Fields -->
                                <div class="col-md-5">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">
                                                <i class="fas fa-list"></i> Available Fields
                                            </h5>
                                        </div>
                                        <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                                            <div id="available-fields-container">
                                                <div class="text-center">
                                                    <div class="spinner-border text-primary" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Panel: Selected Fields -->
                                <div class="col-md-7">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">
                                                <i class="fas fa-check-square"></i> Selected Fields
                                                <span class="badge badge-primary ml-2" id="selected-count">0</span>
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="selected-fields-container"
                                                style="min-height: 200px; max-height: 400px; overflow-y: auto;">
                                                <div class="text-center text-muted py-5">
                                                    <i class="fas fa-arrow-left fa-2x mb-3"></i>
                                                    <p>Select fields from the left panel</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        id="clear-all-btn">
                                                        <i class="fas fa-times"></i> Clear All
                                                    </button>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button type="button" class="btn btn-success" id="generate-report-btn"
                                                        disabled>
                                                        <i class="fas fa-file-excel"></i> Generate Report
                                                    </button>
                                                    <button type="button" class="btn btn-info" id="save-template-btn"
                                                        disabled>
                                                        <i class="fas fa-save"></i> Save Template
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filters Section -->
                                    <div class="card mt-3">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">
                                                <i class="fas fa-filter"></i> Filters (Optional)
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="filters-container">
                                                <div class="text-center text-muted py-3">
                                                    <p>Add filters to narrow down your report data</p>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                id="add-filter-btn">
                                                <i class="fas fa-plus"></i> Add Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Template Modal -->
    <div class="modal fade" id="saveTemplateModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Save Report Template</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="save-template-form">
                        <div class="form-group">
                            <label for="template-name">Template Name *</label>
                            <input type="text" class="form-control" id="template-name" required>
                        </div>
                        <div class="form-group">
                            <label for="template-description">Description</label>
                            <textarea class="form-control" id="template-description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="template-category">Category</label>
                            <select class="form-control" id="template-category">
                                <option value="">Select Category</option>
                                <option value="student">Student</option>
                                <option value="payment">Payment</option>
                                <option value="donor">Donor</option>
                                <option value="chapter">Chapter</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirm-save-template">Save Template</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .report-card {
            transition: transform 0.2s;
            cursor: pointer;
        }

        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .field-item {
            padding: 8px 12px;
            margin: 4px 0;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .field-item:hover {
            background: #e9ecef;
            border-color: #adb5bd;
        }

        .field-item.selected {
            background: #d4edda;
            border-color: #28a745;
        }

        .field-category {
            font-weight: 600;
            color: #495057;
            margin-top: 12px;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 2px solid #dee2e6;
        }

        .selected-field-item {
            padding: 8px 12px;
            margin: 4px 0;
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .remove-field-btn {
            color: #dc3545;
            cursor: pointer;
            padding: 2px 6px;
        }

        .remove-field-btn:hover {
            color: #c82333;
        }

        .filter-item {
            padding: 12px;
            margin: 8px 0;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
    </style>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let selectedFields = [];
            let filters = [];
            let availableFields = {};

            // Load available fields
            loadAvailableFields();

            function loadAvailableFields() {
                $.get('{{ route('admin.reports.fields') }}', function(data) {
                    availableFields = data;
                    renderAvailableFields();
                });
            }

            function renderAvailableFields() {
                let html = '';
                for (let category in availableFields) {
                    html += '<div class="field-category">' + category + '</div>';
                    for (let fieldKey in availableFields[category]) {
                        let isSelected = selectedFields.includes(fieldKey);
                        html += '<div class="field-item ' + (isSelected ? 'selected' : '') + '" data-field="' +
                            fieldKey + '">';
                        html += '<i class="fas ' + (isSelected ? 'fa-check-square' : 'fa-square') + ' mr-2"></i>';
                        html += availableFields[category][fieldKey];
                        html += '</div>';
                    }
                }
                $('#available-fields-container').html(html);
            }

            function renderSelectedFields() {
                if (selectedFields.length === 0) {
                    $('#selected-fields-container').html(`
                <div class="text-center text-muted py-5">
                    <i class="fas fa-arrow-left fa-2x mb-3"></i>
                    <p>Select fields from the left panel</p>
                </div>
            `);
                    $('#generate-report-btn').prop('disabled', true);
                    $('#save-template-btn').prop('disabled', true);
                } else {
                    let html = '';
                    selectedFields.forEach(function(field) {
                        let label = getFieldLabel(field);
                        html += '<div class="selected-field-item">';
                        html += '<span>' + label + '</span>';
                        html += '<span class="remove-field-btn" data-field="' + field + '">';
                        html += '<i class="fas fa-times"></i>';
                        html += '</span>';
                        html += '</div>';
                    });
                    $('#selected-fields-container').html(html);
                    $('#generate-report-btn').prop('disabled', false);
                    $('#save-template-btn').prop('disabled', false);
                }
                $('#selected-count').text(selectedFields.length);
            }

            function getFieldLabel(field) {
                for (let category in availableFields) {
                    if (availableFields[category][field]) {
                        return availableFields[category][field];
                    }
                }
                return field;
            }

            // Field selection
            $(document).on('click', '.field-item', function() {
                let field = $(this).data('field');
                let index = selectedFields.indexOf(field);

                if (index === -1) {
                    selectedFields.push(field);
                } else {
                    selectedFields.splice(index, 1);
                }

                renderAvailableFields();
                renderSelectedFields();
            });

            // Remove selected field
            $(document).on('click', '.remove-field-btn', function(e) {
                e.stopPropagation();
                let field = $(this).data('field');
                let index = selectedFields.indexOf(field);
                if (index !== -1) {
                    selectedFields.splice(index, 1);
                    renderAvailableFields();
                    renderSelectedFields();
                }
            });

            // Clear all fields
            $('#clear-all-btn').click(function() {
                selectedFields = [];
                filters = [];
                renderAvailableFields();
                renderSelectedFields();
                renderFilters();
            });

            // Generate report with AJAX
            $('#generate-report-btn').click(function() {
                if (selectedFields.length === 0) {
                    alert('Please select at least one field');
                    return;
                }

                // Disable button to prevent multiple submissions
                let btn = $(this);
                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin"></i> Generating...');

                // Collect filter data
                let filterData = [];
                $('.filter-item').each(function() {
                    let field = $(this).find('.filter-field').val();
                    let operator = $(this).find('.filter-operator').val();
                    let value = $(this).find('.filter-value').val();

                    if (field && operator) {
                        filterData.push({
                            field: field,
                            operator: operator,
                            value: value || ''
                        });
                    }
                });

                // Send AJAX request
                $.ajax({
                    url: '{{ route('admin.reports.generate') }}',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        selected_fields: selectedFields,
                        filters: filterData
                    }),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(data, status, xhr) {
                        // Create blob download link
                        let filename = 'Dynamic_Report_' + new Date().toISOString().slice(0,
                            10) + '.xlsx';
                        let link = document.createElement('a');
                        let url = window.URL.createObjectURL(data);
                        link.href = url;
                        link.download = filename;
                        document.body.appendChild(link);
                        link.click();
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(link);

                        // Re-enable button
                        btn.prop('disabled', false);
                        btn.html('<i class="fas fa-file-excel"></i> Generate Report');
                    },
                    error: function(xhr) {
                        // Re-enable button
                        btn.prop('disabled', false);
                        btn.html('<i class="fas fa-file-excel"></i> Generate Report');

                        // Show error message
                        let errorMessage = 'An error occurred while generating the report.';

                        const handleErrorText = function(text) {
                            if (typeof text !== 'string') {
                                text = String(text || '');
                            }
                            try {
                                let response = JSON.parse(text);
                                if (response.message) {
                                    errorMessage = response.message;
                                }
                                if (response.errors) {
                                    errorMessage = Object.values(response.errors).flat().join(', ');
                                }
                            } catch (e) {
                                // If response is not JSON, try to get status text
                                if (xhr.status === 422) {
                                    errorMessage = 'Validation error: Please select at least one field.';
                                } else if (text) {
                                    errorMessage = text;
                                } else if (xhr.statusText) {
                                    errorMessage = xhr.statusText;
                                }
                            }
                            alert('Error: ' + errorMessage);
                        };

                        const isBlobLike = function(obj) {
                            return obj && typeof obj === 'object' && typeof obj.size === 'number' &&
                                typeof obj.type === 'string' && (typeof obj.arrayBuffer === 'function' || typeof obj.text === 'function');
                        };

                        const readBlobAsText = function(blob) {
                            // Prefer Blob.text() when available (simpler than FileReader).
                            if (blob && typeof blob.text === 'function') {
                                blob.text().then(function(t) {
                                    handleErrorText(t || '');
                                }).catch(function() {
                                    handleErrorText('');
                                });
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = function() {
                                handleErrorText(reader.result || '');
                            };
                            reader.onerror = function() {
                                handleErrorText('');
                            };
                            reader.readAsText(blob);
                        };

                        // When `responseType: blob` is used, error responses can come back as a Blob
                        // and jQuery may put it in either `response` or `responseText`.
                        const blobCandidate = (isBlobLike(xhr.response) ? xhr.response : (isBlobLike(xhr.responseText) ? xhr.responseText : null));
                        if (blobCandidate) {
                            readBlobAsText(blobCandidate);
                            return;
                        }

                        if (xhr.responseJSON) {
                            handleErrorText(JSON.stringify(xhr.responseJSON));
                            return;
                        }

                        handleErrorText(xhr.responseText || '');
                    }
                });
            });

            // Save template
            $('#save-template-btn').click(function() {
                if (selectedFields.length === 0) {
                    alert('Please select at least one field');
                    return;
                }
                $('#saveTemplateModal').modal('show');
            });

            $('#confirm-save-template').click(function() {
                let name = $('#template-name').val().trim();
                let description = $('#template-description').val().trim();
                let category = $('#template-category').val();

                if (!name) {
                    alert('Please enter a template name');
                    return;
                }

                // Collect filter data from DOM
                let filterData = [];
                $('.filter-item').each(function() {
                    let field = $(this).find('.filter-field').val();
                    let operator = $(this).find('.filter-operator').val();
                    let value = $(this).find('.filter-value').val();

                    if (field && operator) {
                        filterData.push({
                            field: field,
                            operator: operator,
                            value: value || ''
                        });
                    }
                });

                $.ajax({
                    url: '{{ route('admin.reports.templates.save') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        name: name,
                        description: description,
                        category: category,
                        selected_fields: selectedFields,
                        filters: filterData
                    }),
                    success: function(response) {
                        alert('Template saved successfully!');
                        $('#saveTemplateModal').modal('hide');
                        // Clear form fields
                        $('#template-name').val('');
                        $('#template-description').val('');
                        $('#template-category').val('');
                        location.reload();
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred while saving the template.';
                        try {
                            let response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMessage = response.message;
                            }
                        } catch (e) {}
                        alert('Error: ' + errorMessage);
                    }
                });
            });

            // Load template
            $('.load-template-btn').click(function() {
                let templateId = $(this).data('template-id');

                $.get('{{ route('admin.reports.templates.load', ':id') }}'.replace(':id', templateId),
                    function(response) {
                        selectedFields = response.template.selected_fields || [];
                        filters = response.template.filters || [];
                        renderAvailableFields();
                        renderSelectedFields();
                        renderFilters();

                        // Scroll to report builder
                        $('html, body').animate({
                            scrollTop: $('#available-fields-container').offset().top - 100
                        }, 500);
                    });
            });

            // Delete template
            $('.delete-template-btn').click(function() {
                if (!confirm('Are you sure you want to delete this template?')) {
                    return;
                }

                let templateId = $(this).data('template-id');

                $.ajax({
                    url: '{{ route('admin.reports.templates.delete', ':id') }}'.replace(':id',
                        templateId),
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Template deleted successfully!');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error deleting template: ' + xhr.responseJSON.message);
                    }
                });
            });

            // Add filter
            $('#add-filter-btn').click(function() {
                if (selectedFields.length === 0) {
                    alert('Please select fields first');
                    return;
                }

                let filterHtml = `
            <div class="filter-item">
                <div class="row">
                    <div class="col-md-4">
                        <select class="form-control form-control-sm filter-field">
                            <option value="">Select Field</option>
                            ${selectedFields.map(field => `<option value="${field}">${getFieldLabel(field)}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control form-control-sm filter-operator">
                            <option value="=">Equals</option>
                            <option value="!=">Not Equals</option>
                            <option value="like">Contains</option>
                            <option value=">">Greater Than</option>
                            <option value="<">Less Than</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm filter-value" placeholder="Value">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-danger remove-filter-btn">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
                $('#filters-container').append(filterHtml);
            });

            // Remove filter
            $(document).on('click', '.remove-filter-btn', function() {
                $(this).closest('.filter-item').remove();
            });

            function renderFilters() {
                $('#filters-container').empty();
                filters.forEach(function(filter) {
                    let filterHtml = `
                <div class="filter-item">
                    <div class="row">
                        <div class="col-md-4">
                            <select class="form-control form-control-sm filter-field">
                                <option value="">Select Field</option>
                                ${selectedFields.map(field => `<option value="${field}" ${field === filter.field ? 'selected' : ''}>${getFieldLabel(field)}</option>`).join('')}
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm filter-operator">
                                <option value="=" ${filter.operator === '=' ? 'selected' : ''}>Equals</option>
                                <option value="!=" ${filter.operator === '!=' ? 'selected' : ''}>Not Equals</option>
                                <option value="like" ${filter.operator === 'like' ? 'selected' : ''}>Contains</option>
                                <option value=">" ${filter.operator === '>' ? 'selected' : ''}>Greater Than</option>
                                <option value="<" ${filter.operator === '<' ? 'selected' : ''}>Less Than</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm filter-value" placeholder="Value" value="${filter.value || ''}">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-sm btn-danger remove-filter-btn">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
                    $('#filters-container').append(filterHtml);
                });
            }
        });
    </script>
@endsection
