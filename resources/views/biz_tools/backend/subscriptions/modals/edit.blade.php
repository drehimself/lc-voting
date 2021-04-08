<!-- subscription edit modal --->
<div class="modal" id="subscriptionEditModal">
    <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Edit subscription</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form action="#" method="post" id="subscriptionEditForm">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="name" class="form-control" id="edit-subscription-name" placeholder="Enter Name" name="name" required value="">
                </div>
                <div class="form-group">
                    <label for="website_link">Website link <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="edit-subscription-website" placeholder="Enter Website Link" name="website_link" required value="">
                </div>
                <div class="form-group">
                    <label for="cost">Monthly Cost <span class="text-danger">*</span></label>
                    <input type="text" pattern="^[1-9]\d*(\.\d+)?$" class="form-control" id="edit-subscription-cost" placeholder="Enter Montlhy Cost" name="monthly_cost" required value="">
                </div>
            </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary" form="subscriptionEditForm">Submit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

    </div>
    </div>
</div>