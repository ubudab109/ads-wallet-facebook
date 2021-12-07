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
        <h2 class="text-lg font-medium mr-auto">Mail Setting</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Button Groups -->
            <div class="intro-y box">
              <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                  <h2 class="font-medium text-base mr-auto">Mail Setting Form</h2>
              </div>
            </div>
            <!-- END: Input Groups -->
        </div>
        <div class="intro-y col-span-12 lg:col-span-12">
          <!-- BEGIN: Input Groups -->
          <div class="intro-y box mt-5">
              <form action="{{route('saveEmailSetting')}}" method="POST">
                @csrf
                <div id="input-groups" class="p-5">
                    <div class="preview">
                        <div class="mt-5 mb-5">
                            <label for="">Mail Driver</label>
                            <input type="text" class="form-control" value="{{$mailDriver}}" name="mail_driver" required placeholder="Mail Driver. Ex: SMTP" aria-describedby="input-group-email">
                        </div>
                        <div class="mt-5 mb-5">
                          <label for="">Mail Host</label>
                          <input type="text" class="form-control" value="{{$mailHost}}" name="mail_host" required placeholder="Mail Host. Ex: smptp.gmail.com" aria-describedby="input-group-email">
                        </div>
                        <div class="mt-5 mb-5">
                          <label for="">Mail Port</label>
                          <input type="text" class="form-control" value="{{$mailPort}}" name="mail_port" required placeholder="Mail Port. Ex: 443" aria-describedby="input-group-email">
                        </div>
                        <div class="mt-5 mb-5">
                          <label for="">Mail Username</label>
                          <input type="text" class="form-control" value="{{$mailUsername}}" name="mail_username" required placeholder="Mail Username. Ex: email@example.com" aria-describedby="input-group-email">
                        </div>
                        <div class="mt-5 mb-5">
                          <label for="">Mail Password</label>
                          <input type="text" class="form-control" value="{{$mailPassword}}" name="mail_password" required placeholder="Mail Pasword. Ex: Password Driver dari email Anda" aria-describedby="input-group-email">
                        </div>
                        <div class="mt-5 mb-5">
                          <label for="">Mail From Address</label>
                          <input type="text" class="form-control" value="{{$mailFromAddress}}" name="mail_from_address" required placeholder="Mail From Address. Ex: example@example.com" aria-describedby="input-group-email">
                        </div>
                        <div class="mt-5 mb-5">
                          <label for="">Mail Encryption</label>
                          <input type="text" class="form-control" value="{{$mailEcnryp}}" name="mail_encryption" required placeholder="Mail From Address. Ex: ssl" aria-describedby="input-group-email">
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