@extends('layout.side-menu')

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">History Refund</h2>
    </div>
    <div id="approve" class="modal" tabindex="-1" aria-hidden="false">
      <div class="modal-dialog">
          <div class="modal-content">
            <div id="single-file-upload" class="p-5">
              <form data-single="true" enctype="multipart/form-data" action="{{route('uploadInvoice.refund')}}" class="dropzone">
                  @csrf
                  
                  <div class="dz-message" data-dz-message>
                      <div class="text-lg font-medium">Drop files here or click to upload.</div>
                      <div class="text-gray-600">
                          Silahkan Upload Bukti Topup Disini.
                      </div>
                  </div>
              </form>
  
              <input name="invoice" type="hidden" id="file-invoice" />
              <div class="mt-3" id="submit_refund">
                
              </div>
            </div>
          </div>
      </div>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
            <form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto" >
                <div class="sm:flex items-center sm:mr-4">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
                    <select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
                        <option value="transaction_id">Transaction ID</option>
                        <option value="status_badge">Status</option>
                    </select>
                </div>
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Type</label>
                    <select id="tabulator-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto" >
                        <option value="like" selected>like</option>
                        <option value="=">=</option>
                        <option value="<">&lt;</option>
                        <option value="<=">&lt;=</option>
                        <option value=">">></option>
                        <option value=">=">>=</option>
                        <option value="!=">!=</option>
                    </select>
                </div>
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Value</label>
                    <input id="tabulator-html-filter-value" type="text" class="form-control sm:w-40 xxl:w-full mt-2 sm:mt-0"  placeholder="Search...">
                </div>
                <div class="mt-2 xl:mt-0">
                    <button id="tabulator-html-filter-go" type="button" class="btn btn-primary w-full sm:w-16" >Go</button>
                    <button id="tabulator-html-filter-reset" type="button" class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" >Reset</button>
                </div>
            </form>
            <div class="flex mt-5 sm:mt-0">
                <button id="tabulator-print" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2">
                    <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print
                </button>
                <div class="dropdown w-1/2 sm:w-auto">
                    <button class="dropdown-toggle btn btn-outline-secondary w-full sm:w-auto" aria-expanded="false">
                        <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export <i data-feather="chevron-down" class="w-4 h-4 ml-auto sm:ml-2"></i>
                    </button>
                    <div class="dropdown-menu w-40">
                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                            <a id="tabulator-export-csv" href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export CSV
                            </a>
                            <a id="tabulator-export-xlsx" href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export XLSX
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto scrollbar-hidden">
            <div id="history_refund" class="mt-5 table-report table-report--tabulator"></div>
        </div>
    </div>
    <div id="basic-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body p-10 text-center" id="preview-image">
                  
            </div>
          </div>
      </div>
    </div>

    <!-- END: HTML Table Data -->
@endsection

