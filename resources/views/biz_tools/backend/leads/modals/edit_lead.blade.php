<!-- modal --->
<div class="modal card-modal" role="dialog" aria-labelledby="cardModal" id="cardModal" aria-modal="true">
	<div class="modal-dialog" id="cardModalContainer">
      {{-- edit mode --}}
      <div class="modal-content" id="leadEditInsideDetails">
         <div class="modal-body row min-h-200" id="commonModalBody">
            <div class="col-md-6 mt-2">
               <h3 style="color:#20aee3;">Update Lead</h3>
            </div>
            <div class="col-md-6 mt-2">
               <button class="btn btn-default pull-right detail-edit-convert-to-customer" data-id="" onclick="var r = confirm('Are you sure?'); if(r == true) window.location.href = 'convert/lead/customer/' + event.target.getAttribute('data-id')"><i class="fa fa-anchor"></i> Convert to customer</button>
            </div>
               <div class="col-md-12" style="padding:20px;">
                  <form action="{{ route('leads.store') }}" method="post" id="commonModalForm" class="form-horizontal">
                  @csrf    
                  <input type="hidden" value="" name="action" id="detail-edit-actionInPopUp">
                  <input type="hidden" value="" name="leadID" id="detail-edit-leadIdInPopUp">
                  <!--title-->
                  <div class="form-group row">
                     <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Lead Title*</label>
                     <div class="col-sm-12 col-lg-9">
                        <input type="text" class="form-control form-control-sm" id="detail-edit-lead_title" name="lead_title" placeholder="" value="" required>
                     </div>
                  </div>
                  <!--first name-->
                  <div class="form-group row">
                     <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">First Name*</label>
                     <div class="col-sm-12 col-lg-9">
                        <input type="text" class="form-control form-control-sm" id="detail-edit-lead_firstname" name="lead_firstname" placeholder="" value="" required>
                     </div>
                  </div>
                  <!--last name-->
                  <div class="form-group row">
                     <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Last Name*</label>
                     <div class="col-sm-12 col-lg-9">
                        <input type="text" class="form-control form-control-sm" id="detail-edit-lead_lastname" name="lead_lastname" placeholder="" value="" required>
                     </div>
                  </div>
                  <!--telephone-->
                  <div class="form-group row">
                     <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Telephone</label>
                     <div class="col-sm-12 col-lg-9">
                        <input type="text" class="form-control form-control-sm" id="detail-edit-lead_phone" name="lead_phone" placeholder="" value="">
                     </div>
                  </div>
                  <!--email-->
                  <div class="form-group row">
                     <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Email Address</label>
                     <div class="col-sm-12 col-lg-9">
                        <input type="text" class="form-control form-control-sm" id="detail-edit-lead_email" name="lead_email" placeholder="" value="">
                     </div>
                  </div>
                  
                  <!--status-->
                  <div class="form-group row">
                     <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Status*</label>
                     <div class="col-sm-12 col-lg-9">
                        <select class="form-control form-control-sm" id="detail-edit-lead_status_add" name="lead_status" tabindex="-1" aria-hidden="true" required>
                           @forelse ($boards as $board)
                               <option value="{{ $board->id }}">{{ $board->title }}</option>
                           @empty
                               
                           @endforelse
                        </select>
                     </div>
                  </div>
                  <!--lead details - toggle-->
                  <!--lead details-->
                  <div class="" id="add_lead_details" x-show="showDetails">
                     <!--description-->
                     <div class="form-group row">
                        <label class="col-sm-12 text-left control-label col-form-label">Notes</label>
                        <div class="col-sm-12">
                           <textarea class="form-control form-control-sm details-edit-tinymce-textarea" rows="5" name="lead_description" id="detail-edit-lead_description" aria-hidden="true"></textarea>
                        </div>
                     </div>
                     <!--lead sources-->
                     <div class="form-group row">
                        <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Source</label>
                        <!--existing-->
                        <div class="col-sm-12 col-lg-9">
                           <select class="form-control form-control-sm " id="detail-edit-lead_source" name="lead_source" tabindex="-1" aria-hidden="true">
                              <option value="yellow_pages">Yellow &amp; Pages</option>
                              <option value="yahoo">Yahoo</option>
                              <option value="google_places">Google Places</option>
                              <option value="facebook_ads">Facebook Ads</option>
                           </select>
                        </div>
                        <!--/#existing-->
                     </div>
                     <!--lead category-->
                     <div class="form-group row">
                        <label class="col-sm-12 col-lg-3 text-left control-label col-form-label  required">Category*</label>
                        <div class="col-sm-12 col-lg-9">
                           <select class="form-control form-control-sm " id="detail-edit-lead_categoryid" name="lead_categoryid" tabindex="-1" aria-hidden="true" required>
                              <option value="default">Default</option>
                              <option value="application_development">Application Development</option>
                              <option value="graphic_design">Graphic Design</option>
                           </select>
                        </div>
                     </div>
                     
                     <!--contacted-->
                     <div class="form-group row">
                        <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Last Contacted</label>
                        <div class="col-sm-12 col-lg-9">
                           <input type="date" class="form-control form-control-sm" autocomplete="off" name="lead_last_contacted" value="" id="detail-edit-lead_last_contacted">
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button class="btn btn-default pull-right detail-edit-delete-lead" data-id="" onclick="event.preventDefault(); r = confirm('Are you sure?'); if(r == true) window.location.href = 'lead/'+ event.target.getAttribute('data-id') +'/delete'"><i class="fa fa-trash"></i> Delete</button>
                        <button type="submit" class="btn btn-danger updateBtnInEditModal">Update</button>
                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                     </div>
                  </div>
                  </form>
                  <!--lead details-->
               </div>
         </div>
      </div>

      <!-- end of modal content -->
	</div>
</div>
<!-- end of modal --->