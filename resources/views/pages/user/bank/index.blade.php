@extends('layout.side-menu')

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">List Bank</h2>
    </div>
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
      <a href="javascript:;" data-toggle="modal" data-target="#addBank" class="btn btn-primary w-24 mr-1 mb-2">Tambah Bank</a>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
            <form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto" >
                <div class="sm:flex items-center sm:mr-4">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
                    <select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
                        <option value="bank_name">Bank Name</option>
                        <option value="bank_number">Status User</option>
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
        </div>
        {{-- TABLE --}}
        <div class="overflow-x-auto scrollbar-hidden">
            <div id="list-bank" class="mt-5 table-report table-report--tabulator"></div>
        </div>
    </div>
    {{-- DETAIL MODAL --}}
    <div id="addBank" class="modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-body p-10">
                <form action="{{route('addBank.user')}}" method="POST">
                  @csrf
                  <div class="preview">
                    <div class="mt-5 mb-5">
                      <label for="">Nama Bank </label>
                      <input type="text" class="form-control" name="bank_name">
                    </div>
                    <div class="mt-5 mb-5">
                      <label for="">Rekening Bank </label>
                      <input type="text" class="form-control" name="bank_number">
                    </div>
                    <div class="mt-5 mb-5">
                      <label for="">Nama Pada Bank </label>
                      <input type="text" class="form-control" name="account_holder_bank">
                    </div>
                    <div class="mt-5 mb-5">
                      <button type="submit" class="btn btn-primary w-24 mr-1 mb-2">Submit</button>
                      <a id="programmatically-hide-modal" href="javascript:;" class="btn btn-secondary mr-1">Cancel</a>
                    </div>
                  </div>
                </form>
              </div>
          </div>
      </div>
    </div>

@endsection

@section('script')
    <script>
      $("#programmatically-hide-modal").on('click',() => {
        $("#addBank").modal('hide');
      })
      var formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
        });
      var table = new Tabulator("#list-bank", {
        ajaxURL:"{{route('user.bank.index')}}", //set url for ajax request
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
                    title: "NAMA BANK",
                    field: "bank_name",
                    print: true,
                    minWidth: 150,
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div>
                            <div class="font-medium whitespace-nowrap">${
                                cell.getData().bank_name
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "NOMOR REKENING",
                    minWidth: 150,
                    field: "bank_number",
                    print: true,
                    hozAlign: "center",
                    vertAlign: "left",
                    responsive: 2,
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div>
                            <div class="font-medium">${
                              cell.getData().bank_number
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "NAMA PADA BANK",
                    minWidth: 150,
                    field: "account_holder_bank",
                    print: true,
                    responsive: 2,
                    hozAlign: "center",
                    vertAlign: "left",
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div>
                            <div class="font-medium">${
                              cell.getData().account_holder_bank
                            }</div>
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
                                                          <a href="javascript:;" onclick="deleteBank('${cell.getData().id}'); return false;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                            Delete
                                                          </a>
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

      function deleteBank(id)
      {
        var url = "{{route('deleteBank.user', ':id')}}";
        url = url.replace(':id', id);
        if (confirm('Anda Yakin Ingin Menghapus Data Bank Ini?')) {
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'DELETE',
            url: url,
            success: function(res) {
              alert('Berhasil menghapus bank');
              window.location.reload();
            },
            error: function (err) {
              alert('Terjadi Kesalahan. Mohon Diulangi kembali');
            }
          });
        }
      }

      function closeModalEdit() 
      {
        $("#bank_name").val('');
        $("#bank_number").val('');
        $("#account_holder_bank").val('');
        $("#editBank").modal('hide');
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
            $("#tabulator-html-filter-field").val("bank_name");
            $("#tabulator-html-filter-type").val("like");
            $("#tabulator-html-filter-value").val("");
            filterHTMLForm();
        });
    </script>
@endsection