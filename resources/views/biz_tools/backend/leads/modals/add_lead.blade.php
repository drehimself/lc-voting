<div class="modal modal-static" aria-labelledby="foo" id="addLeadModal" data-keyboard="false" data-backdrop="static" aria-modal="true" role="dialog" x-data="{showDetails : false}">
    <div class="modal-dialog modal-lg" id="commonModalContainer">
       <form action="{{ route('leads.store') }}" method="post" id="commonModalForm" class="form-horizontal">
        @csrf    
        <input type="hidden" value="" name="action" id="actionInPopUp">
        <input type="hidden" value="" name="leadID" id="leadIdInPopUp">
        <div class="modal-content">
             <div class="modal-header" id="commonModalHeader">
               <h4 class="modal-title" id="commonModalTitle">Add Lead</h4>
               <div class="col-md-6 mt-2">
                  <button class="btn btn-default pull-right add-lead-convert-to-customer" style="display:none;" data-id="" onclick="var r = confirm('Are you sure?'); if(r == true) window.location.href = 'convert/lead/customer/' + event.target.getAttribute('data-id')"><i class="fa fa-anchor"></i> Convert to customer</button>
               </div>
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
                         <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Lead Title*</label>
                         <div class="col-sm-12 col-lg-9">
                            <input type="text" class="form-control form-control-sm" id="lead_title" name="lead_title" placeholder="" value="" required>
                         </div>
                      </div>
                      <!--first name-->
                      <div class="form-group row">
                         <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">First Name*</label>
                         <div class="col-sm-12 col-lg-9">
                            <input type="text" class="form-control form-control-sm" id="lead_firstname" name="lead_firstname" placeholder="" value="" required>
                         </div>
                      </div>
                      <!--last name-->
                      <div class="form-group row">
                         <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Last Name*</label>
                         <div class="col-sm-12 col-lg-9">
                            <input type="text" class="form-control form-control-sm" id="lead_lastname" name="lead_lastname" placeholder="" value="" required>
                         </div>
                      </div>
                      <!--telephone-->
                      <div class="form-group row">
                         <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Telephone</label>
                         <div class="col-sm-12 col-lg-9">
                            <input type="text" class="form-control form-control-sm" id="lead_phone" name="lead_phone" placeholder="" value="">
                         </div>
                      </div>
                      <!--email-->
                      <div class="form-group row">
                         <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Email Address</label>
                         <div class="col-sm-12 col-lg-9">
                            <input type="text" class="form-control form-control-sm" id="lead_email" name="lead_email" placeholder="" value="">
                         </div>
                      </div>
                      
                      <!--status-->
                      <div class="form-group row">
                         <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Status*</label>
                         <div class="col-sm-12 col-lg-9">
                            <select class="form-control form-control-sm" id="lead_status_add" name="lead_status" tabindex="-1" aria-hidden="true" required>
                               @forelse ($boards as $board)
                                   <option value="{{ $board->id }}">{{ $board->title }}</option>
                               @empty
                                   
                               @endforelse
                            </select>
                         </div>
                      </div>
                      <!--lead details - toggle-->
                      <div class="spacer row">
                         <div class="col-sm-12 col-lg-8">
                            <span class="title">Details</span>
                         </div>
                         <div class="col-sm-12 col-lg-4">
                            <div class="switch  text-right">
                               <label>
                               <input type="checkbox" name="show_more_settings_leads1" id="show_more_settings_leads1" class="js-switch-toggle-hidden-content" x-on:click="showDetails = !showDetails">
                               <span class="lever switch-col-light-blue"></span>
                               </label>
                            </div>
                         </div>
                      </div>
                      <!--lead details - toggle-->
                      <!--lead details-->
                      <div class="" id="add_lead_details" x-show="showDetails">
                         <!--description-->
                         <div class="form-group row">
                            <label class="col-sm-12 text-left control-label col-form-label">Notes</label>
                            <div class="col-sm-12">
                               <textarea class="form-control form-control-sm tinymce-textarea" rows="5" name="lead_description" id="lead_description" aria-hidden="true"></textarea>
                            </div>
                         </div>
                         <!--lead sources-->
                         <div class="form-group row">
                            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Source</label>
                            <!--existing-->
                            <div class="col-sm-12 col-lg-9">
                               <select class="form-control form-control-sm " id="lead_source" name="lead_source" tabindex="-1" aria-hidden="true">
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
                               <select class="form-control form-control-sm " id="lead_categoryid" name="lead_categoryid" tabindex="-1" aria-hidden="true" required>
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
                               <input type="date" class="form-control form-control-sm" autocomplete="off" name="lead_last_contacted" value="" id="lead_last_contacted">
                            </div>
                         </div>
                         <div class="line"></div>
                      </div>
                      <!--lead details-->
                   </div>
                </div>
             </div>
             <div class="modal-footer" id="commonModalFooter" style="">
               <button class="btn btn-default pull-right add-delete-lead" style="display: none;" data-id="" onclick="event.preventDefault(); r = confirm('Are you sure?'); if(r == true) window.location.href = 'lead/'+ event.target.getAttribute('data-id') +'/delete'"><i class="fa fa-trash"></i> Delete</button>
               <button type="button" id="commonModalCloseButton" class="btn btn-rounded-x btn-secondary waves-effect text-left" data-dismiss="modal">Close</button>
               <button type="submit" id="commonModalSubmitButton" class="btn btn-rounded-x btn-danger waves-effect text-left" data-url="https://demo.growcrm.io/leads?leadresource_id=&amp;leadresource_type=" data-loading-target="commonModalBody" data-ajax-type="POST" data-on-start-submit-button="disable">Submit</button>
             </div>
          </div>
       </form>
    </div>
 </div>