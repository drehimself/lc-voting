@extends('biz_tools.layouts.dashboard')
@push('css')
<link rel="stylesheet" href="{{ asset('biz_tools/admin/kanban/custom/custom.css') }}">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
   <style>
      .dataTables_filter {
         display:none;
      }
      .modal .modal-content {
         border-radius: 4px;
         background-color: #fbfcfd;
         color: #4d5a67;
      }
      .modal .modal-content .x-extra-close-icon {
         position: absolute;
         right: 10px;
         top: 10px;
         cursor: pointer;
         z-index: 1000;
         font-size: 18px;
         color: #4c4c4c;
      }
      .modal .modal-dialog {
         margin-top: 30px;
         margin-bottom: 150px;
      }
      .modal .modal-dialog .modal-header {
         min-height: 58px;
         border-bottom: none;
      }
      .modal .modal-dialog .modal-header button.close {
         position: absolute;
         right: 20px;
         top: 20px;
         text-shadow: none;
         background-color: transparent;
         padding: 8px;
         font-size: 18px;
         border-radius: 50%;
         border: none;
      }
      .modal .modal-dialog .modal-header button.close:hover,
      .modal .modal-dialog .modal-header button.close:active,
      .modal .modal-dialog .modal-header button.close:visited,
      .modal .modal-dialog .modal-header button.close:focus {
         border: none;
         outline: none;
      }
      .modal .modal-dialog .modal-header .modal-title {
         color: #20aee3;
      }
      .modal .modal-dialog .modal-body {
         padding-left: 30px;
         padding-right: 30px;
         padding-top: 30px;
      }
      .modal .modal-dialog .modal-body .spacer {
         padding: 10px 0px;
         margin-bottom: 20px;
         font-weight: 500;
      }
      .modal .modal-dialog .modal-body .spacer .title {
         font-weight: 500;
      }
      .modal .modal-dialog .modal-body .splash-image {
         text-align: center;
         padding-bottom: 20px;
      }
      .modal .modal-dialog .modal-body .splash-image img {
         width: 200px;
      }
      .modal .modal-dialog .modal-body .splash-text {
         font-size: 14px;
         text-align: center;
         padding-bottom: 10px;
         font-weight: 500;
      }
      .modal .modal-dialog .modal-body .splash-subtext {
         font-size: 14px;
         text-align: center;
         background-color: #ededf4;
         padding: 7px;
         margin-bottom: 20px;
         border-radius: 4px;
      }
      .modal .modal-dialog .modal-body .line {
         border-top: solid 1px;
         border-color: rgba(120, 130, 140, 0.13);
         height: 27px;
         margin-top: 5px;
      }
      .modal .modal-dialog .modal-body .highlighted-panel {
         padding: 20px;
         background-color: #f7f7f7;
         margin-bottom: 20px;
      }
      .modal .modal-dialog .modal-body .modal-meta-data {
         margin-top: -20px;
         padding-bottom: 20px;
         text-align: right;
      }
      .modal .modal-dialog .modal-body .modal-meta-data small {
         display: block;
      }
      .modal .modal-dialog .modal-body .form-control {
         border-color: #e4e8ec;
      }
      .modal .modal-dialog .modal-body .mce-panel {
         background-color: #fbfcfd;
      }
      .modal .modal-dialog .modal-body .mce-btn button {
         background-color: #fbfcfd;
         opacity: 1 !important;
      }
      .modal .modal-dialog .modal-footer {
         border-radius: inherit;
         border-top-left-radius: 0px;
         border-top-right-radius: 0px;
         border-top: none;
         padding-bottom: 15px;
      }
      .modal .modal-dialog {
         transition: -webkit-transform .3s ease-out;
         transition: transform .3s ease-out;
         transition: transform .3s ease-out, -webkit-transform .3s ease-out;
         -webkit-transform: translate(0, -25%);
         transform: translate(0, -25%);
      }
   @media only screen and (max-width: 800px) {
    
      /* Force table to not be like tables anymore */
      #no-more-tables table, 
      #no-more-tables thead, 
      #no-more-tables tbody, 
      #no-more-tables th, 
      #no-more-tables td, 
      #no-more-tables tr { 
         display: block; 
      }
   
      /* Hide table headers (but not display: none;, for accessibility) */
      #no-more-tables thead tr { 
         position: absolute;
         top: -9999px;
         left: -9999px;
      }
   
      #no-more-tables tr { border: 1px solid #ccc; }
   
      #no-more-tables td { 
         /* Behave  like a "row" */
         border: none;
         border-bottom: 1px solid #eee; 
         position: relative;
         padding-left: 50%; 
         white-space: normal;
         text-align:left;
      }
   
      #no-more-tables td:before { 
         /* Now like a table header */
         position: absolute;
         /* Top/left values mimic padding */
         top: 6px;
         left: 6px;
         width: 45%; 
         padding-right: 10px; 
         white-space: nowrap;
         text-align:left;
         font-weight: bold;
      }
   
      /*
      Label the data
      */
      #no-more-tables td:before { content: attr(data-title); }

      .table{
         background-color:#fff!important;
         box-shadow:0px 2px 2px #aaa!important;
         margin-top:50px!important;
      }

   }
   </style>
