<!-- The Modal -->
<div class="modal" id="addNewBoardModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Add New Board</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form action="{{ route('boards.store') }}" id="addNewBoard" method="POST">
                @csrf
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" name="title" class="form-control" placeholder="Enter Title" id="title" required>
                </div>
                <div class="form-group">
                  <label for="select">Color Class</label>
                  <select name="class" id="" class="form-control">
                      @forelse ($classes as $class)
                        <option value="{{ $class }}">{{ $class }}</option>
                      @empty
                          
                      @endforelse
                  </select>
                </div>
            </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" form="addNewBoard">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>