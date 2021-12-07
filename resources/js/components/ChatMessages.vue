<template>
  <div class="" >
    <div v-for="(message, index) in messages" :key="index">
      <div class="flex flex-col sm:flex-row border-b border-gray-200 dark:border-dark-5 px-5 py-4">
          <!-- {{-- PROFILE TOP --}} -->
          <div class="flex items-center">
              <div class="ml-3 mr-auto">
                  <div class="font-medium text-base">{{message.user.name}}</div>
              </div>
          </div>
          <!-- {{-- END --}} -->
      </div>
      <div class="overflow-y-scroll scrollbar-hidden px-5 pt-5 flex-1">
          <!-- {{-- FRIEND POSITION --}} -->
          <div class="chat__box__text-box flex items-end float-left mb-4">
              <div class="bg-gray-200 dark:bg-dark-5 px-4 py-3 text-gray-700 dark:text-gray-300 rounded-r-md rounded-t-md">
                  {{message.message}}
                  <!-- <div class="mt-1 text-xs text-gray-600">2 mins ago</div> -->
              </div>
          </div>
          <!-- {{-- END --}} -->
          <div class="clear-both"></div>
          <!-- {{-- USER POSITION --}} -->
          <div class="chat__box__text-box flex items-end float-right mb-4">
              <div class="bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md">
                  {{message.message}}
                  <!-- <div class="mt-1 text-xs text-theme-21">1 mins ago</div> -->
              </div>
          </div>
          <!-- {{-- END --}} -->
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['messages']
  };
</script>
