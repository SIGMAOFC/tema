@extends('layouts.main')
@section('head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />
@endsection

@section('scripts')
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script>
@endsection


@section('content')
  <div class="container px-6 mx-auto grid">

    <div class="flex justify-between py-6">

      <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
        {{ __('Payments') }}
      </h2>
      <a class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md focus:shadow-outline-purple active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple focus:outline-none"
        href="{{ route('admin.invoices.downloadAllInvoices') }}">{{ __('Download all Invoices') }}</a>
    </div>
    <div class="w-full overflow-hidden rounded-lg">
      <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap" id="datatable">
          <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-600 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <th class="px-4 py-3">{{ __('ID') }}</th>
              <th class="px-4 py-3">{{ __('Type') }}</th>
              <th class="px-4 py-3">{{ __('Amount') }}</th>
              <th class="px-4 py-3">{{ __('Product Price') }}</th>
              <th class="px-4 py-3">{{ __('Tax Value') }}</th>
              <th class="px-4 py-3">{{ __('Tax Percentage') }}</th>
              <th class="px-4 py-3">{{ __('Total Price') }}</th>
              <th class="px-4 py-3">{{ __('User') }}</th>
              <th class="px-4 py-3">{{ __('Payment ID') }}</th>
              <th class="px-4 py-3">{{ __('Payment Method') }}</th>
              <th class="px-4 py-3">{{ __('Created At') }}</th>
              <th class="px-4 py-3">{{ __('Actions') }}</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y-2 dark:divide-gray-700 dark:bg-gray-800">

          </tbody>
        </table>
      </div>
      <x-pagination></x-pagination>

    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      window.table = $('#datatable').DataTable({
        language: {
          url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/{{ config('SETTINGS::LOCALE:DATATABLES') }}.json'
        },
        processing: true,
        serverSide: true, //increases loading times too much? change back to "true" if it does
        stateSave: true,
        ajax: "{{ route('admin.payments.datatable') }}",
        paging: true,
        // scrollX: false,
        bInfo: true,
        columnDefs: [{
          className: "px-4 py-3",
          "targets": "_all"
        }],
        order: [
          [9, "desc"]
        ],
        columns: [{
            data: 'id',
            name: 'payments.id'
          },
          {
            data: 'type'
          },
          {
            data: 'amount'
          },
          {
            data: 'price'
          },
          {
            data: 'tax_value'
          },
          {
            data: 'tax_percent'
          },
          {
            data: 'total_price'
          },
          {
            data: 'user'
          },
          {
            data: 'payment_id'
          },
          {
            data: 'payment_method'
          },
          {
            data: 'created_at',
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
