@extends('admin.website.layouts.master')
@section('title', 'FAQ\'s Management - JitoJeap Admin')

@section('website-content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">FAQ's Management</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                    <i class="fas fa-plus"></i> Add FAQ
                </button>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- FAQ List -->
                <h4>Existing FAQs</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Answer</th>
                               
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqs as $faq)
                                <tr>
                                    <td>{{ $faq->id }}</td>
                                    <td>{{ $faq->question }}</td>
                                    <td>{{ Str::limit($faq->answer, 100) }}</td>
                                    
                                    <td class="text-center align-middle">
                                        <button class="btn btn-sm btn-info text-white" title="View" data-bs-toggle="modal" data-bs-target="#viewModal{{ $faq->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $faq->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" title="Delete" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this FAQ?')) { document.getElementById('delete-form-{{ $faq->id }}').submit(); }">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $faq->id }}" action="{{ route('admin.website.application.faqs.delete', $faq->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>

                                <!-- View Modal -->
                                <div class="modal fade" id="viewModal{{ $faq->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $faq->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewModalLabel{{ $faq->id }}">FAQ Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <strong>Question:</strong>
                                                        <p>{{ $faq->question }}</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <strong>Answer:</strong>
                                                        <p>{{ $faq->answer }}</p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $faq->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $faq->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $faq->id }}">Edit FAQ</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.website.application.faqs.update', $faq->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="question{{ $faq->id }}" class="form-label">Question</label>
                                                        <input type="text" class="form-control" id="question{{ $faq->id }}" name="question" value="{{ $faq->question }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="answer{{ $faq->id }}" class="form-label">Answer</label>
                                                        <textarea class="form-control" id="answer{{ $faq->id }}" name="answer" rows="5" required>{{ $faq->answer }}</textarea>
                                                    </div>
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No FAQs found. Add your first FAQ above.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add FAQ Modal -->
    <div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="addFaqModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFaqModalLabel">Add New FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.website.application.faqs.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="question" name="question" required placeholder="Enter question">
                        </div>
                        <div class="mb-3">
                            <label for="answer" class="form-label">Answer <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="answer" name="answer" rows="5" required placeholder="Enter answer"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
