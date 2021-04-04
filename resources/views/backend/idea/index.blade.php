@extends('backend.layouts.app',[
    'page' => 'Ideas'
])
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Idea | List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ideas as $idea)
                            <tr>
                                <td>{{ $idea->title }}</td>
                                <td>{{ $idea->category->name }}</td>
                                <td>{{ $idea->created_at->format('m/d/Y') }}</td>
                                <td>
                                    <a href="{{ route('backend.idea.edit',['idea'=>$idea->id]) }}" class="btn btn-info">Edit</a>

                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $ideas->links() }}
        </div>
    </div>
@endsection
