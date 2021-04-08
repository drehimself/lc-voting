@extends('biz_tools.layouts.dashboard')


@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Customers</h1>
            
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active">Customers</li>
            </ol>

            @include('biz_tools.components.dashboard.alerts')
            
            <div class="col-md-12 mb-3">
                <button class="btn btn-danger pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Customers
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="customersTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Client</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Position</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customers as $customer)
                                    <tr>
                                        <td>{{ $customer->name .' '. $customer->last_name }}</td>
                                        <td>ABC</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->telephone }}</td>
                                        <td>{{ $customer->position }}</td>
                                        <td><a href="#" data-toggle="modal" data-target="#editModal-{{ $customer->id }}">Edit</a></td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @forelse ($customers as $customer)
    
    <!-- customer edit modal --->
    <div class="modal" id="editModal-{{ $customer->id }}">
        <div class="modal-dialog">
        <div class="modal-content">
    
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Edit Customer</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
    
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{ route('customers.update',['customer' => $customer->id]) }}" method="post" id="customerEditForm-{{ $customer->id }}">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="name" class="form-control" placeholder="Enter Name" name="name" required value="{{ $customer->name }}">
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name <span class="text-danger">*</span></label>
                        <input type="name" class="form-control" placeholder="Enter Last Name" name="name" required value="{{ $customer->last_name }}">
                    </div>
                    <div class="form-group">
                      <label for="email">Email <span class="text-danger">*</span></label>
                      <input type="email" class="form-control" placeholder="Enter email" name="email" required value="{{ $customer->email }}">
                    </div>
                    <div class="form-group">
                      <label for="phone">Phone</label>
                      <input type="text" class="form-control" placeholder="Enter Phone" name="phone" value="{{ $customer->phone }}">
                    </div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" placeholder="Enter position" name="position" value="{{ $customer->position }}">
                      </div>
                </form>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
            <button class="btn btn-info pull-right" data-id="{{ $customer->id }}" onclick="var r = confirm('Are you sure?'); if(r == true) window.location.href = 'convert/customer/lead/' + event.target.getAttribute('data-id')"><i class="fa fa-anchor"></i> Convert to lead</button>
            <button type="submit" class="btn btn-primary" form="customerEditForm-{{ $customer->id }}">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
    
        </div>
        </div>
    </div>
    @empty

    @endforelse
    <!-- customer edit modal --->

    <!-- customer add modal --->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
    
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Add New Customer</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
    
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{ route('customers.store') }}" id="customerAddForm" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="name" class="form-control" placeholder="Enter Name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name <span class="text-danger">*</span></label>
                        <input type="name" class="form-control" placeholder="Enter Last Name" name="last_name" required>
                    </div>
                    <div class="form-group">
                      <label for="email">Email <span class="text-danger">*</span></label>
                      <input type="email" class="form-control" placeholder="Enter email" name="email" required>
                    </div>
                    <div class="form-group">
                      <label for="phone">Phone</label>
                      <input type="text" class="form-control" placeholder="Enter Phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" placeholder="Enter position" name="position">
                      </div>
                </form>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary" form="customerAddForm">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
    
        </div>
        </div>
    </div>
    <!-- customer end modal --->
@endsection
@push('js')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function(){
            $('#customersTable').DataTable({
                // paging : false,
            });
        });
    </script>
@endpush