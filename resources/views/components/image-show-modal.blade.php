<!-- edit modal --->
<div class="modal hidden h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50"
    wire:ignore
    style="z-index: 9999999"
    x-cloak
    :class="{hidden : showImageModal === false}"
    x-data="component()"
    x-on:show-image-modal.window="listenEvent(event)">
    <!-- modal -->
    <div class="bg-white rounded shadow-lg w-10/12 md:w-1/3  border-2 border-blue"
      @click.away="showImageModal = false"
      x-show.transition.duration.700ms="showImageModal">
      <!-- modal header -->
        <div class="border-b px-4 py-2 flex justify-between items-center">
            <h3 class="font-semibold text-base">Image Preview</h3>
            <button class="text-black close-modal"
            @click="showImageModal = false">&cross;</button>
        </div>
      <!-- modal body -->
        <div class="">
            <div class="bg-white md:sticky md:top-8">
                <img :src="imagePreview" alt="" class="object-none h-full w-full">
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        function component() {
            return {
                showImageModal: false,
                imagePreview : '',
                listenEvent(event) {
                    this.imagePreview = event.detail.image;
                    this.showImageModal = true;
                }
            }
        }
    </script>
@endpush