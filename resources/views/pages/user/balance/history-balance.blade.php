@extends('layout.side-menu')

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">History Penggunaan Balance</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
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
            <div id="history-balance" class="mt-5 table-report table-report--tabulator"></div>
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
      var table = new Tabulator("#history-balance", {
        ajaxURL:"{{route('historyBalance')}}", //set url for ajax request
        ajaxFiltering: true,
        ajaxSorting: true,
        printAsHtml: true,
        printStyled: true,
        pagination: "remote",
        paginationSize: 10,
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
                    title: "JUMLAH",
                    minWidth: 200,
                    width: 200,
                    field: "balance_used",
                    hozAlign: "left",
                    print: true,
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div >
                            <div class="font-medium whitespace-nowrap">${
                                formatter.format(cell.getData().balance_used)
                            }</div>
                        </div>`;
                    },
                },
                {
                    title: "Deskripsi",
                    minWidth: 200,
                    width: 200,
                    field: "desc",
                    hozAlign: "center",
                    print: true,
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div >
                            <div class="font-medium whitespace-nowrap">${
                              cell.getData().desc
                            }</div>`;
                    },
                    
                },
                {
                    title: "TANGGAL PENGGUNAAN",
                    minWidth: 200,
                    width: 200,
                    field: "created",
                    hozAlign: "center",
                    print: true,
                    download: true,
                    formatter(cell, formatterParams) {
                        return `<div >
                                  <div class="font-medium">${
                                    cell.getData().created
                                  }
                                </div>`;
                        
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
        function filterHTMLForm() {
            let field = $("#tabulator-html-filter-field").val();
            let type = $("#tabulator-html-filter-type").val();
            let value = $("#tabulator-html-filter-value").val();
            table.setFilter(field, type, value);
        }

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