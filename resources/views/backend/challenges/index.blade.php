@extends('backend.layouts.app',[
    'page' => 'Challenges'
])
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Challenges | List</h6>
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
                        @forelse ($challenges as $challenge)
                            <tr>
                                <td>{{ $challenge->title }}</td>
                                <td>{{ $challenge->category->name }}</td>
                                <td>{{ $challenge->created_at->format('m/d/Y') }}</td>
                                <td>
                                    <a href="{{ route('backend.challenges.edit',['challenge'=>$challenge->id]) }}" class="btn btn-info">Edit</a>

                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $challenges->links() }}
        </div>
    </div>
@endsection
