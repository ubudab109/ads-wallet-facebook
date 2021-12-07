@extends('layout.side-menu')

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Form Pending</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
            <form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto" >
                <div class="sm:flex items-center sm:mr-4">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
                    <select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
                        <option value="email_user">Email</option>
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
        {{-- TABLE --}}
        <div class="overflow-x-auto scrollbar-hidden">
            <div id="form-pending" class="mt-5 table-report table-report--tabulator"></div>
        </div>
    </div>
    {{-- DETAIL MODAL --}}
    <div id="large-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-body p-10">
                <div class="preview">
                  <div class="mt-5 mb-5">
                    <label for="">Akun User</label>
                    <input type="text" class="form-control" id="akun_user" readonly disabled>
                  </div>
                  <div class="mt-5 mb-5">
                    <label for="">Tipe Akun</label>
                    <input type="text" class="form-control" id="tipe_akun" readonly disabled>
                  </div>
                  <div class="mt-5 mb-5">
                    <label for="">Alamat</label>
                    <textarea class="form-control" placeholder="Alamat" id="address" readonly disabled></textarea>
                  </div>
                  <div class="mt-5 mb-5">
                    <label for="">Zona Waktu</label>
                    <input type="text" class="form-control" id="zona_waktu" readonly disabled>
                  </div>
                  <div class="mt-5 mb-5">
                    <label for="">Jenis Iklan</label>
                    <input type="text" class="form-control" id="jenis_iklan" readonly disabled>
                  </div>
                  <div class="mt-5 mb-5">
                    <label for="">Email Perusahaan</label>
                    <input type="text" class="form-control" id="company_email" readonly disabled>
                  </div>
                  <div class="mt-5 mb-5">
                    <label for="">Spending Budget</label>
                    <input type="text" class="form-control" id="cost_spending" readonly disabled>
                  </div>
                  <div class="mt-5 mb-5">
                    <label for="">Website Perusahaan</label>
                    <input type="text" class="form-control" id="company_website" readonly disabled>
                  </div>
                  <div class="mt-5 mb-5">
                    <label for="">Nama Akun Iklan</label>
                    <input type="text" class="form-control" id="account_ads_name"  readonly disabled>
                  </div>
                  <div class="mt-5 mb-5">
                    <label for="">Home Facebook URL</label>
                    <input type="text" class="form-control" id="facebook_home_url" readonly disabled>
                  </div>
                  <div class="mt-5 mb-5">
                    <label for="">Facebook APP ID</label>
                    <input type="text" class="form-control" id="facebook_app_id" readonly disabled>
                  </div>
                  <div class="mt-5 mb-5">
                    <label for="">URL Iklan</label>
                    <input type="text" class="form-control" id="url_ads" rreadonly disabled>
                  </div>
              </div>
              </div>
          </div>
      </div>
  </div>
    <!-- END: HTML Table Data -->
@endsection

@section('script')
    <script>
    
      var table = new Tabulator("#form-pending", {
        ajaxURL:"{{route('form-pending.index')}}", //set url for ajax request
        ajaxFiltering: true,
        ajaxSorting: true,
        printAsHtml: true,
        printStyled: true,
        pagination: "remote",
        paginationSize: 10,
        paginationSizeSelector: [10, 20, 30, 40],
        layout:"fitColumns",
        responsiveLayout: "collapse",
        placeholder: "No matching records found",
        columns: [
                {
                    formatter: "responsiveCollapse",
                    align: "left",
                    minWidth: 40,
                    resizable: false,
                    headerSort: false,
                },

                // For HTML table
                {
                    title: "USER EMAIL",
                    field: "email_user",
                    print: true,
                    minWidth: 150,
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div>
                            <div class="font-medium whitespace-nowrap">${
                                cell.getData().email_user
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "NAMA PEMOHON",
                    minWidth: 150,
                    field: "account_type",
                    print: true,
                    hozAlign: "center",
                    vertAlign: "left",
                    responsive: 2,
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div>
                            <div class="font-medium">${
                                cell.getData().type_account
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "TIPE AKUN",
                    minWidth: 150,
                    field: "account_type",
                    print: true,
                    hozAlign: "center",
                    vertAlign: "left",
                    responsive: 2,
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div>
                            <div class="font-medium">${
                                cell.getData().type_account
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "INFORMASI AKUN",
                    minWidth: 150,
                    field: "account_information",
                    print: true,
                    responsive: 2,
                    hozAlign: "center",
                    vertAlign: "left",
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div>
                            <div class="font-medium">${
                                cell.getData().account_information
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "STATUS",
                    minWidth: 150,
                    field: "status_badge",
                    print: true,
                    hozAlign: "center",
                    vertAlign: "left",
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
                    title: "ACTIONS",
                    field: "actions",
                    hozAlign: "left",
                    vertAlign: "left",
                    minWidth: 150,
                    responsive: 5,
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        var a = cash(`<div id="icon-dropdown">
                                        <div class="preview">
                                            <div class="flex justify-left">
                                                <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-primary" aria-expanded="false">Action</button>
                                                    <div class="dropdown-menu w-48">
                                                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                            <a href="javascript:;" data-toggle="modal" data-target="#large-modal-size-preview"  onclick="detail('${cell.getData().id}')" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                <i data-feather="eye" class="w-4 h-4 mr-2"></i> Detail
                                                            </a>
                                                            <a href="" onclick="approve('${cell.getData().id}');return false;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                <i data-feather="thumbs-up" class="w-4 h-4 mr-2"></i> Approve
                                                            </a>
                                                            <a href="" onclick="reject('${cell.getData().id}');return false;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                <i data-feather="thumbs-down" class="w-4 h-4 mr-2"></i> Reject
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`)
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

      // Redraw table onresize
      window.addEventListener("resize", () => {
            table.redraw();
            feather.replace({
                "stroke-width": 1.5,
            });
        });

        function detail(id)
        {
          var url = "{{route('detailForm',':id')}}"
          url = url.replace(':id', id);
          $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(res) {
              $("#akun_user").val(res.account_information);
              $("#tipe_akun").val(res.type_account);
              $("#address").text(res.address);
              $("#zona_waktu").val(res.time_zone);
              $("#jenis_iklan").val(res.ads_type);
              $("#company_email").val(res.company_email);
              $("#cost_spending").val(res.spending);
              $("#company_website").val(res.company_website != null ? res.company_website : 'Tidak Ada');
              $("#account_ads_name").val(res.account_ads_name);
              $("#facebook_home_url").val(res.facebook_home_url);
              $("#facebook_app_id").val(res.facebook_app_id);
              $("#url_ads").val(res.url_ads);
            }
          })
        }

        function approve(id)
        {
          var url = "{{route('form-confirmation',':id')}}?status=2"
          url = url.replace(':id', id);
          if(confirm("Anda Yakin Ingin Approve Form Ini?")) {
            $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'PUT',
              url: url,
              success: function(res) {
                alert('Sukses. Form Berhasil Dikonfirmasi');
                window.location.reload();
              }
            });
          }
        }

        function reject(id)
        {
          var url = "{{route('form-confirmation',':id')}}?status=3"
          url = url.replace(':id', id);
          if(confirm("Anda Yakin Ingin Reject Form Ini?")) {
            $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'PUT',
              url: url,
              success: function(res) {
                alert('Sukses. Form Review Berhasil Direject');
                window.location.reload();

              }
            });
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
            $("#tabulator-html-filter-field").val("email_user");
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
@endsection