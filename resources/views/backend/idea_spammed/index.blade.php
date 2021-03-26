@extends('backend.layouts.app',[
    'page' => 'Ideas'
])

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ideas | List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Spam Count</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ideas as $idea)
                            <tr>
                                <td>
                                    <a href="{{ route('idea.show',['idea' => $idea->slug]) }}">
                                        {{ $idea->title }}
                                    </a>
                                </td>
                                <td>
                                    <span class="btn btn-danger">
                                        {{ $idea->spams_count }}
                                    </span>
                                </td>
                                <td>{{ $idea->created_at->format('m/d/Y') }}</td>
                                <td>
                                    <a href="javascript:;" class="btn btn-danger btn-icon-split delete-row"
                                    data-id="{{ $idea->id }}" data-url="{{ route('spam.ideas.destroy',['idea' => $idea->id]) }}" data-method="DELETE">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">Delete</span>
                                    </a>
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