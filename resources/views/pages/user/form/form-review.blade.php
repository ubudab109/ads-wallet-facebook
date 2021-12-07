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
        <h2 class="text-lg font-medium mr-auto">Input Form Review</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Button Groups -->
            <div class="intro-y box">
              <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                  <h2 class="font-medium text-base mr-auto">Status Form</h2>
              </div>
              <div id="basic-button" class="p-5">
                  <div class="preview">
                    @if ($statusForm != FORM_REVIEW_NOT_APPLICANT)
                      <h3 class="{{FormStatusClass($statusForm)}}">{{FormReviewStatus($statusForm)}}</h3>
                    @else
                    <h2 class="text-sm text-gray-700 dark:text-gray-600 font-medium leading-none mt-3">
                      Anda Belum Mengajukan Form. Silahkan Ajukan Form Dengan Mengisi Form Dibawah
                    </h2>
                    @endif
                      
                  </div>
              </div>
          </div>
            <!-- END: Input Groups -->
        </div>
        @if ($statusForm == FORM_REVIEW_NOT_APPLICANT)
        <div class="intro-y col-span-12 lg:col-span-12">
          <!-- BEGIN: Input Groups -->
          <div class="intro-y box mt-5">
              <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                  <h2 class="font-medium text-base mr-auto">Silahkan Isi Form Terlebih Dahulu Untuk Melakukan Transaksi</h2>
              </div>
              <form action="{{route('submitForm')}}" method="POST">
                @csrf
                <div id="input-groups" class="p-5">
                    <div class="preview">
                        <div class="input-group mt-5 mb-5">
                          <input type="text" class="form-control" name="applicants_name" required placeholder="Nama Pemohon" aria-describedby="input-group-email">
                        </div>
                        <div class="input-group mt-5 mb-5">
                            <input type="text" class="form-control" name="account_information" required placeholder="No Whatsapp / Telegram" aria-describedby="input-group-email">
                        </div>
                        <div class="input-group mt-5 mb-5">
                          <select class="form-select form-select-md sm:mt-2 sm:mr-2" name="account_type" required aria-label=".form-select-lg example">
                            <option selected disabled>Tipe Akun</option>
                            <option value="{{ACCOUNT_WHATSAPP}}">Whatsapp</option>
                            <option value="{{ACCOUNT_TELEGRAM}}">Telegram</option>
                          </select>
                        </div>
                        <div class="input-group mt-5 mb-5">
                            <textarea class="form-control" placeholder="Alamat" name="address"></textarea>
                            <div class="input-group-text">.00</div>
                        </div>
                        <div class="input-group mt-5 mb-5">
                          <input type="email" class="form-control" required name="company_email" placeholder="Email Perusahaan" aria-describedby="input-group-email">
                        </div>
                        <div class="input-group mt-5 mb-5">
                          <input type="text" class="form-control" required name="time_zone" placeholder="Zona Waktu. Ex: Asia/Jakarta, Asia/Jayapura, etc" aria-describedby="input-group-email">
                        </div>
                        <div class="input-group mt-5 mb-5">
                          <select class="form-select form-select-md sm:mt-2 sm:mr-2" id="ads_type" required aria-label=".form-select-lg example">
                            <option selected disabled>Jenis Iklan</option>
                            <option value="Apllications or Game">Apllications or Game</option>
                            <option value="E-Commerce">E-Commerce</option>
                            <option value="Information">Information</option>
                            <option value="Technology">Technology</option>
                            <option value="0">Lainnya</option>
                          </select>
                          <input type="text" id="other_ads" class="form-control d-none" name="ads_type" placeholder="Tuliskan Jenis Iklan Anda Disini..." aria-describedby="input-group-email">
                        </div>
                        <div class="input-group mt-5 mb-5">
                          <select class="form-select form-select-md sm:mt-2 sm:mr-2" name="cost_spending" required aria-label=".form-select-lg example">
                            <option selected disabled>Spending Budget Iklan Bulanan</option>
                            @foreach (CostSpend() as $key => $item)    
                              <option value="{{$key}}">{{$item}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="input-group mt-5 mb-5">
                          <input type="text" class="form-control" name="company_website" placeholder="Website Perusahaan (Optional)" aria-describedby="input-group-email">
                        </div>
                        <div class="input-group mt-5 mb-5">
                          <input type="text" class="form-control" name="account_ads_name" required placeholder="Nama Akun Iklan" aria-describedby="input-group-email">
                        </div>
                        <div class="input-group mt-5 mb-5">
                          <input type="text" class="form-control" name="facebook_home_url" required placeholder="URL Halaman Facebook" aria-describedby="input-group-email">
                        </div>
                        <div class="input-group mt-5 mb-5">
                          <input type="text" class="form-control" name="facebook_app_id" required placeholder="Facebook APP ID" aria-describedby="input-group-email">
                        </div>
                        <div class="input-group mt-5 mb-5">
                          <input type="text" class="form-control" name="url_ads" required placeholder="URL Yang Diiklankan (Landing Page)" aria-describedby="input-group-email">
                        </div>
                        <button type="submit" class="btn btn-primary w-24 mr-1 mb-2">Submit</button>
                    </div>
                </div>
              </form>
          </div>
          <!-- END: Input Groups -->
        </div>
        @endif
    </div>    
@endsection
@section('script')
    <script>
      document.getElementById('ads_type').addEventListener('change',(e) => {
        var element = document.getElementById('other_ads');
        if (e.target.value == '0') {
          element.classList.remove('d-none')
          element.value = '';
        } else {
          element.classList.add('d-none')
          element.value = document.getElementById('ads_type').value;
          console.log(element.value);
        }
      })
    </script>
@endsection