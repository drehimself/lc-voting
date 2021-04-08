<div class="card mb-4">
   <div class="card-header">
       <i class="fas fa-table mr-1"></i>
       Tasks
   </div>

   <div class="card-body">
      <div class="table-responsive" id="tasksTable">
         <table class="table table-striped" id="TasksTable">
            <thead class="">
               <tr>
                  <th>Subject</th>
                  <th>Category</th> 
                  <th>Priority</th>
                  <th>Due Date</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @forelse ($tasks as $task)
                  <tr>
                  <td>{{ $task->subject }}</td>
                  <td>{{ $task->board->name }}</td>
                  <td>
                     <span class="badge badge-danger" style="font-size:14px;">{{ status($task->status) }}</span>
                  </td>
                  <td>{{ isset($task->due_date) ? Carbon\Carbon::parse($task->due_date)->format('m/d/Y')  : ''}}</td>
                  <td>
                     <a href="javascript:;" class="btn btn-danger add-delete-task" data-id="{{ $task->id }}"><i class="fa fa-trash"></i></a>
                     <a href="javascript:;"  class="btn btn-info editTaskFromList" data-eid="{{ $task->id }}"><i class="fa fa-edit"></i></a>
                  </td>
                  </tr>
               @empty
                     
               @endforelse
            </tbody>
         </table>
      </div>
   </div>
</div>