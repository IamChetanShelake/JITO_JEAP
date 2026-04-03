@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h3 class="card-title">3rd Stage Documents - Send Back for Correction</h3>
                </div>
                <div class="card-body">
                    @if($users->isEmpty())
                        <div class="alert alert-info">
                            No send back 3rd stage document submissions found.
                        </div>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Chapter</th>
                                    <th>Status</th>
                                    <th>Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->chapter }}</td>
                                        <td>{{ ucfirst($user->thirdStageDocument->status ?? 'rejected') }}</td>
                                        <td>
                                            {{ optional($user->thirdStageDocument?->updated_at)->format('d-m-Y H:i') ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.third_stage_documents.user.detail', $user->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
