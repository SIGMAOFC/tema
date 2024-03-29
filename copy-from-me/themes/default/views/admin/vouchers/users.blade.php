@extends('layouts.main')

@section('content')
  <x-container title="Users">

    <x-card>
      <div class="w-full overflow-hidden rounded-lg">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap" id="datatable">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-600 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

                <th class="px-4 py-3">{{ __('ID') }}</th>
                <th class="px-4 py-3">{{ __('Name') }}</th>
                <th class="px-4 py-3">{{ __('Email') }}</th>
                <th class="px-4 py-3">{{ CREDITS_DISPLAY_NAME }}</th>
                <th class="px-4 py-3">{{ __('Last seen') }}</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y-2 dark:divide-gray-700 dark:bg-gray-800">

            </tbody>
          </table>
        </div>
      </div>
    </x-card>
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
        ajax: "{{ route('admin.vouchers.usersdatatable', $voucher->id) }}",
        paging: true,
        // scrollX: false,
        bInfo: true,
        columnDefs: [{
          className: "px-4 py-3",
          "targets": "_all"
        }],
        columns: [{
            data: 'id'
          }, {
            data: 'name'
          },
          {
            data: 'email'
          },
          {
            data: 'credits'
          },
          {
            data: 'last_seen'
          },
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
@section('head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />
@endsection

@section('scripts')
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script>
@endsection
