@extends('layout.side-menu')

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">List Tiket User</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
            <form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto" >
                <div class="sm:flex items-center sm:mr-4">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
                    <select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
                        <option value="ticket_id">Tiket ID</option>
                        <option value="status_badge">Status</option>
                        <option value="priority_badge">Priority</option>
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
            <div id="list_ticket" class="mt-5 table-report table-report--tabulator"></div>
        </div>
    </div>
    <!-- END: HTML Table Data -->
@endsection

@section('script')
    <script>
      var table = new Tabulator("#list_ticket", {
        ajaxURL:"{{route('userTicket.index')}}", //set url for ajax request
        ajaxFiltering: true,
        ajaxSorting: true,
        printAsHtml: true,
        printStyled: true,
        pagination: "remote",
        paginationSize: 10,
        responsiveLayout:true,
        paginationSizeSelector: [10, 20, 30, 40],
        layout: "fitColumns",
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
                    title: "TIKET ID",
                    minWidth: 100,
                    responsive: 0,
                    field: "ticket_id",
                    hozAlign: "left",
                    print: true,
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div>
                            <div class="font-medium whitespace-nowrap">${
                                cell.getData().ticket_id
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "USER",
                    minWidth: 100,
                    responsive: 0,
                    field: "user",
                    hozAlign: "left",
                    print: true,
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div >
                            <div class="font-medium whitespace-nowrap">${
                                cell.getData().user.email
                            }</div>
                            <div class="text-gray-600 text-xs whitespace-nowrap">${
                                cell.getData().user.name
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "TITLE",
                    minWidth: 100,
                    field: "title",
                    hozAlign: "center",
                    print: true,
                    download: false,
                    formatter(cell, formatterParams) {
                        return `<div >
                            <div class="font-medium whitespace-nowrap">${
                                cell.getData().title
                            }</div>
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
                              cell.getData().status_badge == 'Pending' ? 'text-theme-12' : (cell.getData().status_badge == 'Finished' ? 'text-theme-9' : 'text-theme-1')
                          }'> ${
                            cell.getData().status_badge
                          }</span>
                         
                        </div>`;
                    },
                },
                {
                    title: "PRIORITY",
                    minWidth: 120,
                    field: "priority_badge",
                    hozAlign: "center",
                    print: true,
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div class="flex items-center lg:justify-center">
                            <span class='${
                              cell.getData().priority_badge == 'Medium' ? 'text-theme-12' : (cell.getData().priority_badge == 'Low' ? 'text-theme-9' : 'text-theme-6')
                          }'> ${
                            cell.getData().priority_badge
                          }</span>
                         
                        </div>`;
                    },
                },
                {
                    title: "ACTION",
                    minWidth: 120,
                    field: "action",
                    hozAlign: "left",
                    print: false,
                    download: false,
                    formatter(cell, formatterParams) {
                       var url = "{{route('detailTicketUser',':id')}}"
                       url = url.replace(':id',cell.getData().id);

                       if(cell.getData().status == 0) {
                        
                        return `<div id="icon-dropdown">
                            <div class="preview">
                                <div class="flex justify-left">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle btn btn-primary" aria-expanded="false">Action</button>
                                        <div class="dropdown-menu w-48">
                                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                              <a href="${url}" class="flex items-center mr-3 btn btn-sm btn-secondary w-24 mr-1 mb-2">
                                                  Detail
                                              </a>
                                              <button class="approve flex items-center mr-3 btn btn-sm btn-primary w-24 mr-1 mb-2" href="javascript:;" onclick="inReview('${cell.getData().id}'); return false;">
                                                  Make In Progress
                                              </button>
                                              <button class="reject flex items-center mr-3 btn btn-sm btn-danger w-24 mr-1 mb-2" href="javascript:;" onclick="finish('${cell.getData().id}'); return false;">
                                                  Make Finished
                                              </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`
                      } else if (cell.getData().status == 1) {
                        return `
                        <div id="icon-dropdown">
                            <div class="preview">
                                <div class="flex justify-left">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle btn btn-primary" aria-expanded="false">Action</button>
                                        <div class="dropdown-menu w-48">
                                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                              <a href="${url}" class="flex items-center mr-3 btn btn-sm btn-secondary w-24 mr-1 mb-2">
                                                  Detail
                                              </a>
                                              <button class="approve flex items-center mr-3 btn btn-sm btn-primary w-24 mr-1 mb-2" href="javascript:;" onclick="pending('${cell.getData().id}'); return false;">
                                                  Make Pending
                                              </button>
                                              <button class="reject flex items-center mr-3 btn btn-sm btn-danger w-24 mr-1 mb-2" href="javascript:;" onclick="finish('${cell.getData().id}'); return false;">
                                                Make Finished
                                              </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                      } else {
                        return `<div id="icon-dropdown">
                              <div class="preview">
                                  <div class="flex justify-left">
                                      <div class="dropdown">
                                          <button class="dropdown-toggle btn btn-primary" aria-expanded="false">Action</button>
                                          <div class="dropdown-menu w-48">
                                              <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                <a href="${url}" class="flex items-center mr-3 btn btn-sm btn-primary w-24 mr-1 mb-2">
                                                    Detail
                                                </a>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>`;
                      }
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
      function pending(id) {
        var url = "{{route('updateTicket',':id')}}?status=0"
        url = url.replace(':id',id);
        if (confirm('Anda Yakin Ingin Mengubah Kembali Ticket Ke Pending?')) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'PUT',
                url: url,
                success: function(res) {
                    alert("Berhasil Mengubah Status Ticket Ke Pending");
                    window.location.reload();
                },
                error: function () {  
                    alert('Terjadi kesalahan. Mohon ulangi');
                }
            })
        }
      } 

      function finish(id) {
        var url = "{{route('updateTicket',':id')}}?status=2"
        url = url.replace(':id',id);
        if (confirm('Anda Yakin Ingin Mengubah Kembali Ticket Ke Finish?')) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'PUT',
                url: url,
                success: function(res) {
                    alert("Berhasil Mengubah Status Ticket Ke Finish");
                    window.location.reload();
                },
                error: function () {  
                    alert('Terjadi kesalahan. Mohon ulangi');
                }
            })
        }
      }

      function inReview(id) {
        var url = "{{route('updateTicket',':id')}}?status=1"
        url = url.replace(':id',id);
        if (confirm('Anda Yakin Ingin Mengubah Kembali Ticket Ke In Review?')) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'PUT',
                url: url,
                success: function(res) {
                    alert("Berhasil Mengubah Status Ticket Ke In Review");
                    window.location.reload();
                },
                error: function () {  
                    alert('Terjadi kesalahan. Mohon ulangi');
                }
            })
        }
      }
      // Redraw table onresize
      window.addEventListener("resize", () => {
            table.redraw();
            feather.replace({
                "stroke-width": 1.5,
            });
        });
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
            $("#tabulator-html-filter-field").val("ticket_id");
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