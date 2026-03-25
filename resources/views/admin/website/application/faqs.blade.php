@extends('admin.website.layouts.master')
@section('title', 'FAQ\'s Management - JitoJeap Admin')

@section('website-content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2>FAQ's Management</h2>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Add New FAQ Form -->
                <div class="mb-4">
                    <h4>Add New FAQ</h4>
                    <form action="{{ route('admin.website.application.faqs.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="question" class="form-label">Question</label>
                                    <input type="text" class="form-control" id="question" name="question" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="answer" class="form-label">Answer</label>
                                    <textarea class="form-control" id="answer" name="answer" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add FAQ</button>
                    </form>
                </div>

                <hr>

                <!-- FAQ List -->
                <h4>Existing FAQs</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqs as $faq)
                                <tr>
                                    <td>{{ $faq->id }}</td>
                                    <td>{{ $faq->question }}</td>
                                    <td>{{ Str::limit($faq->answer, 100) }}</td>
                                    <td>
                                        @if($faq->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
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
                                                    <div class="mb-3">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="is_active{{ $faq->id }}" name="is_active" value="1" {{ $faq->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="is_active{{ $faq->id }}">Active</label>
                                                        </div>
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
@endsection
