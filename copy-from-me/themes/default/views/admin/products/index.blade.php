@extends('layouts.main')
@section('head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />
@endsection

@section('scripts')
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script>
@endsection


@section('content')
  <x-container title="Products" btnLink="{{ route('admin.products.create') }}" btnText="Create">

    <div class="w-full overflow-hidden rounded-lg">
      <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap" id="datatable">
          <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

              <th class="px-4 py-3">{{ __('Enabled') }}</th>
              <th class="px-4 py-3">{{ __('Name') }}</th>
              <th class="px-4 py-3">{{ __('Price') }}</th>
              <th class="px-4 py-3">{{ __('Memory') }}</th>
              <th class="px-4 py-3">{{ __('Cpu') }}</th>
              <th class="px-4 py-3">{{ __('Swap') }}</th>
              <th class="px-4 py-3">{{ __('Disk') }}</th>
              <th class="px-4 py-3">{{ __('Databases') }}</th>
              <th class="px-4 py-3">{{ __('Backups') }}</th>
              <th class="px-4 py-3">{{ __('Nodes') }}</th>
              <th class="px-4 py-3">{{ __('Eggs') }}</th>
              <th class="px-4 py-3">{{ __('Servers') }}</th>
              <th class="px-4 py-3">{{ __('Created') }}</th>
              <th class="px-4 py-3">{{ __('Actions') }}</th>

            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            {{-- <template x-for="product in products" x-init="fetchProducts()">
                        <tr class="text-gray-700 dark:text-gray-400 text-center">
                            <td x-html="product.disabled"></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold" x-text="product.name"></p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400"
                                            x-text="product.description">

                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm" x-text="product.price">
                            </td>
                            <td class="px-4 py-3 text-sm" x-text="product.memory">
                            </td>
                            <td class="px-4 py-3 text-sm" x-text="product.cpu">
                            </td>
                            <td class="px-4 py-3 text-sm" x-text="product.swap">
                            </td>
                            <td class="px-4 py-3 text-sm" x-text="product.disk">
                            </td>
                            <td class="px-4 py-3 text-sm" x-text="product.databases">
                            </td>
                            <td class="px-4 py-3 text-sm" x-text="product.backups">
                            </td>
                            <td class="px-4 py-3 text-sm" x-text="product.nodes">
                            </td>
                            <td class="px-4 py-3 text-sm" x-text="product.eggs">
                            </td>
                            <td class="px-4 py-3 text-sm" x-text="product.servers">
                            </td>
                            <td class="px-4 py-3 text-sm" x-text="product.created_at">
                            </td>
                            <td class="px-4 py-3" x-html="product.actions">

                            </td>
                        </tr>
                    </template> --}}

          </tbody>
        </table>
      </div>
      <x-pagination></x-pagination>

    </div>
  </x-container>

  <script>
    function submitResult() {
      return confirm("{{ __('Are you sure you wish to delete?') }}") !== false;
    }

    document.addEventListener("DOMContentLoaded", function() {
      window.table = $('#datatable').DataTable({
        language: {
          url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/{{ config('SETTINGS::LOCALE:DATATABLES') }}.json'
        },
        processing: true,
        serverSide: true, //increases loading times too much? change back to "true" if it does
        stateSave: true,
        order: [
          [2, "asc"]
        ],
        paging: true,
        // scrollX: false,
        bInfo: true,
        columnDefs: [{
          className: "px-4 py-3",
          "targets": "_all"
        }],
        ajax: "{{ route('admin.products.datatable') }}",
        columns: [{
            data: "disabled"
          },
          {
            data: "name"
          },
          {
            data: "price"
          },
          {
            data: "memory"
          },
          {
            data: "cpu"
          },
          {
            data: "swap"
          },
          {
            data: "disk"
          },
          {
            data: "databases"
          },
          {
            data: "backups"
          },
          {
            data: "nodes",
            sortable: false
          },
          {
            data: "eggs",
            sortable: false
          },
          {
            data: "servers",
            sortable: false
          },
          {
            data: "created_at"
          },
          {
            data: "actions",
            sortable: false
          }
        ],
        fnDrawCallback: function(oSettings) {
          $('[data-toggle="popover"]').popover();
        }
      });
      table.on('init.dt', function() {
        console.log('Table initialisation complete: ' + new Date().getTime());
        const label = $("#datatable_length > label")
        label.contents().filter(function() {
          return this.nodeType == 3
        }).remove()
        label.addClass("block mb-4 font-medium text-sm text-gray-700")
        let span =
          `<span class="text-gray-700 dark:text-gray-400">{{ __('Show Per Page') }}</span>`
        $("#datatable_length > label > select").before(span)
      })
    });
  </script>
  <x-page_script></x-page_script>
@endsection
