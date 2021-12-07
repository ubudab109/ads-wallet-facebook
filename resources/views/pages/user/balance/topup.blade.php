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
                    <h2 class="font-medium text-base mr-auto">Form Topup</h2>
                    <div class="form-check w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                      <label class="form-check-label ml-0 sm:ml-2 text-theme-6" for="show-example-5" id="dollar-kurs"></label>
                    </div>
                  </div>
                <div id="single-file-upload" class="p-5">
                  <form data-single="true" enctype="multipart/form-data" action="{{route('uploadInvoice')}}" class="dropzone">
                      @csrf
                      
                      <div class="dz-message" data-dz-message>
                          <div class="text-lg font-medium">Drop files here or click to upload.</div>
                          <div class="text-gray-600">
                              Silahkan Upload Bukti Topup Disini.
                          </div>
                      </div>
                  </form>
                </div>
                <form action="" id="form_topup" class="dropzone">
                      <div class="preview">
                          <div>
                              <label for="input-state-1" class="form-label">Jumlah Topup (IDR)</label>
                              <input id="amount_topup" type="text" class="form-control" placeholder="Jumlah Topup Rupiah">
                              <div class="text-theme-6 mt-2" id="error_amount"></div>
                          </div>
                          <div class="mt-3">
                              <label for="input-state-2" class="form-label">Total Topup (Fee)</label> <span class="text-theme-6" id="error_amount">Mohon untuk melakukan topup dengan nilai ini</span>
                              <input id="total_fee" type="text" class="form-control" readonly>
                              

                          </div>
                          <div class="mt-3">
                              <label for="input-state-3" class="form-label">Total Dollar</label>
                              <input id="dollar" type="text" class="form-control" readonly>
                          </div>
                          <!-- BEGIN: Basic Select -->
                          <div class="mt-3">
                            <label>Bank Admin</label>
                            <div>
                              <select class="form-select form-select-md sm:mt-2 sm:mr-2" onchange="getBank(this.value)" id="admin_bank_option">
                                  <option selected disabled>Pilih Bank</option>
                                  @foreach ($adminBank as $item)
                                    <option value="{{$item->id}}">{{$item->bank_name}}</option>
                                  @endforeach
                              </select>
                            </div>
                        <!-- END: Basic Select -->
                        </div>
                          <input name="file" name="invoice" type="hidden" id="file-invoice" />
                          <div class="mt-3">
                            <button type="button" onclick="submitTopup()" id="submit_topup" class="btn btn-primary w-24 mr-1 mb-2">Submit</button>
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
                  <h2 class="font-medium text-base mr-auto">Detail Bank Admin</h2>
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
      var totalDollarTopup = 0;
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
        var url = "{{route('getBankAdmin',':id')}}"
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
            var feeDollar = doller * 1.05;
            $("#dollar-kurs").text(`1$ = Rp. ${numberWithCommas(feeDollar)}`);
            dollars += parseFloat(feeDollar);
            $("#form_topup :input").removeAttr("disabled");
          }
        })
      });

      $("#amount_topup").on('keyup',(e) => {
        var formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
        });
        var minimumTopup = "{{allsetting('topup_minimum')}}";
        var amount = parseFloat(e.target.value);
        var fee = "{{settings('topup_fee_percent')}}";
        if (amount) {
          if (amount < minimumTopup) {
            $("#error_amount").text('Minimum Topup Rp. ' + minimumTopup);
            $("#submit_topup").attr('disabled',true);
            $("#total_fee").val('');
            $("#dollar").val('');
            totalDollarTopup = 0;
          } else {
            var totalFee = fee / 100;
            var feeTopup = amount * totalFee;
            var totalAmount = amount + feeTopup;
            var totalDollar = amount / dollars;
            totalDollarTopup = totalDollar;
            $("#total_fee").val('Rp. ' + numberWithCommas(totalAmount));
            $("#dollar").val(formatter.format(totalDollar));
            $("#error_amount").text('');
            $("#submit_topup").attr('disabled',false);
  
          }
        } else {
            totalDollarTopup = 0;
            $("#submit_topup").attr('disabled',true);
            $("#total_fee").val('');
            $("#dollar").val('');
        }
      });

      function submitTopup()
      {
        var form = new FormData();
        form.append('bank_sleep',$("#file-invoice").val());
        form.append('admin_bank_id', $("#admin_bank_option option:selected").val());
        form.append('amount_topup', $("#amount_topup").val());
        form.append('dollar_amount',totalDollarTopup);

        $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type : 'POST',
          processData: false,
          contentType: false,
          url: "{{route('topupProcess')}}",
          data: form,
          success: function(res) {
            alert('Topup Berhasil. Mohon Untuk Menunggu Konfirmasi Admin');
            window.location.href = "{{route('topupHistory')}}";
          },
          error: function(err) {
            if (err.status == 400) {
              alert('Harap Periksa Semua Form');
            } else {
              alert('Terjadi Kesalahan Mohon Untuk Diulangi');
              // window.location.reload();
            }
          }
        })
      }
    </script>
    <script>
       var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone",{
            maxFiles: 1,
            maxFilesize: 1, // 2 mb
            acceptedFiles: ".jpeg,.jpg,.png",
            addRemoveLinks: true,
            sending: function(file, xhr, formData) {
              formData.append("_token", CSRF_TOKEN);
            },
            success: function(file, response) {
              if(response.success == 0){ // Error
                  alert(response.message);
              } else {
                alert(response.message)
              }
              $("#file-invoice").val(file.name);
            },
            removedfile: function(file) {
              var fileName = file.name; 
                
              $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{route("deleteInvoice")}}',
                data: {file: fileName},
                sucess: function(data){
                    alert(data.messages);
                    $("#file-invoice").val('');
                }
              });
        
              var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            init: function() {
              this.on("maxfilesexceeded", function(file){
                    alert("Anda hanya bisa upload gambar 1 kali. Silahkan hapus gambar sebelumnya terlebih dahulu");
                    this.removeFile(file);
                });
            }
        });
    </script>
@endsection