@endpush
@section('content')
<div id="layoutSidenav_content">
   <main>
   <!-- loading spinner -->
   <div id="loader" style="display: none"></div>

   <div class="container-fluid" id="ledgers">
      
      <h1 class="" style="margin-top: 14px!important;">Ledgers {{ date('Y') }}</h1>

      <ol class="breadcrumb mb-4">
         <li class="breadcrumb-item">Dashboard</li>
         <li class="breadcrumb-item active">Ledger</li>
      </ol>

      @if ($errors->any())
         <div class="alert alert-danger">
            <ul>
                  @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                  @endforeach
            </ul>
         </div>
      @endif

      <!-- alerts laravel trigger & js trigger --->
      @include('biz_tools.components.dashboard.alerts')
      <div class="alert alert-warning" style="display:none" id="showResponseMessage"></div>
      
      <div class="row">
         <div class="col-sm-12 mb-3">
            <table class="table table-bordered">
               <thead>
                 <tr>
                   <th>Total Income</th>
                   <th>Total Expenses</th>
                   <th>Total Adjustments</th>
                   <th>Ledger Balance</th>
                 </tr>
               </thead>
               <tbody>
                 <tr>
                   <td>$ {{ $totals['income'] }}</td>
                   <td>$ {{ $totals['expense'] }}</td>
                   <td>$ {{ $totals['adjustment'] }}</td>
                   <td>$ {{ $totals['all'] }}</td>
                 </tr>
               </tbody>
            </table>

            <form class="form-inline" action="{{ request()->url() }}">
               <label for="date">From: &nbsp;&nbsp;</label>
               <input type="date" class="form-control" id="date" name="from" value="{{ request()->from }}">
               <label for="pwd">To: &nbsp;&nbsp;</label>
               <input type="date" class="form-control" id="date" name="to" value="{{ request()->to }}">
               &nbsp;&nbsp;
               <button type="submit" class="btn btn-primary">Filter</button>
            </form>
         </div>
      </div>

      <div class="row">
         <div class="col-sm-12 mb-3">
            <button class="customButton" data-target="#addNewLedgerCategoryModal" data-toggle="modal"><i class="fa fa-plus"></i></button>
            <button class="customButton3 addLedgerModal_show" onClick="openLedgerModel('adjustment')"><i class="fa fa-plus"></i> Adjustments</button>
            <button class="customButton3 addLedgerModal_show" onClick="openLedgerModel('expense')"><i class="fa fa-plus"></i> Expenses</button>
            <button class="customButton3 addLedgerModal_show" onClick="openLedgerModel('income')"><i class="fa fa-plus"></i> Income</button>
         </div>
     </div>
      @include('biz_tools.backend.ledgers.components.table')
   </div>
</main>

@include('biz_tools.backend.ledgers.modals.add_new_ledger_category')
@include('biz_tools.backend.ledgers.modals.delete_board')
@include('biz_tools.backend.ledgers.modals.add_ledger')


