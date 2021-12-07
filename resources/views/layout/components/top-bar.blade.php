<!-- BEGIN: Top Bar -->
<div class="top-bar">
  <!-- BEGIN: Breadcrumb -->
  <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
      <a href="">Application</a>
      <i data-feather="chevron-right" class="breadcrumb__icon"></i>
      <a href="" class="breadcrumb--active">Dashboard</a>
  </div>
  <!-- END: Breadcrumb -->
  <!-- BEGIN: Search -->
  <!-- END: Search -->
  <!-- BEGIN: Notifications -->
  <div class="intro-x dropdown mr-auto sm:mr-6" id="dropdown-notifications">
      <div class="dropdown-toggle notification cursor-pointer" role="button" aria-expanded="false">
          <i data-feather="bell" class="notification__icon dark:text-gray-300"></i><span id="count-notif" data-count="{{\App\Models\Notification::where('user_id',Auth::id())->count()}}"></span>
      </div>
      <div class="notification-content pt-2 dropdown-menu">
          <div class="notification-content__box dropdown-menu__content box dark:bg-dark-6">
              <div class="grid justify-items-center">
                  <div class="notification-content__title">Notifications</div>
                  <button class="btn btn-sm btn-primary w-24 mr-1 mb-2" id="read-all">Read All</button>
              </div>

              <div id="notif-here" class="notif-scroll">
                @foreach (\App\Models\Notification::where('user_id',Auth::id())->where('status',NOTIF_NOT_READ)->orderBy('created_at','desc')->get() as $item)
                <div class="cursor-pointer relative flex items-center mt-5">
                    <div class="ml-2 overflow-hidden">
                        <div class="flex items-center">
                            <a href="javascript:;" class="font-medium truncate mr-5">{{$item->title}}</a>
                        </div>
                        <div class="text-xs text-gray-500 ml-auto">{{$item->messages}}</div>
                    </div>
                </div>
                @endforeach
              </div>

          </div>
      </div>
  </div>
  <!-- END: Notifications -->
  <!-- BEGIN: Account Menu -->
  <div class="intro-x dropdown w-8 h-8">
      <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false">
          <i data-feather="user"></i>
      </div>
      <div class="dropdown-menu w-56">
          <div class="dropdown-menu__content box bg-theme-26 dark:bg-dark-6 text-white">
              <div class="p-4 border-b border-theme-27 dark:border-dark-3">
                  <div class="font-medium">{{Auth::user()->name}}</div>
                  <div class="text-xs text-theme-28 mt-0.5 dark:text-gray-600">{{Auth::user()->email}}</div>
              </div>
              <div class="p-2">
                  {{-- <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                      <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile
                  </a> --}}
                  {{-- <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                      <i data-feather="lock" class="w-4 h-4 mr-2"></i> Reset Password
                  </a> --}}
              </div>
              <div class="p-2 border-t border-theme-27 dark:border-dark-3">
                  <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                      <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout
                  </a>
                  <form id="logout-form" action="{{ route('logout.process') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
              </div>
          </div>
      </div>
  </div>
  <!-- END: Account Menu -->
</div>
<!-- END: Top Bar -->