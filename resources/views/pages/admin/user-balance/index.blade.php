@extends('layout.side-menu')

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">User Balance</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
            <form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto" >
                <div class="sm:flex items-center sm:mr-4">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
                    <select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
                        <option value="email">Email</option>
                        <option value="status_user">Status User</option>
                        <option value="form_review_status">Status Form</option>
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
            <div id="user-balance" class="mt-5 table-report table-report--tabulator"></div>
        </div>
    </div>
    {{-- DETAIL MODAL --}}
    <div id="large-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-body p-10">
                <div class="preview">
                  <div class="mt-5 mb-5">
                    <label for="">Balance User Saat Ini: </label>
                    <input type="text" class="form-control" id="balance_user" readonly disabled>
                  </div>
                  <div class="mt-5 mb-5">
                    <label for="">Kurangi Balance User Sebesar: </label>
                    <input type="text" class="form-control" id="substract_balance">
                  </div>
                  <div class="mt-5 mb-5" id="btn_update">
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
      var formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
        });
      var table = new Tabulator("#user-balance", {
        ajaxURL:"{{route('balance-control.index')}}", //set url for ajax request
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
                    field: "email",
                    print: true,
                    minWidth: 150,
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div>
                            <div class="font-medium whitespace-nowrap">${
                                cell.getData().email
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "BALANCE",
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
                              formatter.format(cell.getData().balance)
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "STATUS FORM",
                    minWidth: 150,
                    field: "form_review_status",
                    print: true,
                    responsive: 2,
                    hozAlign: "center",
                    vertAlign: "left",
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div class="items-center lg:justify-center">
                            <span class='${
                              cell.getData().form_review_status == 'Pending' ? 'text-theme-12' : (cell.getData().form_review_status == 'Accepted' ? 'text-theme-9' : (cell.getData().form_review_status == 'WAITING LIST' ? 'text-theme-1' : 'text-theme-6'))
                          }'> ${
                            cell.getData().form_review_status
                          }</span>
                         
                        </div>`;
                    },
                },
                {
                    title: "STATUS USER",
                    minWidth: 150,
                    field: "status_user",
                    print: true,
                    hozAlign: "center",
                    vertAlign: "left",
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div class="items-center lg:justify-center">
                            <span class='${
                              cell.getData().status_user == 'Restricted' ? 'text-theme-12' : (cell.getData().status_user == 'Active' ? 'text-theme-9' : 'text-theme-6')
                          }'> ${
                            cell.getData().status_user
                          }</span>
                         
                        </div>`;
                    },
                },
                {
                    title: "ACTIONS",
                    field: "actions",
                    hozAlign: "center",
                    vertAlign: "left",
                    minWidth: 150,
                    responsive: 5,
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                        var a = cash(`<div id="icon-dropdown">
                                        <div class="preview">
                                            <div class="flex justify-center">
                                                <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-primary" aria-expanded="false">Action</button>
                                                    <div class="dropdown-menu w-48">
                                                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                            ${cell.getData().status == 1 ?
                                                              `
                                                              <a href="javascript:;" data-toggle="modal" data-target="#large-modal-size-preview" onclick="detail('${cell.getData().uuid}')" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                  Update Balance
                                                              </a>
                                                              `
                                                            : ''
                                                            }
                                                            
                                                            ${cell.getData().status == 1 ?
                                                                `<a href="javascript:;" onclick="updateStatus('${cell.getData().uuid}','0'); return false;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                    Non Active User
                                                                </a>
                                                                <a href="javascript:;" onclick="updateStatus('${cell.getData().uuid}','2'); return false;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                  Restricted User
                                                                </a>` : ''
                                                            }

                                                            ${cell.getData().status == 0 || cell.getData().status == 2 ?
                                                                `<a href="javascript:;" onclick="updateStatus('${cell.getData().uuid}','1'); return false;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                                 Activated User
                                                              </a>` : ''
                                                            }
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`);
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

        function updateBalance(uuid)
        {
          var url = "{{route('controlBalance')}}?users_id="+uuid;
          var formData = new FormData();
          formData.append('balance',$("#substract_balance").val());
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
              alert('Balance User Berhasil Dikurangi Sebesar ' + formatter.format($("#substract_balance").val()));
              window.location.reload();
            },
            error: function(err) {
              if (err.status == 422) {
                alert('Mohon Isi Balance');
              } else if (err.status == 400) {
                alert('Jumlah Balance Yang Dimasukkan Melebihi Balance User');
              } else {
                alert('Terjadi Kesalahan');
              }
            }
          });
        }


        function detail(uuid)
        {
          var url = "{{route('detail',':uuid')}}"
          url = url.replace(':uuid', uuid);
          $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(res) {
              $("#btn_update").html('');
              $("#balance_user").val(formatter.format(res.balance));
              $("#btn_update").html(`<button type="button" onclick="updateBalance('${uuid}')" id="submit_topup" class="btn btn-primary w-24 mr-1 mb-2">Submit</button>`)
            },
            error: function(err) {
              alert('Terjadi Kesalahan');
            }
          });
          
        }

        function updateStatus(uuid,status)
        {
          var url = "{{route('updateStatusUser',':uuid')}}?status=" + status
          url = url.replace(':uuid', uuid);
          if (confirm('Ingin Mengubah Status User Ini?')) {
            $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'PUT',
              url: url,
              dataType: 'json',
              success: function(res) {
                alert('Status User Berhasil Diubah')
                window.location.reload();
              },
              error: function(err) {
                alert('Terjadi Kesalahan');
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
            $("#tabulator-html-filter-field").val("email");
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