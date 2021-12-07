@extends('layout.side-menu')

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Chat</h2>
    </div>
    <div class="intro-y chat grid grid-cols-12 gap-5 mt-5" id="app">
        <!-- BEGIN: Chat Side Menu -->
        <div class="col-span-12 lg:col-span-4 xxl:col-span-3">
            @role('member')

            <div class="intro-y pr-1">
                <div class="box p-2">
                    <div class="chat__tabs nav nav-tabs justify-center" role="tablist">
                        <a id="chats-tab" v-on:click="fetchAdmin()" href="javascript:;" class="flex-1 py-2 rounded-md text-center active" role="tab" aria-controls="chats" aria-selected="true">Klik Disini Untuk Chat Dengan Admin</a>
                    </div>
                    
                </div>
            </div>
            @endrole

            <div class="pr-1">
                <div class="box px-5 pt-5 pb-5 lg:pb-0 mt-5">
                    <div class="relative text-gray-700 dark:text-gray-300">
                        <div class="input-group">
                            <input ref="userSearch" data-user="{{request()->query('useremail')}}" id="search_user" v-model="search" type="text" class="form-control py-3 px-4 border-transparent bg-gray-200 pr-10 placeholder-theme-13" placeholder="Cari Nama atau Email Untuk Mulai Chat...">
                            <div id="input-group-price" class="input-group-text"><a href="javascript:;" v-on:click="clearSearch()" onclick="clearSearch()"><i data-feather="x"></i></a></div>
                        </div>
                    </div>
                    <div class="overflow-x-auto scrollbar-hidden">
                        <div class="flex mt-5">
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div id="chats" class="tab-pane active" role="tabpanel" aria-labelledby="chats-tab">
                    <div v-if="isSearching == true">Searching</div>
                    <div class="chat__chat-list overflow-y-auto scrollbar-hidden pr-1 pt-1 mt-4">
                        {{-- LOOP HERE --}}
                        <div 
                            v-for="(user, index) in users" 
                            v-bind:key="index"
                            v-if="user.id != id"
                            :class="['intro-x cursor-pointer box relative flex items-center p-5 user.id mt-5', {
                                'chat-active dark:chat-active' : isActive === index && search == '' ? true : false
                            }]"
                            v-on:click="fetchMessage(user.id)"
                            >
                            {{-- <div class="w-12 h-12 flex-none image-fit mr-1">
                            </div> --}}
                            <div class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a 
                                    v-on:click="fetchMessage(user.id)" href="javascript:;"
                                     v-if="user.id != id"
                                    :class="['font-medium dark:text-white', {
                                        'text-white' : isActive === index && search == '' ? true : false
                                    }]"
                                     
                                     >@{{ user.name }}
                                    </a>
                                    {{-- <div class="text-xs text-gray-500 ml-auto">{{ $chat->FirstChat->chat_time }}</div> --}}
                                </div>
                                <div v-if="user.messages" class="w-full truncate text-gray-600 mt-0.5">
                                    @{{
                                        (id != user.to_user_id ? 'Anda: ' : '')
                                        + (user.messages.length > 20 
                                        ? user.messages.substr(0, 20) + '...' 
                                        : user.messages)
                                    }}
                                </div>
                            </div>
                            <div v-if="user.count" class="w-5 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-theme-1 font-medium -mt-1 -mr-1">@{{ user.count }}</div>
                        </div>
                        {{-- END --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Chat Side Menu -->
        <!-- BEGIN: Chat Content -->
        <div class="intro-y col-span-12 lg:col-span-8 xxl:col-span-9">
            <div class="chat__box box" >
                <!-- BEGIN: Chat Active -->
                <div class="h-full flex flex-col" v-if="isActive != null">
                    <div class="flex flex-col sm:flex-row border-b border-gray-200 dark:border-dark-5 px-5 py-4">
                        <div class="flex items-center">
                            <div class="ml-3 mr-auto">
                                <div class="font-medium text-base">@{{ user_from.name }}</div>
                                {{-- <div class="text-gray-600 text-xs sm:text-sm">Hey, I am using chat <span class="mx-1">•</span> Online</div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="overflow-y-scroll scrollbar-hidden px-5 pt-5 flex-1 chat-area" id="card-message-scroll">
                        <template v-for="(message, index) in messages">
                            <div class="clear-both"></div>
                            <!-- {{-- FRIEND POSITION --}} -->
                            <div v-if="message.to_user_id == {{auth()->user()->id}} && message.current_user != {{auth()->user()->id}}" class="chat__box__text-box flex items-end float-left mb-4">
                                <div class="bg-gray-200 dark:bg-dark-5 px-4 py-3 text-gray-700 dark:text-gray-300 rounded-r-md rounded-t-md">
                                    <div class="preview" v-if="message.image != null">
                                        <img :src="message.image" width="200" height="150">
                                    </div>
                                    @{{ message.messages }}
                                    <div class="mt-1 text-xs text-gray-600">@{{ new Date(message.created_at).toLocaleDateString()}}</div>
                                </div>
                            </div>
                            <!-- {{-- END --}} -->
                            <!-- {{-- USER POSITION --}} -->
                            <div v-else class="chat__box__text-box flex items-end float-right mb-4">
                                <div class="bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md">
                                    <div class="preview" v-if="message.image != null">
                                        <img :src="message.image" width="200" height="150">
                                    </div>
                                    @{{ message.messages }}
                                    <div class="mt-1 text-xs text-theme-21">@{{ new Date(message.created_at).toLocaleDateString()}}</div>
                                </div>
                                
                            </div>
                            {{-- <div class="clear-both"></div> --}}


                        <!-- {{-- END --}} -->
                        </template>
                    
                    </div>
                    <div v-if="isActive != null">
                        <form @submit.prevent="sendMessage" enctype="multipart/form-data" class="pt-4 pb-10 sm:py-4 flex items-center border-t border-gray-200 dark:border-dark-5">
                            <div class="preview" class="flex justify-content-center" v-if="previewImage != null">
                                <img :src="previewImage" width="200" height="150">
                                <button v-on:click="removeImage()" class="btn btn-danger">Hapus X</button>
                            </div>
                            <textarea @keypress="press($event)" name="messages" id="text_message" v-model="form.messages" class="chat__box__input form-control dark:bg-dark-3 h-16 resize-none border-transparent px-5 py-3 shadow-none focus:ring-0" rows="1" placeholder="Masukan Pesan Anda Disini. Tekan ENTER Untuk Mengirim atau Tekan SHIFT+ENTER Untuk Menambah Baris Baru"></textarea>
                            @include('layout.optional_chat')
                            <button type="submit" id="btn-chat" class="w-8 h-8 sm:w-10 sm:h-10 block bg-theme-1 text-white rounded-full flex-none flex items-center justify-center mr-5">  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send w-4 h-4"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>  </button>
                        </form>
                    </div>
                </div>
                <!-- END: Chat Active -->
                <!-- BEGIN: Chat Default -->
                <!-- END: Chat Default -->
            </div>
        </div>
        <!-- END: Chat Content -->
    </div>
@endsection

@section('script')
    <script>
        function clearSearch(button) {
            $("#search_user").removeAttr('data-user');
            // message = message + text;
        }
    </script>
@endsection