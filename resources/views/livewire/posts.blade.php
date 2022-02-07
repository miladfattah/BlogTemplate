<div class="container mx-auto mt-2">
    <x-jet-banner />
     <div class="flex content-center m-2 p-2">
         <x-jet-button wire:click="showCreatePostModal" class="bg-green-500  hover:bg-green-600">ایجاد مقاله</x-jet-button>
     </div>
<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
   <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
     <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
       <table class="min-w-full divide-y divide-gray-200">
         <thead class="bg-gray-50 dark:bg-gray-600 dark:text-gray-200">
           <tr>
             <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Id</th>
             <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">عنوان</th>
             <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">وضعیت</th>
             <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">عکس</th>
             <th scope="col" class="relative px-6 py-3">حدف/تغییر</th>
           </tr>
         </thead>
         <tbody class="bg-white divide-y divide-gray-200">
           <tr></tr>
           @foreach($posts as $post)
           <tr>
             <td class="px-6 py-4 whitespace-nowrap">{{ $post->id }}</td>
             <td class="px-6 py-4 whitespace-nowrap">{{ $post->title }}</td>
             <td class="px-6 py-4 whitespace-nowrap">
               @if($post->active )
                <span class="bg-green-700 text-white  px-2 rounded-md">&thickapprox;</span>
               @else
                <span class="bg-red-700 text-white  px-1 rounded-md">غیرفعال</span>
               @endif
             </td>
             <td class="px-6 py-4 whitespace-nowrap">
               <img class="w-8 h-8 rounded-full" src="{{ asset('storage/photos/'. $post->image ) }}" />
             </td>
             <td class="px-6 py-4 text-center text-sm">
               <x-jet-button wire:click="showEditPostModal({{ $post->id }})" class="bg-orange-400 hover:bg-orange-600">ویرایش</x-jet-button>
               <x-jet-button wire:click="deletePost({{ $post->id}})" class="bg-red-600 w-[75px] mt-2 md:w-auto md:mt-0 text-center">حذف</x-jet-button>
             </td>
           </tr>
           @endforeach
         </tbody>
       </table>
       <div class="m-2 p-2">
         {{ $posts->links() }}
       </div>
     </div>
   </div>
</div>


<x-jet-dialog-modal wire:model="showModalForm">
    <x-slot name="title">ایجاد مقاله</x-slot>
    <x-slot name="content">
        <div class="space-y-8 divide-y divide-gray-200 mt-10">
            <form enctype="multipart/form-data">
                <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                    <div class="flex-1">
                        <label for="title" class="block text-sm font-medium text-gray-700"> عنوان مقاله </label>
                        <div class="mt-1">
                            <input type="text" id="title" wire:model.lazy="title" name="title" class="block w-full  appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                         @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex-1">
                      
                        <label for="image" class="block text-sm font-medium text-gray-700"> تصویر مقاله </label>
                        <div class="mt-1">
                            <input type="file" id="image" wire:model="image" name="image" class="block w-full  appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5"  />
                        </div>
                         @error('image') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full m-2">
                    @if ($newImage)
                    نمایش تصویر:
                    <img src="{{ asset('storage/photos/'. $newImage ) }}">
                    @endif
                    @if ($image)
                    نمایش تصویر:
                    <img src="{{ $image->temporaryUrl() }}">
                    @endif
                </div>
                <div class="sm:col-span-6 pt-5">
                    <label for="body" class="block text-sm font-medium text-gray-700">عنوان</label>
                    <div class="mt-1">
                        <textarea id="body" rows="3" wire:model.lazy="body" class="shadow-sm focus:ring-indigo-500 appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                    @error('body') <span class="error">{{ $message }}</span> @enderror
                </div>
            </form>
        </div>
    </x-slot>
    <x-slot name="footer">
        @if($postId)
        <x-jet-button wire:click="updatePost">ویرایش</x-jet-button>
        @else
        <x-jet-button wire:click="storePost">ذخیره</x-jet-button>
        @endif
    </x-slot>
</x-jet-dialog-modal>

</div>