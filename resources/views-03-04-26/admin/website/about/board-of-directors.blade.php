@extends('admin.website.layouts.master')

@section('title','Board of Directors - Admin')

@section('website-content')

<div class="container-fluid">

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between align-items-center">

<h5 class="mb-0">
<i class="fas fa-users"></i> Board of Directors
</h5>

<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
<i class="fas fa-plus"></i> Add Director
</button>

</div>

<div class="card-body">

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
{{ session('success') }}
<button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-light">

<tr>

<th width="20%">Name</th>
<th width="20%">Post</th>
<th width="25%">Email</th>
<th width="15%">Image</th>
<th width="20%" class="text-center">Action</th>

</tr>

</thead>

<tbody>

@forelse($items as $item)

<tr>

<td>
<strong>{{ $item->name }}</strong>
</td>

<td>
{{ $item->post }}
</td>

<td>
{{ $item->email }}
</td>

<td>

@if($item->image)
<img src="{{ asset($item->image) }}" width="50" class="rounded">
@else
<span class="text-muted">No Image</span>
@endif

</td>

<td class="text-center">

<button class="btn btn-sm btn-info text-white"
data-bs-toggle="modal"
data-bs-target="#viewModal{{ $item->id }}">
<i class="fas fa-eye"></i>
</button>

<button class="btn btn-sm btn-warning"
data-bs-toggle="modal"
data-bs-target="#editModal{{ $item->id }}">
<i class="fas fa-edit"></i>
</button>

<button class="btn btn-sm btn-danger"
data-bs-toggle="modal"
data-bs-target="#deleteModal{{ $item->id }}">
<i class="fas fa-trash"></i>
</button>

</td>

</tr>

{{-- ================= VIEW MODAL ================= --}}

<div class="modal fade" id="viewModal{{ $item->id }}">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">{{ $item->name }}</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="row">
<div class="col-md-6">
<p><strong>Post:</strong> {{ $item->post }}</p>
</div>
<div class="col-md-6">
<p><strong>Email:</strong> {{ $item->email }}</p>
</div>
</div>

@if($item->image)
<div class="text-center mt-3">
<img src="{{ asset($item->image) }}" class="img-fluid rounded" style="max-width: 300px;">
</div>
@endif

</div>

</div>
</div>
</div>

{{-- ================= EDIT MODAL ================= --}}

<div class="modal fade" id="editModal{{ $item->id }}">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<form action="{{ route('admin.website.about.board-of-directors.update',$item->id) }}" method="POST" enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="modal-header">
<h5 class="modal-title">Edit Director</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label class="form-label">Name</label>
<input type="text" name="name" class="form-control" value="{{ $item->name }}">
</div>

<div class="mb-3">
<label class="form-label">Post</label>
<input type="text" name="post" class="form-control" value="{{ $item->post }}">
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" value="{{ $item->email }}">
</div>

<div class="mt-3">

<label class="form-label">Image</label>

<input type="file" name="image" class="form-control">

@if($item->image)
<img src="{{ asset($item->image) }}" width="100" class="mt-2">
@endif

</div>

</div>

<div class="modal-footer">
<button class="btn btn-primary">Update</button>
</div>

</form>

</div>
</div>
</div>

{{-- ================= DELETE MODAL ================= --}}

<div class="modal fade" id="deleteModal{{ $item->id }}">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Delete</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
Are you sure you want to delete this record?
</div>

<div class="modal-footer">

<form action="{{ route('admin.website.about.board-of-directors.delete',$item->id) }}" method="POST">

@csrf
@method('DELETE')

<button class="btn btn-danger">Delete</button>

</form>

</div>

</div>
</div>
</div>

@empty

<tr>
<td colspan="5" class="text-center text-muted py-4">
No data found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

</div>

{{-- ================= ADD MODAL ================= --}}

<div class="modal fade" id="addModal">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<form action="{{ route('admin.website.about.board-of-directors.store') }}" method="POST" enctype="multipart/form-data">

@csrf

<div class="modal-header">
<h5 class="modal-title">Add Director</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label class="form-label">Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Post</label>
<input type="text" name="post" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control">
</div>

<div class="mt-3">

<label class="form-label">Image</label>
<input type="file" name="image" class="form-control">

</div>

</div>

<div class="modal-footer">
<button class="btn btn-primary">Save Data</button>
</div>

</form>

</div>
</div>
</div>

@endsection
