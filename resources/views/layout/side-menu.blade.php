@extends('layout.main')

@section('head')
    @yield('subhead')
@endsection

@section('content')

    @include('layout.components.mobile-menu')
    <div class="flex">
        <!-- BEGIN: Side Menu -->
        <nav class="side-nav">
            <a href="" class="intro-x flex items-center pl-5 pt-4">
                <img alt="Midone Tailwind HTML Admin Template" class="w-12" src="{{ asset('company-logo/'.allsetting()['logo']) }}">
                <span class="hidden xl:block text-white text-lg ml-3">
                    {{allsetting()['company_name']}}
                    {{-- <span class="font-medium"></span> --}}
                </span>
            </a>
            <div class="side-nav__devider my-6"></div>
            <ul>
                @foreach ($side_menu as $menuKey => $menu)
                    @if ($menu == 'devider')
                        <li class="side-nav__devider my-6"></li>
                    @else
                        @role($menu['role'])
                        <li>
                            <a href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;' }}" class="{{ $first_level_active_index == $menuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="{{ $menu['icon'] }}"></i>
                                </div>
                                <div class="side-menu__title">
                                    {{ $menu['title'] }} 
                                    @if ($menuKey == 'support')
                                        <div id="support_wrapper" class="ml-2 w-5 h-5 right-0 text-xs text-white rounded-full bg-theme-6 font-medium p-1">
                                            <span id="chat-count-wrapper" data-count="{{App\Models\Chat::where('to_user_id', Auth::id())->where('read_at', null)->count()}}"></span>
                                        </div>
                                    @endif
                                    @if (isset($menu['sub_menu']))
                                        <div class="side-menu__sub-icon">
                                            <i data-feather="chevron-down"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            @if (isset($menu['sub_menu']))
                                <ul class="{{ $first_level_active_index == $menuKey ? 'side-menu__sub-open' : '' }}">
                                    @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu) 
                                        @role($subMenu['role'])
                                            <li>
                                                <a href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;' }}" class="{{ $second_level_active_index == $subMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                                    <div class="side-menu__icon">
                                                        <i data-feather="activity"></i>
                                                    </div>
                                                    <div class="side-menu__title">
                                                        {{ $subMenu['title'] }}
                                                        @if ($subMenuKey == 'chat')
                                                            <div id="chat_wrapper" class="ml-2 w-5 h-5 right-0 text-xs text-white rounded-full bg-theme-6 font-medium p-1">
                                                                <span id="chat-count" data-count="{{App\Models\Chat::where('to_user_id', Auth::id())->where('read_at', null)->count()}}"></span>
                                                            </div>
                                                        @endif
                                                        @if (isset($subMenu['sub_menu']))
                                                            <div class="side-menu__sub-icon">
                                                                <i data-feather="chevron-down"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </a>
                                                @if (isset($subMenu['sub_menu']))
                                                    <ul class="{{ $second_level_active_index == $subMenuKey ? 'side-menu__sub-open' : '' }}">
                                                        @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                                                            <li>
                                                                <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}" class="{{ $third_level_active_index == $lastSubMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                                                    <div class="side-menu__icon">
                                                                        <i data-feather="zap"></i>
                                                                    </div>
                                                                    <div class="side-menu__title">{{ $lastSubMenu['title'] }}</div>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endrole
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                        @endrole
                    @endif
                @endforeach
            </ul>
        </nav>
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            <div id="overlay">
                <div id="progstat"></div>
                <div id="progress"></div>
              </div>
            @include('layout.components.top-bar')
            @yield('subcontent')
        </div>
        <!-- END: Content -->
    </div>
@endsection