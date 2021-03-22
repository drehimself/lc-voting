<!-- edit modal --->
<div class="modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50"
style="z-index: 9999999"
x-cloak
:class="{hidden : modalShow === false}"
x-data="{modalShow : false,comment_id : null,comment_body : null}"
x-on:show-modal.window="
    comment_body = $event.detail.body;
    comment_id = $event.detail.id;
    modalShow = true
">
    <!-- modal -->
    <div class="bg-white rounded shadow-lg w-10/12 md:w-1/3">
      <!-- modal header -->
        <div class="border-b px-4 py-2 flex justify-between items-center">
            <h3 class="font-semibold text-lg">Edit Comment</h3>
            <button class="text-black close-modal"
            @click="modalShow = false">&cross;</button>
        </div>
      <!-- modal body -->
      <form action="#" wire:submit.prevent="updateComment(Object.fromEntries(new FormData($event.target)))">
          <input type="hidden" :value="comment_id" name="comment_id">
            <div class="p-3">
                <textarea type="text" name="body" :value="comment_body" wire:modal="comment" rows="5"
                class="w-full text-sm bg-gray-100 rounded-xl placeholder-gray-900 border-none px-4 py-2"></textarea>
            </div>
            <div class="flex justify-end items-center w-100 border-t p-3">
                <a href="javascript:;" class="bg-red hover:bg-red px-3 py-1 rounded text-white mr-1 close-modal"
                @click="modalShow = false">Cancel</a>
                <button class="bg-blue hover:bg-blue px-3 py-1 rounded text-white" type="submit" @click='modalShow = false'">Update</button>
            </div>
        </form>
    </div>
</div>