<div class="modal modal-static" aria-labelledby="foo" id="addLedgerModal" data-keyboard="false" data-backdrop="static" aria-modal="true" role="dialog" x-data="{showDetails : false}">
    <div class="modal-dialog modal-lg" id="commonModalContainer">
       <form action="{{ route('ledger.store') }}" method="post" id="add-edit-ledger-form" class="form-horizontal">
        @csrf
        <input type="hidden" value="" name="type" id="actionInPopUp">
        <input type="hidden" value="" name="id" id="id">
        <div class="modal-content">
             <div class="modal-header" id="commonModalHeader">
               <h4 class="modal-title" id="commonModalTitle"></h4>
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
                     
                      <!--Amount-->
                      <div class="form-group row">
                         <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Amount</label>
                         <div class="col-sm-12 col-lg-9">
                            <input type="string" class="form-control form-control-sm" id="amount" name="amount" placeholder="amount" value="" required>
                         </div>
                        {!! ($errors->has('amount')) ? '<label class="error">'.$errors->first('amount').'</label>' : '' !!}
                      </div>

                      <!--Taxable-->
                     <div class="form-group row">
                        <label class="col-sm-12 col-lg-3">Taxable</label>
                        <div class="col-sm-12 col-lg-9">
                           <input style="opacity:1 !important" type="checkbox" class="form-control" id="is_taxable" name="is_taxable">
                        </div>
                     </div>

                      <!--Description-->
                      <div class="form-group row">
                         <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Description</label>
                         <div class="col-sm-12 col-lg-9">
                           <input name="description" class="form-control form-control-sm" id="description" cols="30" rows="5" placeholder="Description" maxlength="40">
                        </div>
                        {!! ($errors->has('description')) ? '<label class="error">'.$errors->first('description').'</label>' : '' !!}
                      </div>

                      <!--Boards-->
                     <div class="form-group row">
                        <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Category*</label>
                        <div class="col-sm-12 col-lg-9">
                           <select class="form-control form-control-sm" id="ledger_category_id" name="ledger_category_id" tabindex="-1" aria-hidden="true" required>
                           @forelse ($categories as $category)
                           <option value="{{ $category->id }}">{{ $category->name }}</option>
                           @empty
                              
                           @endforelse
                           </select>
                        </div>
                     </div>

                        <!--Due Date-->
                        <div class="form-group row">
                           <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Date</label>
                           <div class="col-sm-12 col-lg-9">
                              <input type="date" class="form-control form-control-sm" autocomplete="off" name="date" value="" id="date-add">
                           </div>
                           {!! ($errors->has('date')) ? '<label class="error">'.$errors->first('date').'</label>' : '' !!}
                           </div>
                        <div class="line"></div>
                      </div>
                      <!--lead details-->
                   </div>
                </div>
             <div class="modal-footer" id="commonModalFooter" style="">
               <a class="btn btn-default pull-right add-delete-ledger" style="display: none;" data-id=""><i class="fa fa-trash"></i> Delete</a>
               <button type="button" id="commonModalCloseButton" class="btn btn-rounded-x btn-secondary waves-effect text-left" data-dismiss="modal">Close</button>
               <button type="submit" id="commonModalSubmitButton" class="btn btn-rounded-x btn-danger waves-effect text-left" data-url="https://demo.growcrm.io/leads?leadresource_id=&amp;leadresource_type=" data-loading-target="commonModalBody" data-ajax-type="POST" data-on-start-submit-button="disable">Submit</button>
             </div>
          </div>
       </form>
    </div>
 </div>