@section('script')
    <script>
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
      var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
      });
        var table = new Tabulator("#history_refund", {
          ajaxURL:"{{route('refund-user.index')}}", //set url for ajax request
          ajaxFiltering: true,
          ajaxSorting: true,
          printAsHtml: true,
          printStyled: true,
          pagination: "remote",
          paginationSize: 10,
          responsiveLayout:true,
          paginationSizeSelector: [10, 20, 30, 40],
          layout: "fitDataFill",
          responsiveLayout: "collapse",
          placeholder: "No matching records found",
          columns: [
                  {
                      formatter: "responsiveCollapse",
                      width: 40,
                      minWidth: 30,
                      align: "left",
                      resizable: false,
                      headerSort: false,
                  },

                  // For HTML table
                  {
                      title: "TRANSACTION ID",
                      minWidth: 100,
                      responsive: 0,
                      field: "transaction_id",
                      hozAlign: "left",
                      print: true,
                      download: true,
                      formatter(cell, formatterParams) {
                          return `<div>
                              <div class="font-medium whitespace-nowrap">${
                                  cell.getData().transaction_id
                              }</div>
                          </div>`;
                      },
                  },
                  {
                      title: "BANK",
                      minWidth: 100,
                      field: "bank_user",
                      hozAlign: "center",
                      print: true,
                      download: false,
                      formatter(cell, formatterParams) {
                          return `<div >
                              <div class="font-medium whitespace-nowrap">${
                                  cell.getData().bank_user.bank_number
                              }</div>
                              <div class="text-gray-600 text-xs whitespace-nowrap">${
                                  cell.getData().bank_user.bank_name
                              } | ${cell.getData().bank_user.account_holder_bank} </div>
                          </div>`;
                      },
                  },
                  {
                      title: "TOTAL REFUND",
                      minWidth: 100,
                      field: "total_refund",
                      hozAlign: "center",
                      responsive: 2,
                      print: true,
                      download: true,
                      formatter(cell, formatterParams) {
                          return `<div >
                              <div class="font-medium whitespace-nowrap">Rp. ${
                                numberWithCommas(cell.getData().total_refund) 
                              }</div>`;
                      },
                      
                  },
                  {
                      title: "DOLLAR REFUND",
                      minWidth: 100,
                      field: "dollar_refund",
                      hozAlign: "center",
                      print: true,
                      download: true,
                      responsive: 3,
                      formatter(cell, formatterParams) {
                          return `<div >
                                    <div class="font-medium whitespace-nowrap">${
                                      formatter.format(cell.getData().dollar_refund) 
                                    }
                                  </div>`;
                          
                      },
                  },
                  {
                      title: "STATUS",
                      minWidth: 120,
                      field: "status_badge",
                      hozAlign: "center",
                      print: true,
                      download: true,
                      formatter(cell, formatterParams) {
                          return `<div class="flex items-center lg:justify-center">
                              <span class='${
                                cell.getData().status_badge == 'Pending' ? 'text-theme-12' : (cell.getData().status_badge == 'Approved' ? 'text-theme-9' : 'text-theme-6')
                            }'> ${
                              cell.getData().status_badge
                            }</span>
                          
                          </div>`;
                      },
                  },
                  {
                      title: "BUKTI TRANSFER",
                      minWidth: 50,
                      responsive:3,
                      field: "image",
                      hozAlign: "left",
                      print: false,
                      download: false,
                      formatter(cell, formatterParams) {
                        if (cell.getData().image != null) {
                          return `<div >
                                    <div class="font-medium whitespace-nowrap">
                                      <a href="javascript:;" onclick="previewImage('${cell.getData().image}')" data-toggle="modal" data-target="#basic-modal-preview" class="btn btn-primary">Bukti Transfer</a>
                                      
                                  </div>`;
                        } else {
                          return `<div >
                                    <div class="font-medium whitespace-nowrap">
                                      <a class="btn btn-primary">Anda Belum Upload Bukti Transfer</a>
                                      
                                  </div>`;
                        }
                          
                      },
                  },
                  {
                      title: "ACTIONS",
                      field: "actions",
                      vertAlign: "middle",
                      print: false,
                      download: false,
                      formatter(cell, formatterParams) {
                        if(cell.getData().status_badge == 'Pending') {
                          var a = cash(`<div class="flex lg:justify-center items-center">
                              <a data-toggle='modal' data-target='#approve' class="approve flex items-center mr-3 btn btn-sm btn-primary w-24 mr-1 mb-2" href="javascript:;" onclick="approve('${cell.getData().transaction_id}')">
                                  <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Approve
                              </a>
                              <button class="reject flex items-center mr-3 btn btn-sm btn-danger w-24 mr-1 mb-2" href="javascript:;" onclick="reject('${cell.getData().transaction_id}'); return false;">
                                  <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Reject
                              </button>
                          </div>`);
                        } else {
                          var a = cash(`<div class="flex lg:justify-center items-center">
                              <span class='flex items-center mr-3'>Transaksi Sudah Selesai</span>
                          </div>`);
                        }

                          return a[0];
                      },
                  },
              ],
              renderComplete() {
                  feather.replace({
                      "stroke-width": 1.5,
                  });
              },
              
        });

        function previewImage(src)
        {
          $("#preview-image").html('');
          $("#preview-image").html(`
              <img src="${src}" width="500"/>
          
          `);
        }
        
        // Redraw table onresize
        window.addEventListener("resize", () => {
              table.redraw();
              feather.replace({
                  "stroke-width": 1.5,
              });
          });
        
        
        function approveProcess(uuid)
        {
            var url = "{{route('approveRefund',':uuid')}}"
            url = url.replace(':uuid', uuid);
            var file = $("#file-invoice").val();
            var formData = new FormData();
            formData.append('bank_sleep_admin', file);
            if(confirm("Anda Yakin Ingin Approve Transaksi Ini?")) {
              $.ajax({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  type: 'POST',
                  data: formData,
                  processData: false,
                  contentType: false,
                  url: url,
                  success: function(res) {
                    alert('Sukses. Transaksi Berhasil Dikonfirmasi');
                    window.location.reload();
                  },
                  error: function(err) {
                    if (err.status == 400) {
                      alert("Harap Upload Gambar");
                    } else  {
                      alert("Terjadi Kesalahan. Mohon Ulangi");
                    }
                  }
                });
            } 
        }


        function approve(uuid)
        {
          $("#submit_refund").html('')
          $("#submit_refund").html(`
                <button type="button" onclick="approveProcess('${uuid}'); return false;" id="submit_topup" class="btn btn-primary w-24 mr-1 mb-2">Submit</button>
              `)
        }

        function reject(uuid)
        {
          var url = "{{route('rejectRefund',':uuid')}}"
          url = url.replace(':uuid', uuid);
          if(confirm("Anda Yakin Ingin Reject Transaksi Ini?")) {
            $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'PUT',
              url: url,
              success: function(res) {
                alert('Sukses. Transaksi Berhasil Direject');
                window.location.reload();
              }
            });
          } else {
            return null;
          }
        }


          function filterHTMLForm() {
              let field = $("#tabulator-html-filter-field").val();
              let type = $("#tabulator-html-filter-type").val();
              let value = $("#tabulator-html-filter-value").val();
              table.setFilter(field, type, value);
          }
          // On submit filter form
          $("#tabulator-html-filter-form")[0].addEventListener(
              "keypress",
              function (event) {
                  let keycode = event.keyCode ? event.keyCode : event.which;
                  if (keycode == "13") {
                      event.preventDefault();
                      filterHTMLForm();
                  }
              }
          );

          // On click go button
          $("#tabulator-html-filter-go").on("click", function (event) {
              filterHTMLForm();
          });

          // On reset filter form
          $("#tabulator-html-filter-reset").on("click", function (event) {
              $("#tabulator-html-filter-field").val("transaction_id");
              $("#tabulator-html-filter-type").val("like");
              $("#tabulator-html-filter-value").val("");
              filterHTMLForm();
          });

          // Export
          $("#tabulator-export-csv").on("click", function (event) {
              table.download("csv", "data.csv");
          });


          $("#tabulator-export-xlsx").on("click", function (event) {
              // window.XLSX = xlsx;
              table.download("xlsx", "data.xlsx", {
                  sheetName: "Products",
              });
          });

          // Print
          $("#tabulator-print").on("click", function (event) {
              table.print();
          });
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
              url: '{{route("deleteInvoice.refund")}}',
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