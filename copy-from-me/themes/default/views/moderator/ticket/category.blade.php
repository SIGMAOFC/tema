@extends('layouts.main')

@section('content')
  <x-container title="Ticket Categories">

    <x-card title="">
      <div class="w-full overflow-hidden rounded-lg ">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap" id="datatable">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

                <th class="px-4 py-3">{{ __('ID') }}</th>
                <th class="px-4 py-3">{{ __('Name') }}</th>
                <th class="px-4 py-3">{{ __('Tickets') }}</th>
                <th class="px-4 py-3">{{ __('Created At') }}</th>
                <th class="px-4 py-3">{{ __('Actions') }}</th>

              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            </tbody>
          </table>
        </div>
        <x-pagination></x-pagination>
      </div>
    </x-card>

    <x-card title="Add Category">

      <form action="{{ route('moderator.ticket.category.store') }}" method="POST">
        @csrf
        <x-label title="Name">
          <x-input name="name" required />
        </x-label>
        <x-button type="Submit">{{ __('Submit') }}</x-button>
      </form>

    </x-card>

    <x-card title="Edit Category">

      <form action="{{ route('moderator.ticket.category.update', '1') }}" method="POST">
        @csrf
        @method('PATCH')

        <x-label title="Category">
          <x-select id="category" name="category" required autocomplete="off">
            @foreach ($categories as $category)
              <option value="{{ $category->id }}">{{ __($category->name) }}</option>
            @endforeach
          </x-select>
        </x-label>

        <x-label title="New Name">
          <x-input name="name" required />
        </x-label>
        <x-button type="Submit">{{ __('Submit') }}</x-button>
      </form>

    </x-card>



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
        ajax: "{{ route('moderator.ticket.category.datatable') }}",
        paging: true,
        // scrollX: false,
        bInfo: true,
        columnDefs: [{
          className: "px-4 py-3",
          "targets": "_all"
        }],
        columns: [{
            data: 'id'
          },
          {
            data: 'name'
          },
          {
            data: 'tickets'
          },
          {
            data: 'created_at',
            sortable: false
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


@section('head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />
@endsection

@section('scripts')
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script>
@endsection
