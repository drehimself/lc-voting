<!-- The Modal -->
<div class="modal" id="deleteBoardModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Alert</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <h3>Are you Sure?</h3>
            <form action="" method="POST" id="destroyBoard">
                @method('DELETE')
                @csrf
                <input type="hidden" name="deleteModalBoardID">
            </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" form="destroyBoard">Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>