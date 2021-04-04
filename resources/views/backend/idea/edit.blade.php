@extends('backend.layouts.app',[
'page' => 'Edit Ideas'
])
@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Idea</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('backend.idea-backend.update',['idea_backend' => $idea->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                            value="{{ $idea->title }}">
                        @error('title')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id"
                            class="form-control @error('category_id') is-invalid @enderror">
                            <option selected disabled>Select Option</option>
                            @forelse ($category as $row)
                            <option value="{{ $row->id }}" {{ $row->id==$idea->category_id ? 'selected':'' }}>
                                {{ $row->name }}</option>
                            @empty

                            @endforelse
                        </select>
                        @error('category_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">

                    <div class="form-group">
                        <label for="">File</label>
                        <input type="file" class="form-control-file" name="file" aria-describedby="fileHelpId">
                        <small id="fileHelpId" class="form-text text-muted">upload file</small>
                        <input type="hidden" name="old_file" value="{{ $idea->files }}">
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                            id="" cols="30" rows="10">{{ $idea->description }}</textarea>
                        @error('description')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="{{ route('idea.index') }}" class="btn btn-danger">Back</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
