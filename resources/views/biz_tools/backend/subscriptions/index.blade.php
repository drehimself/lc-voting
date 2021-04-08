@extends('biz_tools.layouts.dashboard')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <style>
    /* Center the loader */
    #loader {
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 1;
        width: 120px;
        height: 120px;
        margin: -76px 0 0 -76px;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
        background: none;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Add animation to "page content" */
    .animate-bottom {
        position: relative;
        -webkit-animation-name: animatebottom;
        -webkit-animation-duration: 1s;
        animation-name: animatebottom;
        animation-duration: 1s
    }

    @-webkit-keyframes animatebottom {
        from { bottom:-100px; opacity:0 } 
        to { bottom:0px; opacity:1 }
    }

    @keyframes animatebottom { 
        from{ bottom:-100px; opacity:0 } 
        to{ bottom:0; opacity:1 }
    }
    .dt-body-right {
        text-align : right;
    }
    </style> 
@endpush
@section('content')
<div id="layoutSidenav_content">
    <main>
    <!-- loading spinner -->
   <div id="loader" style="display: none"></div>
        
        <div class="container-fluid" id="subscriptions">
            <div class="col-md-12 mb-3 mt-4">
                <h1 class="" style="display: inline;">Subscriptions</h1>
                <button class="btn btn-danger pull-right"  style="float:right" data-target="#subscriptionAddModal" data-toggle="modal"><i class="fa fa-plus"></i></button>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active">Subscriptions</li>
            </ol>

            @include('biz_tools.components.dashboard.alerts')
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Subscriptions
                </div>

                <div class="card-body">
                    <h3>Recurring Monthly Business Costs ${{ moneyFormat($total) ?? '' }}</h3>
                    <br>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered" id="subscriptionsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Website Link</th>
                                    <th>Monthly Cost</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('biz_tools.backend.subscriptions.modals.add')
    @include('biz_tools.backend.subscriptions.modals.edit')

@endsection
@push('js')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<script>
    const params = new URLSearchParams(location.search);
    initDataTable();
    function initDataTable (searchName = '',websiteLink = '') {
        var table = $('#subscriptionsTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url : '{!! route('subscription.data.fetch') !!}',
                "dataType": "json",
                "type": "get",
                "data":{ _token: "{{csrf_token()}}",searchName : searchName,websiteLink : websiteLink}
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'website_link', name: 'website_link' },
                { data: 'monthly_cost', name: 'monthly_cost' },
                { data: 'action', name: 'action' }
            ],
            columnDefs: [
                {
                    targets: 2,
                    className: 'dt-body-right'
                }
            ],
            initComplete: function() {
                $("#subscriptionsTable > thead tr#filters").remove();

                $("#subscriptionsTable > thead").append(`<tr id="filters">
                <th>
                    <input type="text" placeholder="Search" class="column_search" id="searchName" value="${params.get('name') ? params.get('name') : ''}"/>
                </th>
                <th>
                    <input type="text" placeholder="Search" class="column_search" id="websiteLink" value="${params.get('website') ? params.get('website') : ''}"/>
                </th>
                <th></th>  
                <th></th>  
                </tr>`);
            }
        });
    };
    $(document).ready(function() {
        // Event listener to the two range filtering inputs to redraw on input
        $(document).on('keypress','#searchName',function() {
            var keycode = event.keyCode || event.which;
            if(keycode == '13') {
                params.set('name', $(this).val());
                params.set('website', $("#subscriptionsTable > thead tr#filters").find('input#websiteLink').val());
                params.toString(); // => test=123&cheese=yummy
                window.history.replaceState({}, '', `${location.pathname}?${params.toString()}`);
                $('#subscriptionsTable').DataTable().destroy();
                initDataTable($(this).val(),$("#subscriptionsTable > thead tr#filters").find('input#websiteLink').val());
            }
        });
        $(document).on('keypress','#websiteLink',function() {
            var keycode = event.keyCode || event.which;
            if(keycode == '13') {
                params.set('website', $(this).val());
                params.set('name', $("#subscriptionsTable > thead tr#filters").find('input#searchName').val());
                params.toString(); // => test=123&cheese=yummy
                window.history.replaceState({}, '', `${location.pathname}?${params.toString()}`);
                $('#subscriptionsTable').DataTable().destroy();
                initDataTable($("#subscriptionsTable > thead tr#filters").find('input#searchName').val(),$(this).val());
            }
        });

        $(document).on('click','.editItem',function(){
            $('#loader').show();
            $('#subscriptions').hide();
            var id = $(this).attr('data-id');
            $.ajax({
                method: 'get',
                url : '/subscriptions/' + id,
                success: function(data) {
                    if(data.status)
                    {
                        $('#subscriptions').show();
                        $('#loader').hide();

                        var data = data.data;
                        $('#edit-subscription-name').val(data.name);
                        $('#edit-subscription-website').val(data.website_link);
                        $('#edit-subscription-cost').val(data.monthly_cost);
                        $('#subscriptionEditForm').attr('action','/subscriptions/'+data.id);
                        $('#subscriptionEditModal').modal('show');
                    }
                },
                error: function() {
                    $('#subscriptions').show();
                    $('#loader').hide();
                    alert('Oops Something Went Wrong');
                }
            })
        });

        $(document).on('click','.deleteItem',function(){
            var id = $(this).attr('data-id');
            var r = confirm('Are you sure?');
            if(r == true)
            {
                $('<form action="subscriptions/'+id+'" method="post">@csrf @method('DELETE')</form>').appendTo('body').submit();
            }
        });
    });
</script>
@endpush