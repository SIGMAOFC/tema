@extends('layouts.main')

@section('content')
  <div class="container px-6 mx-auto grid">

    <div class="flex justify-between py-6">

      <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
        {{ __('Users') }}
      </h2>
      <a title="Notify users!"
        class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md focus:shadow-outline-purple active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple focus:outline-none"
        href="{{ route('admin.users.notifications') }}">{{ __('Notify') }}</a>
    </div>
    <div class="w-full overflow-hidden rounded-lg">
      <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap" id="datatable">
          <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-600 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <th class="px-4 py-3">discordId</th>
              <th class="px-4 py-3">ip</th>
              <th class="px-4 py-3">pterodactyl_id</th>
              <th class="px-4 py-3">{{ __('Avatar') }}</th>
              <th class="px-4 py-3">{{ __('Name') }}</th>
              <th class="px-4 py-3">{{ __('Role') }}</th>
              <th class="px-4 py-3">{{ __('Email') }}</th>
              <th class="px-4 py-3">{{ CREDITS_DISPLAY_NAME }}</th>
              <th class="px-4 py-3">{{ __('Servers') }}</th>
              <th class="px-4 py-3">{{ __('Referrals') }}</th>
              <th class="px-4 py-3">{{ __('Verified') }}</th>
              <th class="px-4 py-3">{{ __('Last seen') }}</th>
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
    function submitResult() {
      return confirm("{{ __('Are you sure you wish to delete?') }}") !== false;
    }

    document.addEventListener("DOMContentLoaded", function() {
      window.table = window.table = $('#datatable').DataTable({
        language: {
          url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/{{ config('SETTINGS::LOCALE:DATATABLES') }}.json'
        },
        processing: true,
        serverSide: true,
        stateSave: true,
        ajax: "{{ route('admin.users.datatable') }}",
        order: [
          [11, "asc"]
        ],
        paging: true,
        bInfo: true,
        columnDefs: [{
          className: "px-4 py-3",
          "targets": "_all"
        }],
        columns: [{
            data: 'discordId',
            visible: false,
            name: 'discordUser.id'
          },
          {
            data: 'pterodactyl_id',
            visible: false
          },
          {
            data: 'ip',
            visible: false
          },
          {
            data: 'avatar',
            sortable: false
          },
          {
            data: 'name'
          },
          {
            data: 'role'
          },
          {
            data: 'email',
            name: 'users.email'
          },
          {
            data: 'credits',
            name: 'users.credits'
          },
          {
            data: 'servers_count',
            searchable: false
          },
          {
            data: 'referrals_count',
            searchable: false
          },
          {
            data: 'verified',
            sortable: false
          },
          {
            data: 'last_seen',
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
