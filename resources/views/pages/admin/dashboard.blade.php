@extends('layout.side-menu')

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">General Report</h2>
                        <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10">
                            <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                        </a>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="dollar-sign" class="report-box__icon text-theme-10"></i>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$userSaldo}}$</div>
                                    <div class="text-base text-gray-600 mt-1">Jumlah Saldo Seluruh User Saat Ini</div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                          <div class="report-box zoom-in">
                              <div class="box p-5">
                                  <div class="flex">
                                      <i data-feather="dollar-sign" class="report-box__icon text-theme-10"></i>
                                  </div>
                                  <div class="text-3xl font-bold leading-8 mt-6">{{$topupPending}}</div>
                                  <div class="text-base text-gray-600 mt-1">Jumlah Topup Pending</div>
                              </div>
                          </div>
                        </div> --}}
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="{{IconUserStatus(Auth::user()->status)}}" class="report-box__icon {{FontThemeUserStatus(Auth::user()->status)}}"></i>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$totalAkunAd}}</div>
                                    <div class="text-base text-gray-600 mt-1">Total Akun Ad Waiting List</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="file-text" class="report-box__icon text-theme-12"></i>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$formPending}}</div>
                                    <div class="text-base text-gray-600 mt-1">Total Form Need Review</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: General Report -->
            </div>
        </div>
    </div>
@endsection