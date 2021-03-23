<form wire:submit.prevent="createIdea" action="#" method="POST" class="space-y-4 px-4 py-6"
enctype="multipart/form-data">
    <x-alerts></x-alerts>
    <div>
        <input wire:model.defer="title" type="text" class="w-full text-sm bg-gray-100 border-none rounded-xl placeholder-gray-900 px-4 py-2" placeholder="Your Idea" required>
        @error('title')
            <p class="text-red text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <select wire:model.defer="category" name="category_add" id="category_add" class="w-full bg-gray-100 text-sm rounded-xl border-none px-4 py-2">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    @error('category')
        <p class="text-red text-xs mt-1">{{ $message }}</p>
    @enderror
    <div>
        <textarea wire:model.defer="description" name="idea" id="idea" cols="30" rows="4" class="w-full bg-gray-100 rounded-xl border-none placeholder-gray-900 text-sm px-4 py-2" placeholder="Describe your idea" required></textarea>
        @error('description')
            <p class="text-red text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div x-data="{ isUploading: false, progress: 0, submitBtn : false}"
    x-on:livewire-upload-start="isUploading = true;submitBtn = true"
    x-on:livewire-upload-finish="isUploading = false;submitBtn = false"
    x-on:livewire-upload-error="isUploading = false;submitBtn = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress">

        <input type="file" wire:model.defer="file" name="file" 
            class="w-full bg-gray-100 rounded-xl border-none placeholder-gray-900 text-sm px-4 py-2">
        @error('file')
            <p class="text-red text-xs mt-1">{{ $message }}</p>
        @enderror

        <!-- Progress Bar -->
        <div x-show="isUploading" x-cloak>
            <progress max="100" x-bind:value="progress"></progress>
        </div>

        <div class="flex items-center justify-between space-x-3 mt-3">
            <button
                :disabled="submitBtn"
                type="submit"
                class="flex items-center justify-center w-full h-11 text-xs 
                bg-blue text-white font-semibold rounded-xl border border-blue 
                hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                <span class="ml-1">Submit</span>
            </button>
        </div>

    </div>
</form>
