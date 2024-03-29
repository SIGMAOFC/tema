@extends('layouts.main')

@section('content')
  <x-container title="Notify Users">

    <x-card>
      <form action="{{ route('admin.users.notifications') }}" method="POST">
        @csrf
        @method('POST')

        <x-validation-errors :errors="$errors" />

        <x-checkbox title="All Users" value="1" id="all" name="all"
          onchange="toggleClass('users-form', 'hidden')">
        </x-checkbox>

        <div id="users-form">
          <x-label title="Select Users">
            <select id="users" name="users[]" class="form-control" multiple></select>
          </x-label>
        </div>

        <x-label title="Send Via">
          <x-checkbox title="Database" value="database" id="via[]" name="via[]"></x-checkbox>
          <x-checkbox title="Email" value="mail" id="via[]" name="via[]"></x-checkbox>
        </x-label>

        <x-label title="Title">
          <x-input value="{{ old('title') }}" id="title" name="title" type="text"></x-input>
        </x-label>

        <x-label title="Content">
          <x-textarea id="content" name="content" type="content">
            {{ old('content') }}</x-textarea>
        </x-label>

        <x-button type='submit'>{{ __('Submit') }}</x-button>
      </form>

    </x-card>

  </x-container>

  <script>
    function toggleClass(id, className) {
      document.getElementById(id).classList.toggle(className)
    }
    document.addEventListener('DOMContentLoaded', (event) => {
      // Summernote
      $('#content').jqte({
        height: 100,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript',
            'subscript', 'clear'
          ]],
          ['fontname', ['fontname']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ol', 'ul', 'paragraph', 'height']],
          ['table', ['table']],
          ['insert', ['link']],
          ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
        ]
      })

      function initUserSelect(data) {
        $('#users').select2({
          dropdownAutoWidth: true,
          width: '100%',
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
          minimumInputLength: 2,
          templateResult: function(data) {
            if (data.loading) return data.text;
            const $container = $(
              "<div class='select2-result-users clearfix' style='display:flex;'>" +
              "<div class='select2-result-users__avatar' style='display:flex;align-items:center;'><img class='img-circle img-bordered-s' src='" +
              data.avatarUrl + "?s=40' /></div>" +
              "<div class='select2-result-users__meta' style='margin-left:10px'>" +
              "<div class='select2-result-users__username' style='font-size:16px;'></div>" +
              "<div class='select2-result-users__email' style='font-size=13px;'></div>" +
              "</div>" +
              "</div>"
            );

            $container.find(".select2-result-users__username").text(data.name);
            $container.find(".select2-result-users__email").text(data.email);

            return $container;
          },
          templateSelection: function(data) {
            $container = $(
              '<div> \
                                                                                                                                                                <span> \
                                                                                                                                                                    <img class="img-rounded img-bordered-xs" src="' +
              data
              .avatarUrl +
              '?s=120" style="height:24px;margin-top:-4px;" alt="User Image"> \
                                                                                                                                                                </span> \
                                                                                                                                                                <span class="select2-selection-users__username" style="padding-left:10px;padding-right:10px;"></span> \
                                                                                                                                                            </div>'
            );
            $container.find(".select2-selection-users__username").text(data.name);
            return $container;
          }
        })
      }
      initUserSelect()
    })
  </script>
@endsection

@section('head')
  <link rel="stylesheet" href="{{ asset('css/jquery-te-1.4.0.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
  <script src="{{ asset('js/jquery-te-1.4.0.min.js') }}"></script>
  <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
@endsection
