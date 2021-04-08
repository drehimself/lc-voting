@extends('biz_tools.layouts.dashboard')
@push('css')
<link rel="stylesheet" href="{{ asset('biz_tools/admin/kanban/dist/jkanban.css') }}">
<link rel="stylesheet" href="{{ asset('biz_tools/admin/kanban/modal.css') }}">
<link rel="stylesheet" href="{{ asset('biz_tools/admin/kanban/custom/custom.css') }}">
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<style>
   .dataTables_filter {
      display: none;
   }
</style>
@endpush
@section('content')
<div id="layoutSidenav_content">
   <main>
   <!-- loading spinner -->
   <div id="loader" style="display: none"></div>

   <div class="container-fluid" id="leads">
      
      <h1 class="">Sales Leads</h1>

      <ol class="breadcrumb mb-4">
         <li class="breadcrumb-item">Dashboard</li>
         <li class="breadcrumb-item active">Leads</li>
      </ol>

      <!-- alerts laravel trigger & js trigger --->
      @include('biz_tools.components.dashboard.alerts')
      <div class="alert alert-warning" style="display:none" id="showResponseMessage"></div>

      <div class="row">
         <div class="col-sm-12 mb-3">
            <button class="customButton" data-target="#addNewBoardModal" data-toggle="modal"><i class="fa fa-plus"></i></button>
            <button class="customButton3 addLeadModal_show"><i class="fa fa-plus"></i> Lead</button>
            <button class="customButton2" data-ref="kanban" id="viewToggle"><i class="fa fa-list"></i></button>  
         </div>
     </div>

     <!-- kanban -->
     <div class="row" id="kanbanDIV">
        <div class="col-md-12">
            <div id="myKanban"></div>
         </div>
      </div>
      <!-- kanban end --->
      <div class="card" id="listDIV">
         <div class="card-header">Leads</div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table table-striped" id="listTable">
                  <thead class="">
                     <tr>
                        <th>Title</th>
                        <th>Contact</th>
                        <th>Contacted</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @forelse ($leads as $lead)
                        <tr>
                        <td>{{ $lead->title }}</td>
                        <td>{{ $lead->telephone }}</td>
                        <td>{{ isset($lead->last_contacted) ? Carbon\Carbon::parse($lead->last_contacted)->format('m/d/Y')  : ''}}</td>
                        <td>
                           <span class="badge badge-info">{{ $lead->category }}</span>
                        </td>
                        <td>
                           <span class="badge badge-success" style="font-size:16px;">{{ $lead->board->title }}</span>
                        </td>
                        <td>
                           <a href="{{ route('delete.lead',['lead' => $lead->id]) }}"  class="btn btn-danger" 
                              onclick="event.preventDefault(); var r = confirm('Are You Sure?'); if(r == true) window.location.href = '{{ route('delete.lead',['lead' => $lead->id]) }}'"><i class="fa fa-trash"></i></a>
                           <a href="javascript:;"  class="btn btn-info editLeadFromList" data-eid="{{ $lead->id }}"><i class="fa fa-edit"></i></a>
                        </td>
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

@include('biz_tools.backend.leads.modals.add_board')
@include('biz_tools.backend.leads.modals.delete_board')
@include('biz_tools.backend.leads.modals.add_lead')
@include('biz_tools.backend.leads.modals.edit_lead')

