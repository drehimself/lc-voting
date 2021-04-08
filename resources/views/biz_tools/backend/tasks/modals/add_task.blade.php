<div class="modal modal-static" aria-labelledby="foo" id="addTaskModal" data-keyboard="false" data-backdrop="static" aria-modal="true" role="dialog" x-data="{showDetails : false}">
    <div class="modal-dialog modal-lg" id="commonModalContainer">
       <form action="{{ route('tasks.store') }}" method="post" id="add-edit-task-form" class="form-horizontal">
        @csrf
        <input type="hidden" value="" name="action" id="actionInPopUp">
        <input type="hidden" value="" name="taskID" id="taskIdInPopUp">
        <div class="modal-content">
             <div class="modal-header" id="commonModalHeader">
               <h4 class="modal-title" id="commonModalTitle">Add Task</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="commonModalCloseIcon">
                <i class="ti-close"></i>
                </button>
             </div>
             <!--optional button for when header is hidden-->
             <span class="close x-extra-close-icon" data-dismiss="modal" aria-hidden="true" id="commonModalExtraCloseIcon" style="display: none;">
             <i class="ti-close"></i>
             </span>
             <div class="modal-body min-h-200" id="commonModalBody">
                <div class="row">
                   <div class="col-lg-12">
                      <!--meta data - creatd by-->
                      <!--title-->
                      <div class="form-group row">
                         <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Task Subject*</label>
                         <div class="col-sm-12 col-lg-9">
                            <input type="text" class="form-control form-control-sm" id="task_subject" name="task_subject" placeholder="" value="" required>
                         </div>
                      </div>
                      
                      <!--Boards-->
                      <div class="form-group row">
                         <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Category*</label>
                         <div class="col-sm-12 col-lg-9">
                            <select class="form-control form-control-sm" id="task_board" name="task_board" tabindex="-1" aria-hidden="true" required>
                               @forelse ($taskBoards as $board)
                                   <option value="{{ $board->id }}">{{ $board->name }}</option>
                               @empty
                                   
                               @endforelse
                            </select>
                         </div>
                      </div>
                      
                         <!--task status-->
                         <div class="form-group row">
                            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Priority</label>
                            <!--existing-->
                            <div class="col-sm-12 col-lg-9">
                               <select class="form-control form-control-sm " id="task_status" name="task_status" tabindex="-1" aria-hidden="true">
                                  <option value="1">High</option>
                                  <option value="2">Medium</option>
                                  <option value="3">Low</option>
                               </select>
                            </div>
                            <!--/#existing-->
                         </div>
                         <!--Due Date-->
                         <div class="form-group row">
                            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Due Date</label>
                            <div class="col-sm-12 col-lg-9">
                               <input type="date" class="form-control form-control-sm" autocomplete="off" name="due_date" value="" id="due_date">
                            </div>
                         </div>
                         <div class="line"></div>
                      </div>
                      <!--lead details-->
                   </div>
                </div>
             <div class="modal-footer" id="commonModalFooter" style="">
               <a class="btn btn-default pull-right add-delete-task" style="display: none;" data-id=""><i class="fa fa-trash"></i> Delete</a>
               <button type="button" id="commonModalCloseButton" class="btn btn-rounded-x btn-secondary waves-effect text-left" data-dismiss="modal">Close</button>
               <button type="submit" id="commonModalSubmitButton" class="btn btn-rounded-x btn-danger waves-effect text-left" data-url="https://demo.growcrm.io/leads?leadresource_id=&amp;leadresource_type=" data-loading-target="commonModalBody" data-ajax-type="POST" data-on-start-submit-button="disable">Submit</button>
             </div>
          </div>
       </form>
    </div>
 </div>