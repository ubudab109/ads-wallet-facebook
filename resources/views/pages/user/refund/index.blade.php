@extends('layout.side-menu')


@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Regular Form</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
      @if (Auth::user()->form_status != FORM_REVIEW_WAITING_LIST)
      <div class="intro-y col-span-12 lg:col-span-12">
          <!-- BEGIN: Input State -->
          <div class="intro-y box mt-5">
              <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">Form Review Belum Diterima Atau Dikonfimasi Oleh Admin. Mohon Untuk Melakukan Pengajuan Form Dengan Klik Tombol Berikut</h2>
                <div class="form-check w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                  <a class="btn btn-primary btn-md ml-0 sm:ml-2" for="show-example-5" href="{{route('form-review.user.index')}}">Ajukan Form</a>
                </div>
              </div>
          </div>
          <!-- END: Input State -->
      </div>
      @else
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input State -->
            <div class="intro-y box mt-5">
                <div class="flex flex-col sm:flex-row items-between p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Form Refund</h2>
                    <div class="form-check w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                      <label class="form-check-label ml-0 sm:ml-2 text-theme-6" for="show-example-5" id="dollar-kurs"></label>
                    </div>
                  </div>
                  <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    {{-- <a href="https://www.bca.co.id/id/informasi/kurs" target="blank">Dollar Kurs Ini Didapatkan Kurs BCA Saat Ini (Silahkan Klik Tulisan Ini Untuk Melihat Kurs)</a> --}}

                    <a href="#" >Balance Anda Saat Ini = ${{number_format(Auth::user()->balance, 2)}}</a>
                  </div>
                  <form action="" id="form_topup" class="dropzone">
                      <div class="preview">
                          <div>
                              <label for="input-state-1" class="form-label">Jumlah Refund (Dollar)</label>
                              <input id="dollar_refund" type="text" class="form-control" placeholder="Jumlah Refund Dollar">
                              <div class="text-theme-6 mt-2" id="error_amount"></div>
                          </div>
                          <div class="mt-3">
                              <label for="input-state-3" class="form-label">Total Refund</label>
                              <input id="total_refund" type="text" class="form-control" readonly>
                          </div>
                          <!-- BEGIN: Basic Select -->
                          <div class="mt-3">
                            <label>Pilih Bank Anda</label>
                            <div>
                              <select class="form-select form-select-md sm:mt-2 sm:mr-2" onchange="getBank(this.value)" id="bank_option">
                                  <option selected disabled>Pilih Bank</option>
                                  @foreach ($userBanks as $item)
                                    <option value="{{$item->id}}">{{$item->bank_name}}</option>
                                  @endforeach
                              </select>
                            </div>
                        <!-- END: Basic Select -->
                        </div>
                          <div class="mt-3">
                            <button type="button" onclick="submitRefund()" id="submit_refund" class="btn btn-primary w-24 mr-1 mb-2">Submit</button>
                          </div>
                      </div>
                  </form>
            </div>
            <!-- END: Input State -->
        </div>
        <div class="intro-y col-span-12 lg:col-span-6">
          <!-- BEGIN: Input State -->
          <div class="intro-y box mt-5">
              <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                  <h2 class="font-medium text-base mr-auto">Detail Bank Anda</h2>
              </div>
              <div id="horizontal-form" class="p-5">
                <div class="preview">
                    <div class="form-inline">
                        <label for="horizontal-form-1" class="form-label sm:w-20">Nama Bank</label>
                        <input id="admin_bank" type="text" disabled readonly class="form-control">
                    </div>
                    <div class="form-inline mt-5">
                        <label for="horizontal-form-2" class="form-label sm:w-20">Nomor Rekening</label>
                        <input id="rek_bank" type="text" disabled readonly class="form-control">
                    </div>
                    <div class="form-inline mt-5">
                      <label for="horizontal-form-3" class="form-label sm:w-20">Nama Pemilik</label>
                      <input id="name_rek" type="text" disabled readonly class="form-control">
                  </div>
                </div>
            </div>
          </div>
          <!-- END: Input State -->
        </div>
      @endif
    </div>    
@endsection

@section('script')
    <script>
      var dollars = 0;
      var totalAmountRefund = 0;
      function numberWithCommas(x) {
          var	number_string = x.toString(),
              split	= number_string.split('.'),
              sisa 	= split[0].length % 3,
              rupiah 	= split[0].substr(0, sisa),
              ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                  
          if (ribuan) {
              separator = sisa ? '.' : '';
              rupiah += separator + ribuan.join('.');
          }
          rupiah = split[1] != undefined ? rupiah : rupiah;

          return rupiah;
      }
      
      function getBank(id) {
        var url = "{{route('user.bank.detail',':id')}}"
        url = url.replace(':id', id);
        $.ajax({
          type: 'GET',
          url : url,
          success : function(res) {
            $("#admin_bank").val(res.bank_name);
            $("#rek_bank").val(res.bank_number);
            $("#name_rek").val(res.account_holder_bank);
          }
        })
      }

      $(document).ready(function() {
        $.ajax({
          type: 'GET',
          url: '{{route("dollarKursBca")}}',
          beforeSend: function() {
            $("#dollar-kurs").text(`Sedang memeriksa kurs dollar saat ini. Harap Tunggu......`);
            $("#form_topup :input").prop("disabled", true);
          },
          success: function(res) {
            var doller = res.data;
            var feeDollar = doller;
            $("#dollar-kurs").text(`1$ = Rp. ${numberWithCommas(feeDollar)}`);
            dollars += parseFloat(feeDollar);
            $("#form_topup :input").removeAttr("disabled");
          }
        })
      });

      $("#dollar_refund").on('keyup',(e) => {
        var formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
        });
        var minimumRefund = "{{allsetting('refund_minimum')}}";
        var amount = parseFloat(e.target.value);
        var fee = "{{settings('topup_fee_percent')}}";
        if (amount) {
          if (amount < minimumRefund) {
            $("#error_amount").text('Minimum Refund $' + minimumRefund);
            $("#submit_refund").attr('disabled',true);
            $("#total_fee").val('');
            $("#dollar").val('');
            totalDollarTopup = 0;
          } else {
            var totalAmount = amount * dollars;
            totalAmountRefund += totalAmount;
            $("#total_refund").val('Rp. ' + numberWithCommas(totalAmount));
            $("#error_amount").text('');
            $("#submit_refund").attr('disabled',false);
  
          }
        } else {
            totalAmountRefund = 0;
            $("#submit_refund").attr('disabled',true);
            $("#total_fee").val('');
            $("#dollar").val('');
        }
      });

      function submitRefund()
      {
        var form = new FormData();
        form.append('dollar_refund',$("#dollar_refund").val());
        form.append('bank_user_id', $("#bank_option option:selected").val());
        form.append('total_refund', totalAmountRefund);

        $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type : 'POST',
          processData: false,
          contentType: false,
          url: "{{route('refund')}}",
          data: form,
          success: function(res) {
            alert('Refund Berhasil. Mohon Untuk Menunggu Konfirmasi Admin');
            window.location.href = "{{route('historyRefund')}}";
          },
          error: function(err) {
            if (err.status == 400) {
              alert('Harap Periksa Semua Form');
            } else if (err.status == 422) {
              alert('Balance Anda Tidak Mencukupi');
            } else {
              alert('Terjadi Kesalahan Mohon Untuk Diulangi');
            }
          }
        })
      }
    </script>
@endsection