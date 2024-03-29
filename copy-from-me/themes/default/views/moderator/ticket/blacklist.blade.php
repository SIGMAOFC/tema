@extends('layouts.main')

@section('head')
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />
@endsection

@section('scripts')
  <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script>
@endsection

@section('content')
  <div class="container px-6 mx-auto grid">
    <div class="grid gap-6 mb-8 md:grid-cols-3">

      <div class="w-full overflow-hidden col-span-2">
        <h2 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">
          {{ __('Ticket BlackList') }}
        </h2>
        <div class="w-full overflow-hidden rounded-lg">
          <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap" id="datatable">
              <thead>
                <tr
                  class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

                  <th class="px-4 py-3">{{ __('User') }}</th>
                  <th class="px-4 py-3">{{ __('Status') }}</th>
                  <th class="px-4 py-3">{{ __('Reason') }}</th>
                  <th class="px-4 py-3">{{ __('Created At') }}</th>
                  <th class="px-4 py-3">{{ __('Actions') }}</th>

                </tr>
              </thead>
              <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="w-full overflow-hidden">
        <h2 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">
          {{ __('BlackList User') }}
        </h2>
        <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
          <form action="{{ route('moderator.ticket.blacklist.add') }}" method="POST" class="ticket-form"
            x-init="$nextTick(() => { window.sel.update(); })">
            @csrf
            <x-label title="User">
              <select id="user_id" style="width:100%" class="custom-select" name="user_id" required autocomplete="off"
                @error('user_id') is-invalid @enderror>
              </select>
            </x-label>
            <x-label title="Reason">
              <x-input id="reason" type="text" name="reason" placeholder="Input Some Reason" required>
              </x-input>
              @slot('text')
                {{ __('Please note, the blacklist will make the user unable to make a ticket/reply again') }}
              @endslot
            </x-label>

            <x-button>{{ __('Ban') }}</x-button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      window.table = $('#datatable').DataTable({
        language: {
          url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/{{ config('SETTINGS::LOCALE:DATATABLES') }}.json'
        },
        processing: true,
        serverSide: true,
        stateSave: true,
        ajax: "{{ route('moderator.ticket.blacklist.datatable') }}",
        paging: true,
        // scrollX: false,
        bInfo: true,
        columnDefs: [{
          className: "px-4 py-3",
          "targets": "_all"
        }],
        columns: [{
            data: 'user',
            name: 'user.name'
          },
          {
            data: 'status'
          },
          {
            data: 'reason'
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

    function initUserIdSelect(data) {
      function escapeHtml(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
      }

      $('#user_id').select2({
        ajax: {
          url: '/admin/users.json',
          dataType: 'json',
          delay: 250,

          data: function(params) {
            return {
              filter: {
                email: params.term
              },
              page: params.page,
            };
          },

          processResults: function(data, params) {
            return {
              results: data
            };
          },

          cache: true,
        },

        data: data,
        escapeMarkup: function(markup) {
          return markup;
        },
        minimumInputLength: 2,
        templateResult: function(data) {
          if (data.loading) return escapeHtml(data.text);

          return '<div class="user-block"> \
                                                                                                          <img class="img-circle img-bordered-xs" src="' +
            escapeHtml(
              data
              .avatarUrl) + '?s=120" alt="User Image"> \
                                              <span class="username"> \
                                                  <a href="#">' + escapeHtml(data
              .name) +
            '</a> \
                                                                                                          </span> \
                                                                                                          <span class="description"><strong>' +
            escapeHtml(
              data
              .email) +
            '</strong>' + '</span> \
                                          </div>';
        },
        templateSelection: function(data) {
          return '<div> \
                                          <span> \
                                                                                                              <img class="img-rounded img-bordered-xs" src="' +
            escapeHtml(
              data
              .avatarUrl) + '?s=120" style="height:28px;margin-top:-4px;" alt="User Image"> \
                                                                                                          </span> \
                                                                                                          <span style="padding-left:5px;"> \
                                                                                                              ' +
            escapeHtml(
              data
              .name) +
            ' (<strong>' +
            escapeHtml(
              data
              .email) + '</strong>) \
                                                                                                          </span> \
                                                                                                          </div>';
        }

      });
    }

    $(document).ready(function() {
      @if (old('user_id'))
        $.ajax({
          url: '/admin/users.json?user_id={{ old('user_id') }}',
          dataType: 'json',
        }).then(function(data) {
          initUserIdSelect([data]);
        });
      @else
        initUserIdSelect();
      @endif
    });
  </script>
  <x-page_script></x-page_script>
@endsection
