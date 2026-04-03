@extends('admin.website.layouts.master')

@section('title','About JEAP - Admin')

@section('website-content')

<div class="container-fluid">

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between align-items-center">

<h5 class="mb-0">
<i class="fas fa-info-circle"></i> About JEAP
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
<th width="15%">Images</th>
<th width="15%" class="text-center">Action</th>

</tr>

</thead>

<tbody>

@forelse($items as $item)

<tr>

<td>
<strong>{{ $item->title }}</strong>
</td>

<td>
{{ Str::limit($item->description,120) }}
</td>

<td>

@foreach(($item->small_titles ?? []) as $index => $title)

<div class="mb-2">

<strong>{{ $title }}</strong>

<p class="mb-0 text-muted small">
{{ $item->small_descriptions[$index] ?? '' }}
</p>

</div>

@endforeach

</td>

<td>

@if($item->image || $item->images)
<div class="d-flex gap-1">
@if($item->image)
<img src="{{ asset($item->image) }}" width="50" class="rounded">
@endif
@if($item->images)
@foreach($item->images as $img)
<img src="{{ asset($img) }}" width="50" class="rounded">
@endforeach
@endif
</div>
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
<h5 class="modal-title">{{ $item->title }}</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<p>{{ $item->description }}</p>

<hr>

@foreach(($item->small_titles ?? []) as $index => $title)

<h6>{{ $title }}</h6>
<p>{{ $item->small_descriptions[$index] ?? '' }}</p>

@endforeach

@if($item->image || $item->images)
<div class="text-center mt-3">
@if($item->image)
<img src="{{ asset($item->image) }}" class="img-fluid rounded mb-2" style="max-width: 300px;">
@endif
@if($item->images)
<div class="d-flex flex-wrap justify-content-center gap-2">
@foreach($item->images as $img)
<img src="{{ asset($img) }}" class="img-fluid rounded" style="max-width: 200px; max-height: 150px;">
@endforeach
</div>
@endif
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

<form action="{{ route('admin.website.about.jeap.update',$item->id) }}" method="POST" enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="modal-header">
<h5 class="modal-title">Edit JEAP</h5>
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

<div id="sectionContainer{{ $item->id }}">

@foreach(($item->small_titles ?? []) as $index => $title)

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

</div>

<button type="button"
class="btn btn-secondary btn-sm"
onclick="addSection('sectionContainer{{ $item->id }}')">
Add More
</button>

<div class="mt-3">

<label class="form-label">Image</label>

<input type="file" name="image" class="form-control">

@if($item->image)
<img src="{{ asset($item->image) }}" width="100" class="mt-2">
@endif

</div>

<div class="mt-3">

<label class="form-label">Additional Images (Choose more)</label>

<input type="file" name="images[]" class="form-control" multiple>

@if($item->images)
<div class="d-flex flex-wrap gap-2 mt-2">
@foreach($item->images as $index => $img)
<div class="position-relative">
<img src="{{ asset($img) }}" width="80" class="rounded">
<a href="{{ route('admin.website.about.jeap.delete-image', [$item->id, 'image_index' => $index]) }}" 
   class="btn btn-danger btn-sm position-absolute" 
   style="top: -5px; right: -5px; padding: 2px 6px; font-size: 10px;"
   onclick="return confirm('Are you sure you want to delete this image?')">
   X
</a>
</div>
@endforeach
</div>
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

<form action="{{ route('admin.website.about.jeap.delete',$item->id) }}" method="POST">

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

<form action="{{ route('admin.website.about.jeap.store') }}" method="POST" enctype="multipart/form-data">

@csrf

<div class="modal-header">
<h5 class="modal-title">Add JEAP Data</h5>
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

<label class="form-label">Image</label>
<input type="file" name="image" class="form-control">

</div>

<div class="mt-3">

<label class="form-label">Additional Images (Choose multiple)</label>
<input type="file" name="images[]" class="form-control" multiple>

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

document.getElementById(containerId).insertAdjacentHTML("beforeend",html)

}

document.addEventListener("click",function(e){

if(e.target.classList.contains("removeRow")){
e.target.closest(".sectionRow").remove()
}

})

</script>

@endsection