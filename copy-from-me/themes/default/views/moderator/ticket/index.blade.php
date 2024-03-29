@extends('layouts.main')

@section('head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />
@endsection

@section('scripts')
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script>
@endsection

@section('content')
  <x-container title="Tickets" btnLink="{{ route('moderator.ticket.category.index') }}" btnText="Add Category">
    <div class="w-full overflow-hidden rounded-lg ">
      <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap" id="datatable">
          <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

              <th class="px-4 py-3">{{ __('Title') }}</th>
              <th class="px-4 py-3">{{ __('Category') }}</th>
              <th class="px-4 py-3">{{ __('User') }}</th>
              <th class="px-4 py-3">{{ __('Status') }}</th>
              <th class="px-4 py-3">{{ __('Last Updated') }}</th>
              <th class="px-4 py-3">{{ __('Actions') }}</th>

            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
          </tbody>
        </table>
      </div>
      <x-pagination></x-pagination>
    </div>
  </x-container>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      window.table = $('#datatable').DataTable({
        language: {
          url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/{{ config('SETTINGS::LOCALE:DATATABLES') }}.json'
        },
        processing: true,
        serverSide: true,
        stateSave: true,
        ajax: "{{ route('moderator.ticket.datatable') }}",
        paging: true,
        // scrollX: false,
        bInfo: true,
        columnDefs: [{
          className: "px-4 py-3",
          "targets": "_all"
        }],
        columns: [{
            data: 'title',
          },
          {
            data: 'category'
          },
          {
            data: 'user_id'
          },
          {
            data: 'status'
          },
          {
            data: 'updated_at',
            type: 'num',
            render: {
              _: 'display',
              sort: 'raw'
            }
          },
          {
            data: 'actions',
            sortable: false
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
