<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $dark_mode ? 'dark' : '' }}">
<!-- BEGIN: Head -->
<head>
    <meta charset="utf-8">
    <link href="{{ asset('company-logo/'.allsetting()['logo']) }}" rel="shortcut icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Midone admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">
    @auth
        <meta name="user_id" content="{{ auth()->user()->id }}">
    @endauth
    <title>{{allsetting()['company_name']}}</title>

    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}" />
    <style>
        .notif-scroll {
            overflow-y: scroll;
            height: 500px;
        }
        .chat-active {
            background: #1c3faa !important;
        }
        .chat-active-dark {
            background: #1c3faa;
        }
        #overlay{
            position:fixed;
            z-index:99999;
            top:0;
            left:0;
            bottom:0;
            right:0;
            background:rgba(0,0,0,0.9);
            transition: 1s 0.4s;
            }
            #progress{
            height:1px;
            background:#fff;
            position:absolute;
            width:0;
            top:50%;
            }
            #progstat{
            font-size:0.7em;
            letter-spacing: 3px;
            position:absolute;
            top:50%;
            margin-top:-40px;
            width:100%;
            text-align:center;
            color:#fff;
            }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script> --}}
    {{-- <link rel="stylesheet" href="{{asset('css/tabulator.min.css')}}" /> --}}
    @yield('style')
    <!-- END: CSS Assets-->

</head>
<!-- END: Head -->

@yield('body')

<script>
    function countNotif() {
        $.ajax({
            type: 'GET',
            url: "{{route('countNotification')}}",
            success: function(res) {
                var notif_count = $("#count-notif").attr('data-count', res.data);
                $("#count-notif").text(res.data);
                
            }
        })
    }

    function countChat() {
        $.ajax({
            type: 'GET',
            url: "{{route('countNotReadChat')}}",
            success: function(res) {
                var chat_count = $("span#chat-count").attr('data-count', res.data);
                var chat_count_wrapper = $("span#chat-count-wrapper").attr('data-count', res.data);
                
                $("span#chat-count").text(res.data);
                $("span#chat-count-wrapper").text(res.data);
                
            }
        })
    }
    $("#read-all").on('click', (e) => {
        e.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "{{route('readAllNotif')}}",
            success: function(res) {
                countNotif();
                $("#notif-here").html('');
            }
        })
    })
    
    $(document).ready(function() {
        countChat();
        countNotif();
        Echo.channel('usernotification_' + '{{Auth::id()}}')
        .listen('.receive_notification', (data) => {
            var notificationWrapper     = $("#dropdown-notifications");
            var notificcationCountElm   = $("#count-notif");
            var notificationsCount      = parseInt(notificcationCountElm.data('count'));
            
            var notifications           = notificationWrapper.find('div#notif-here');
            var existingNotifications   = notifications.html();
            var newNotificationHtml = `
                <div class="cursor-pointer relative flex items-center mt-5">
                    <div class="ml-2 overflow-hidden">
                        <div class="flex items-center">
                            <a href="javascript:;" class="font-medium truncate mr-5">${data.title}</a>
                        </div>
                        <div class="text-xs text-gray-500 ml-auto">${data.messages}</div>
                    </div>
                </div>
            `;
            notifications.html(newNotificationHtml + existingNotifications);
            
            countNotif();
            
        });

        Echo.private('user-message.' + '{{Auth::id()}}')
          .listen('MessageSent', (e) => {
            var chatCountElm   = $("#chat-count");
            var chatCount      = parseInt(chatCountElm.data('count'));

            var chatCountWrapper = $("#chat-count-wrapper");
            var chatCountWrapperData= parseInt(chatCountWrapper.data('count'));

            countChat();
          })
    })

</script>

</html>