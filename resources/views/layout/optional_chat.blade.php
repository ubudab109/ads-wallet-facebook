<div class="flex absolute sm:static left-0 bottom-0 ml-5 sm:ml-0 mb-5 sm:mb-0">
  {{-- @include('layout.emoji') --}}
  <div class="w-4 h-4 sm:w-5 sm:h-5 relative text-gray-600 mr-3 sm:mr-5">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-paperclip w-full h-full"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg> 
      <input @change="fileChange" accept="image/*" name="image" type="file" class="w-full h-full top-0 left-0 absolute opacity-0">
  </div>
</div>
