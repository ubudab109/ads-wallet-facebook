@extends('layout.side-menu')
@section('style')
    <style>
      .d-none {
        visibility: hidden;
      }
    </style>
@endsection
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Topup Setting</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Button Groups -->
            <div class="intro-y box">
              <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                  <h2 class="font-medium text-base mr-auto">Topup Setting Form</h2>
              </div>
            </div>
            <!-- END: Input Groups -->
        </div>
        <div class="intro-y col-span-12 lg:col-span-12">
          <!-- BEGIN: Input Groups -->
          <div class="intro-y box mt-5">
              <form action="{{route('saveTopupSetting')}}" method="POST">
                @csrf
                <div id="input-groups" class="p-5">
                    <div class="preview">
                        <div class="mt-5 mb-5">
                          <label for="">Minimum Topup (Dalam Rupiah)</label>
                            <div class="input-group mt-2">
                              <div id="input-group-price" class="input-group-text">Rp. </div>
                              <input type="text" class="form-control" value="{{$topup_minimum}}" name="topup_minimum" required placeholder="Minimum Topup Dalam Rupiah" aria-label="Price" aria-describedby="input-group-price">
                            </div>
                        </div>
                        <div class="mt-5 mb-5">
                          <label for="">Topup Fee</label>
                            <div class="input-group mt-2"> 
                              <input type="text" class="form-control" value="{{$topup_fee_percent}}" name="topup_fee_percent" required placeholder="Fee Topup Dalam Persentase" aria-label="Price" aria-describedby="input-group-price">
                              <div id="input-group-price" class="input-group-text">%</div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-24 mr-1 mb-2">Submit</button>
                    </div>
                </div>
              </form>
          </div>
          <!-- END: Input Groups -->
        </div>
    </div>    
@endsection