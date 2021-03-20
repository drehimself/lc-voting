@extends('backend.layouts.app',[
    'page' => 'User'
])

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Users | List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created at</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="btn btn-{{ roleName($user->role_id)['class'] }}">
                                        {{ roleName($user->role_id)['name'] }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('m/d/Y') }}</td>
                                <td>
                                    <a href="" class="btn btn-info">Edit</a>
                                    <a href="javascript:;" class="btn btn-danger btn-icon-split delete-row"
                                    data-id="{{ $user->id }}" data-url="{{ route('users.destroy',['user' => $user->id]) }}" data-method="DELETE">
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
        </div>
    </div>
@endsection