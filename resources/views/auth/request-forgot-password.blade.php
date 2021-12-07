@extends('layout.login')

@section('content')
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
          <!-- BEGIN: Login Info -->
          @include('auth.left-side')
          <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Lupa Password</h2>
                    <div class="intro-x mt-8">
                        <form id="login-form" action="{{route('sendForgotPassword.process')}}" method="POST">
                            @csrf
                            <input id="email" type="email" name="email" class="intro-x login__input form-control py-3 px-4 border-gray-300 block" placeholder="Email Anda" >
                            <div id="error-email" class="login__input-error w-5/6 text-theme-6 mt-2"></div>
                            <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                              <a href="{{route('login.view')}}">Login</a>
                            </div>
                            @if (env('APP_ENV') != 'local')    
                                <div id="captcha"></div>
                                {!!  GoogleReCaptchaV2::render('captcha') !!}
                            @endif
                            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                <button id="btn-login" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>    
@endsection