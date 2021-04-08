@extends('biz_tools.layouts.dashboard')
@push('css')
@if (request()->view == '' || request()->view == 'kanban')
   <link rel="stylesheet" href="{{ asset('biz_tools/admin/kanban/dist/jkanban.css') }}">
   <link rel="stylesheet" href="{{ asset('biz_tools/admin/kanban/modal.css') }}">
   <link rel="stylesheet" href="{{ asset('biz_tools/admin/kanban/custom/custom.css') }}">
   @else
   <link rel="stylesheet" href="{{ asset('biz_tools/admin/kanban/custom/custom.css') }}">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <style>
        .dataTables_filter {
            display:none;
        }
    </style>
@endif
@endpush
@section('content')
<div id="layoutSidenav_content">
   <main>
   <!-- loading spinner -->
   <div id="loader" style="display: none"></div>

   <div class="container-fluid" id="tasks">
      
      <h1 class="">Tasks</h1>

      <ol class="breadcrumb mb-4">
         <li class="breadcrumb-item">Dashboard</li>
         <li class="breadcrumb-item active">Tasks</li>
      </ol>

      <!-- alerts laravel trigger & js trigger --->
      @include('biz_tools.components.dashboard.alerts')
      <div class="alert alert-warning" style="display:none" id="showResponseMessage"></div>

      <div class="row">
         <div class="col-sm-12 mb-3">
            <button class="customButton" data-target="#addNewTaskBoardModal" data-toggle="modal"><i class="fa fa-plus"></i></button>
            <button class="customButton3 addTaskModal_show"><i class="fa fa-plus"></i> Task</button>
            <button class="customButton2" onclick="window.location.href='{{ request()->url() . '?view='.setTheQueryStringForViewToggle()}}'"><i class="fa fa-list"></i></button>  
         </div>
     </div>

     @if (request()->view == '' || request()->view == 'kanban')
      @include('biz_tools.backend.tasks.components.kanban')
     @else
      @include('biz_tools.backend.tasks.components.table')
     @endif
   </div>
</main>

@include('biz_tools.backend.tasks.modals.add_task_board')
@include('biz_tools.backend.tasks.modals.delete_board')
@include('biz_tools.backend.tasks.modals.add_task')

@endsection
@push('js')
@if (request()->view == '' || request()->view == 'kanban')
<script src="{{ asset('biz_tools/admin/kanban/dist/jkanban.js') }}"></script>
@else
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js"></script>
@endif
<script>
   @if (request()->view == '' || request()->view == 'kanban')
   // only in kanban
   $(document).ready(function(){

      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });

      // populating boards with leads
      var newBoards = [];
      @foreach($taskBoards as $board)
      newBoards.push({ 
         id : "{{ $board->id }}",
         title : "{{ $board->name }}",
         class: "{{ $board->class }}",
         item: [
            @foreach($board->tasks as $lead)
            {
               id: "{{  $lead->id }}",
               title: "{{ $lead->subject }}",
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
         
         $('#tasks').hide();
         $('#loader').show();
         // fetch lead details
         $.ajax({
            type: "GET",
            url: '/tasks/'+ el.dataset.eid,
            success: function (data) {
               $('#tasks').show();
               $('#loader').hide(); 
               if(data.status)
               {
                    var task = data.data;

                    // fill up the hidden edit fields
                    $('#taskIdInPopUp').val(task.id);
                    $('#actionInPopUp').val('update');
                    $('#task_subject').val(task.subject);
                    $('#task_board').val(task.board_id);
                    $('#task_status').val(task.status);
                    $('#due_date').val(new Date(task.due_date).toISOString().replace('/', '-').split('T')[0].replace('/', '-'));

                    $('.add-delete-task').attr('data-id',task.id).show();
                    $('#addTaskModal').modal('show');
               }
               else {
                  alert('NO Task FOUND');
               }
            },
            error: function() {
               $('#tasks').show();
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

            $('#tasks').hide();
            $('#loader').show();

            $.ajax({
               type: "POST",
               url: '{{ route("update.tasks.board") }}',
               data: {new_board : target.parentElement.getAttribute('data-id'), task_id : el.dataset.eid,sort : sort},
               success: function (data) {
                  $('#tasks').show();
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
                  alert('Oops Something Went Wrong');
                  $('#tasks').show();
                  $('#loader').hide(); 
               }
            });
      },
      boards: newBoards,
      });
   });
   // only in kanban
   @endif

   // custom events & actions
   $(document).ready(function(){
      
      @if (request()->view != '' && request()->view != 'kanban')
         // Setup - add a text input to each footer cell
         $('#TasksTable thead tr').clone(true).appendTo('#TasksTable thead');
            $('#TasksTable thead tr:eq(1) th').each(function (i) {
               if(i > 3)
               {
                  var title = $(this).text('')
                  return '';
               }
               var title = $(this).text();
               $(this).html( '<input type="text" placeholder="Search" style="max-width:150px;margin:0 auto;"/>' );
      
               $( 'input', this ).on( 'keyup change', function () {
                  if ( table.column(i).search() !== this.value ) {
                     table
                     .column(i)
                     .search( this.value )
                     .draw();
                  }
               } );
         } );
      
         var table = $('#TasksTable').DataTable( {
            orderCellsTop: true,
            pageLength: 50,
            bLengthChange: false,
            searching: true, 
            fixedHeader: true,
            scrollX:        false,
            scrollCollapse: false,
            paging:         true,
            columnDefs: [
               { width: 20, targets: 0 }
            ],
            fixedColumns: true
         });
      @endif

      $('.addToBoard').click(function(){
         $('#task_board').val($(this).attr('data-id'));
         $('#add-edit-task-form')[0].reset();
         $('#addTaskModal').modal('show');
      });

      $('.deleteBoard').click(function(){
         $('#deleteModalBoardID').val($(this).attr('data-id'));
         $('#destroyBoard').attr('action','/task-board/'+$(this).attr('data-id'));
         $('#deleteBoardModal').modal('show');
      });

      // delete lead from popup...
      $(document).on('click','.add-delete-task',function(){
         var id = $(this).attr('data-id');
         var r = confirm('Are you sure?');
         if(r == true)
         {
            $('<form action="tasks/'+id+'" method="post">@csrf @method('DELETE')</form>').appendTo('body').submit();
         }
      });

      // show add task modal and hide convert + delete btn
      $('.addTaskModal_show').click(function(){
         $('.add-delete-task').hide();
         $('#add-edit-task-form')[0].reset();
         $('#addTaskModal').modal('show');
      });
   });

   // edit the lead
   $(document).on('click','.editTaskFromList',function(){
     
      $('#tasks').hide();
      $('#loader').show();
      var taskID = $(this).attr('data-eid');
      $.ajax({
         type: "GET",
         url: '/tasks/'+ taskID,
         success: function (data) {
            $('#tasks').show();
            $('#loader').hide(); 
            if(data.status)
            {
               var task = data.data;
               // fill up the hidden edit fields
               $('.detail-edit-delete-lead').attr('data-id',task.id);
               $('#taskIdInPopUp').val(task.id);
               $('#actionInPopUp').val('update');
               $('#task_subject').val(task.subject);
               $('#task_board').val(task.board_id);
               $('#task_status').val(task.status);
               $('#due_date').val(new Date(task.due_date).toISOString().replace('/', '-').split('T')[0].replace('/', '-'));

               $('.add-delete-task').attr('data-id',task.id).show();
               $('#addTaskModal').modal('show');
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