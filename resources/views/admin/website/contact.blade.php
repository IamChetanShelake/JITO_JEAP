@extends('admin.website.layouts.master')

@section('title','Contact - Admin')

@section('website-content')

<div class="container-fluid">

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between align-items-center">

<h5 class="mb-0">
<i class="fas fa-phone-alt"></i> Contact Page
</h5>

<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
<i class="fas fa-plus"></i> Add Data
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

<th width="15%">Title</th>
<th width="30%">Description</th>
<th width="25%">Sections</th>
<th width="10%">Status</th>
<th width="20%" class="text-center">Action</th>

</tr>

</thead>

<tbody>

@forelse($items as $item)

<tr>

<td>
<strong>{{ $item->title ?? 'N/A' }}</strong>
</td>

<td>
{{ Str::limit($item->description, 120) ?? 'N/A' }}
</td>

<td>

@if($item->small_titles && count($item->small_titles) > 0)
@foreach($item->small_titles as $index => $title)

<div class="mb-2">

<strong>{{ $title }}</strong>

<p class="mb-0 text-muted small">
{{ $item->small_descriptions[$index] ?? '' }}
</p>

</div>

@endforeach
@else
<span class="text-muted">No sections</span>
@endif

</td>

<td>
@if($item->is_active)
<span class="badge bg-success">Active</span>
@else
<span class="badge bg-danger">Inactive</span>
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
<h5 class="modal-title">{{ $item->title ?? 'Contact Data' }}</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<p><strong>Description:</strong></p>
<p>{{ $item->description ?? 'N/A' }}</p>

<hr>

@if($item->small_titles && count($item->small_titles) > 0)
<p><strong>Sections:</strong></p>
@foreach($item->small_titles as $index => $title)

<h6>{{ $title }}</h6>
<p>{{ $item->small_descriptions[$index] ?? '' }}</p>

@endforeach
@endif

</div>

</div>
</div>
</div>

{{-- ================= EDIT MODAL ================= --}}

<div class="modal fade" id="editModal{{ $item->id }}">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<form action="{{ route('admin.website.contact.update', $item->id) }}" method="POST">

@csrf
@method('PUT')

<div class="modal-header">
<h5 class="modal-title">Edit Contact</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label class="form-label">Title</label>
<input type="text" name="title" class="form-control" value="{{ $item->title }}">
</div>

<div class="mb-3">
<label class="form-label">Description</label>
<textarea name="description" class="form-control" rows="3">{{ $item->description }}</textarea>
</div>

<h6 class="mt-4 mb-3">Sections</h6>

<div id="sectionContainerEdit{{ $item->id }}">

@if($item->small_titles && count($item->small_titles) > 0)
@foreach($item->small_titles as $index => $title)

<div class="row mb-2 sectionRow">

<div class="col-md-5">
<input type="text" name="small_titles[]" class="form-control" value="{{ $title }}">
</div>

<div class="col-md-5">
<input type="text" name="small_descriptions[]" class="form-control"
value="{{ $item->small_descriptions[$index] ?? '' }}">
</div>

<div class="col-md-2">
<button type="button" class="btn btn-danger removeRow">X</button>
</div>

</div>

@endforeach
@endif

</div>

<button type="button"
class="btn btn-secondary btn-sm"
onclick="addSectionEdit('sectionContainerEdit{{ $item->id }}')">
Add More
</button>

<div class="mt-3">

<label class="form-label">Status</label>
<select class="form-select" name="is_active">
<option value="1" {{ $item->is_active ? 'selected' : '' }}>Active</option>
<option value="0" {{ !$item->is_active ? 'selected' : '' }}>Inactive</option>
</select>

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

<form action="{{ route('admin.website.contact.delete', $item->id) }}" method="POST">

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

<form action="{{ route('admin.website.contact.store') }}" method="POST" id="addContactForm">

@csrf

<div class="modal-header">
<h5 class="modal-title">Add Contact Data</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label class="form-label">Title</label>
<input type="text" name="title" class="form-control">
</div>

<div class="mb-3">
<label class="form-label">Description</label>
<textarea name="description" class="form-control" rows="3"></textarea>
</div>

<h6 class="mt-4 mb-3">Sections</h6>

<div id="sectionContainerAdd">

<div class="row mb-2 sectionRow">

<div class="col-md-5">
    
<input type="text" name="small_titles[]" class="form-control" placeholder="Small Title">
</div>

<div class="col-md-5">
<input type="text" name="small_descriptions[]" class="form-control" placeholder="Small Description">
</div>

<div class="col-md-2">
<button type="button" class="btn btn-danger removeRow">X</button>
</div>

</div>

</div>

<button type="button"
class="btn btn-secondary btn-sm"
onclick="addSection('sectionContainerAdd')">
Add More
</button>

<div class="mt-3">

<div class="form-check">
<input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
<label class="form-check-label" for="is_active">Active</label>
</div>

</div>

</div>

<div class="modal-footer">
<button class="btn btn-primary">Save Data</button>
</div>

</form>

</div>
</div>
</div>

<script>

function addSection(containerId){

let html = `
<div class="row mb-2 sectionRow">

<div class="col-md-5">
<input type="text" name="small_titles[]" class="form-control" placeholder="Small Title">
</div>

<div class="col-md-5">
<input type="text" name="small_descriptions[]" class="form-control" placeholder="Small Description">
</div>

<div class="col-md-2">
<button type="button" class="btn btn-danger removeRow">X</button>
</div>

</div>
`;

document.getElementById(containerId).insertAdjacentHTML("beforeend", html)

}

function addSectionEdit(containerId){

let html = `
<div class="row mb-2 sectionRow">

<div class="col-md-5">
<input type="text" name="small_titles[]" class="form-control" placeholder="Small Title">
</div>

<div class="col-md-5">
<input type="text" name="small_descriptions[]" class="form-control" placeholder="Small Description">
</div>

<div class="col-md-2">
<button type="button" class="btn btn-danger removeRow">X</button>
</div>

</div>
`;

document.getElementById(containerId).insertAdjacentHTML("beforeend", html)

}

document.addEventListener("click", function(e){

if(e.target.classList.contains("removeRow")){
e.target.closest(".sectionRow").remove()
}

})

// Filter out empty sections before form submission
document.getElementById('addContactForm').addEventListener('submit', function(e) {
    const sectionRows = document.querySelectorAll('#sectionContainerAdd .sectionRow');
    
    sectionRows.forEach(function(row) {
        const titleInput = row.querySelector('input[name="small_titles[]"]');
        const descInput = row.querySelector('input[name="small_descriptions[]"]');
        
        // Remove row if both inputs are empty
        if (titleInput && descInput && !titleInput.value.trim() && !descInput.value.trim()) {
            row.remove();
        }
    });
});

</script>

@endsection