@endsection

@push('js')
@if ($errors->any())
<script>
    $('#addLedgerModal').modal('show');
</script>
@endif
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
   function ucfirst(str) {
      var firstLetter = str.slice(0,1);
      return firstLetter.toUpperCase() + str.substring(1);
   }
 $(document).ready(function(){

   $('#LedgerTableDT thead tr').clone(true).appendTo('#LedgerTableDT thead');
      $('#LedgerTableDT thead tr:eq(1) th').each(function (i) {
         if(i == 5)
         {
            var title = $(this).text('')
            return '';
         }
         var title = $(this).text();
         $(this).html( '<input type="text" placeholder="Search" style="max-width:150px;margin:0 auto;"/>' );

         $('input', this).on('keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
               table
               .column(i)
               .search( this.value )
               .draw();
            }
         });
   });
   var table = $('#LedgerTableDT').DataTable({
      orderCellsTop: true,
      bLengthChange: false,
      searching: true,
      scrollX:        false,
      scrollCollapse: false,
   });

   $(document).on('click','.add-delete-ledger',function(){
         var id = $(this).attr('data-id');
         var r = confirm('Are you sure?');
         if(r == true)
         {
            $('<form action="ledger/'+id+'" method="post">@csrf @method('DELETE')</form>').appendTo('body').submit();
         }
      });
   });
   const openLedgerModel = (type) => {
       const modal_data = {
            income : {
               heading : 'Add Income',
               type : 'income',
               category : 1,
               taxable : true,
            },
            expense : {
               heading : 'Add Expense',
               type : 'expense',
               category : 8,
               taxable : true,
            },
            adjustment : {
               heading : 'Add Adjustment',
               type : 'adjustment',
               category : 9,
               taxable : false,
            }
       }

       $('#add-edit-ledger-form')[0].reset();
       $('#actionInPopUp').val(modal_data[type].type);
       $('#id').val(0);
       $('#ledger_category_id').val(modal_data[type].category);
       $('#is_taxable').prop('checked',modal_data[type].taxable);
       if(type == 'adjustment')
       {
         $('#ledger_category_id').parent().parent().hide();
         $('#is_taxable').parent().parent().hide();
       }
       else
       {
         $('#ledger_category_id').parent().parent().show();
         $('#is_taxable').parent().parent().show();
       }
       $('#date-add').val(new Date().toISOString().replace('/', '-').split('T')[0].replace('/', '-'));
       $('#commonModalTitle').text(modal_data[type].heading);
       $('#addLedgerModal').modal('show');
   }
   $(document).on('click','.editLedgerFromList',function(){
     
     $('#tasks').hide();
     $('#loader').show();
     var ledger_id = $(this).attr('data-eid');
     $.ajax({
        type: "GET",
        url: '/ledger/'+ ledger_id,
        success: function (data) {
            
           $('#loader').hide();
           if(data.status)
           {
               var ledger = data.data;
               // fill up the hidden edit fields
               $('#commonModalTitle').text('Edit ' + ucfirst(ledger.type));
               $('.detail-edit-delete-lead').attr('data-id',ledger.id);
               $('#id').val(ledger.id);
               $('#actionInPopUp').val('update');
               $('#amount').val(ledger.amount);
               $('#description').val(ledger.description);
               if(ledger.is_taxable == 1)
               {
                  $('#is_taxable').prop('checked',true).parent().parent().show();
               }
               else
               {
                  $('#is_taxable').prop('checked',false).parent().parent().show();
               }
               $('#actionInPopUp').val(ledger.type);
               $('#id').val(ledger.id);
               $('#ledger_category_id').val(ledger.ledger_category_id).parent().parent().show();
               $('#date').val(new Date(ledger.date).toISOString().replace('/', '-').split('T')[0].replace('/', '-'));
               $('#addLedgerModal').modal('show');
           }
           else {
              alert('NO LEAD FOUND');
           }
        },
        error: function() {
           $('#tasks').show();
           $('#loader').hide(); 
           alert('Oops Something Went Wrong');
        }
     });
  });
</script>
@endpush