@endsection
@push('js')
<script src="{{ asset('biz_tools/admin/kanban/dist/jkanban.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js"></script>
<script>
   $(document).ready(function(){

      $('#listTable thead tr').clone(true).appendTo('#listTable thead');
         $('#listTable thead tr:eq(1) th').each(function (i) {
            if(i > 4)
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
   
      var table = $('#listTable').DataTable( {
         orderCellsTop: true,
         bLengthChange: false,
         searching: true,
         scrollX:        false,
         scrollCollapse: false,
      });
      
      ClassicEditor
      .create(document.querySelector('.details-edit-tinymce-textarea'),{
         height : '300px',
      })
      .then( editor => {
         window.notes = editor;
      })
      .catch( error => {
         // 
      });

      $('input').keypress(function (e) {
         var key = e.which;
         if(key == 13)  // the enter key code
         {
            $('.updateBtnInEditModal').click(); 
            return false;
         }
      });

      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });

      // populating boards with leads
      var newBoards = [];
      @foreach($boards as $board)
      newBoards.push({ 
         id : "{{ $board->id }}",
         title : "{{ $board->title }}",
         class: "{{ $board->class }}",
         item: [
            @foreach($board->leads as $lead)
            {
               id: "{{  $lead->id }}",
               title: "{{ $lead->title }}",
               class: ["hello"],
               sort : "{{ $lead->sort_order }}"
            },
            @endforeach()
         ]
      });
      @endforeach()

      // initliazing kanban
      window.KanbanTest = new jKanban({
      element: "#myKanban",
      gutter: "10px",
      widthBoard: "450px",
      itemHandleOptions:{
         enabled: true,
      },
      click: function(el) {
         
         $('#leads').hide();
         $('#loader').show();
         // fetch lead details
         $.ajax({
            type: "POST",
            url: '/fetch/lead/'+ el.dataset.eid,
            success: function (data) {
               $('#leads').show();
               $('#loader').hide(); 
               if(data.status)
               {
                  var lead = data.data;

                  // fill up the hidden edit fields
                  $('.detail-edit-delete-lead').attr('data-id',lead.id);
                  $('.detail-edit-convert-to-customer').attr('data-id',lead.id);
                  $('#detail-edit-leadIdInPopUp').val(lead.id);
                  $('#detail-edit-actionInPopUp').val('update');
                  $('#detail-edit-lead_title').val(lead.title);
                  $('#detail-edit-lead_firstname').val(lead.name);
                  $('#detail-edit-lead_lastname').val(lead.last_name);
                  $('#detail-edit-lead_phone').val(lead.telephone);
                  $('#detail-edit-lead_email').val(lead.email);
                  $('#detail-edit-lead_status_add').val(lead.board.id);
                  window.notes.setData(JSON.parse(lead.notes) === null ? '<p></p>' : JSON.parse(lead.notes));
                  $('#detail-edit-lead_source').val(lead.source);
                  $('#detail-edit-lead_categoryid').val(lead.category);
                  $('#detail-edit-lead_last_contacted').val(new Date(lead.last_contacted).toISOString().replace('/', '-').split('T')[0].replace('/', '-'));

                  $('#cardModal').modal('show');

               }
               else {
                  alert('NO LEAD FOUND');
               }
            },
            error: function() {
               $('#leads').show();
               $('#loader').hide(); 
               alert('Oops Something Went Wrong');
            }
         });
      },
      dropEl: function(el, target, source, sibling){
            var sort;
            // console.log('new board == ' + target.parentElement.getAttribute('data-id'));
            // console.log(el, target, source, sibling);
            // console.log('lead ID == ',el.dataset.eid);
            // console.log(el.previousSibling != null ? el.previousSibling.dataset.status : '');
            // console.log(el);
            // console.log(sibling != null ? sibling.dataset.status : '');

            // if prevSibling is null then sort will be 1...
            // if sibling is null then its the last item...
            // if both prevSibling & sibling present then add prevSibling + 1 will be new order...
            if(el.previousSibling != null && sibling != null) // somewhere in the middle
            {
               sort = parseInt(el.previousSibling.dataset.sort) + 1;
            }
            else if (el.previousSibling === null && sibling != null) // it mean drop at the first position...
            {
               sort = 1;
            }
            else if (el.previousSibling != null && sibling === null) // it mean drop at the last position...
            {
               sort = parseInt(el.previousSibling.dataset.sort) + 1;
            }
            else
            {
               sort = 1;
            }
            
            $('#leads').hide();
            $('#loader').show();

            $.ajax({
               type: "POST",
               url: '{{ route("update.lead.board") }}',
               data: {new_board : target.parentElement.getAttribute('data-id'), lead_id : el.dataset.eid,sort : sort},
               success: function (data) {
                  $('#leads').show();
                  $('#loader').hide(); 

                  if(data.status)
                  {
                     $('#showResponseMessage').text('Lead Moved Successfully').fadeIn().delay(3000).fadeOut();
                  }
                  else
                  {
                     $('#showResponseMessage').text('Something Went Wrong').fadeIn().delay(5).fadeOut();
                  }
               },
               error: function() {
                  $('#leads').show();
                  $('#loader').hide();
                  alert('Oops Something Went Wrong');
               }
            });
      },
      boards: newBoards,
      });

      // delete LEAD
      $('.confirm-action-danger').click(function(){
         
         $('#leads').hide();
         $('#loader').show();
         $('#cardModal').modal('hide');

         $.ajax({
               type: "get",
               dataType : 'json',
               url: $(this).attr('data-url'),
               success: function (data) {

                  $('#leads').show();
                  $('#loader').hide(); 
                  
                  if(data.status)
                  {
                     window.location.reload();
                  }
                  else
                  {
                     $('#showResponseMessage').text('Something Went Wrong').fadeIn().delay(5).fadeOut();
                  }
               },
               error: function() {
                  $('#leads').show();
                  $('#loader').hide();
                  alert('Oops Something Went Wrong');
               }
            });
      });
   });

   // custom events & actions
   $(document).ready(function(){

      viewToggle($('#viewToggle'));

      $('.addToBoard').click(function(){
         $('#lead_status_add').val($(this).attr('data-id'));
         $('#addLeadModal').modal('show');
      });

      $('.deleteBoard').click(function(){
         $('#deleteModalBoardID').val($(this).attr('data-id'));
         $('#destroyBoard').attr('action','/boards/'+$(this).attr('data-id'));
         $('#deleteBoardModal').modal('show');
      });

      // show add lead modal and hide convert + delete btn
      // addLeadModal
      $('.addLeadModal_show').click(function(){
         $('.add-lead-convert-to-customer').hide();
         $('.add-delete-lead').hide();
         $('#commonModalForm')[0].reset();
         window.editor.setData('');
         $('#addLeadModal').modal('show');
      });

      // view toggle
      $('#viewToggle').click(function(){
         var view = $(this).attr('data-ref');
         localStorage.setItem("view", view);
         viewToggle($(this),view);
      });

      function viewToggle(object) {
         var view = localStorage.getItem("view", view);

         if(view == 'kanban')
         {
            $('#kanbanDIV').hide();
            $('#listDIV').show();
            object.attr('data-ref','list');
         }
         if(view == 'list')
         {
            $('#kanbanDIV').show();
            $('#listDIV').hide();
            object.attr('data-ref','kanban');
         }
      }
   });

   // edit the lead
   $('.editLeadFromList').click(function(){
     
      $('#leads').hide();
      $('#loader').show(); 
      var leadID = $(this).attr('data-eid');
      $.ajax({
            type: "POST",
            url: '/fetch/lead/'+ leadID,
            success: function (data) {
               $('#leads').show();
               $('#loader').hide(); 
               if(data.status)
               {
                  var lead = data.data;
                  $('.detail-edit-delete-lead').attr('data-id',lead.id);
                  $('.detail-edit-convert-to-customer').attr('data-id',lead.id);
                  $('#detail-edit-leadIdInPopUp').val(lead.id);
                  $('#detail-edit-actionInPopUp').val('update');
                  $('#detail-edit-lead_title').val(lead.title);
                  $('#detail-edit-lead_firstname').val(lead.name);
                  $('#detail-edit-lead_lastname').val(lead.last_name);
                  $('#detail-edit-lead_phone').val(lead.telephone);
                  $('#detail-edit-lead_email').val(lead.email);
                  $('#detail-edit-lead_status_add').val(lead.board.id);
                  window.notes.setData(JSON.parse(lead.notes) === null ? '<p></p>' : JSON.parse(lead.notes));
                  $('#detail-edit-lead_source').val(lead.source);
                  $('#detail-edit-lead_categoryid').val(lead.category);
                  $('#detail-edit-lead_last_contacted').val(new Date(lead.last_contacted).toISOString().replace('/', '-').split('T')[0].replace('/', '-'));
                 
                  $('#cardModal').modal('show');
               }
               else {
                  alert('NO LEAD FOUND');
               }
            },
            error: function() {
               $('#leads').show();
               $('#loader').hide(); 
               alert('Oops Something Went Wrong');
            }
         });
   });

   ClassicEditor
      .create(document.querySelector('.tinymce-textarea'),{
         height : '300px',
      })
      .then( editor => {
         window.editor = editor;
      } )
      .catch( error => {
         // 
      });
</script>
@endpush