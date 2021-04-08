<!-- The Modal -->
<div class="modal" id="addNewLedgerCategoryModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Add New Category</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form action="{{ route('ledger.category') }}" id="addNewTaskBoard" method="POST">
                @csrf
                <div class="form-group">
                  <label for="title">Name</label>
                  <input type="text" name="name" class="form-control" placeholder="Enter Title" id="title" required>
                </div>
            </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" form="addNewTaskBoard">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>