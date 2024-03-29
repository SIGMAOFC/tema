@extends('layouts.main')

@section('content')
  <x-container title="Useful Links">

    <x-card>
      <form action="{{ route('admin.usefullinks.update', $link->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <x-validation-errors :errors="$errors" />

        <x-label title="Icon Class Name">
          <x-input value="{{ $link->icon }}" id="icon" name="icon" type="text" placeholder="fas fa-user"
            type="text" required></x-input>
          <x-slot name="text">
            {{ __('You can find available free icons') }} <a class="text-purple-600 underline" target="_blank"
              href="https://icon-sets.iconify.design/">here.</a> Example: <code
              class="bg-gray-600/50 text-gray-400 rounded p-1">simple-icons:discord</code>
          </x-slot>
        </x-label>

        <x-label title="Title">
          <x-input value="{{ $link->title }}" id="title" name="title" type="text" type="text"
            required></x-input>
        </x-label>

        <x-label title="Link">
          <x-input value="{{ $link->link }}" id="link" name="link" type="text" type="text"
            required></x-input>
        </x-label>

        <x-label title="Description">
          <x-textarea id="description" name="description">{{ $link->description }}
          </x-textarea>
        </x-label>

        <x-label title="Position">
          <x-select name='position[]' id="position" autocomplete="off" required multiple class="custom-select">
            @foreach ($positions as $position)
              <option id="{{ $position->value }}" value="{{ $position->value }}"
                @if (strpos($link->position, $position->value) !== false) selected @endif>
                {{ __($position->value) }}
              </option>
            @endforeach
          </x-select>
        </x-label>

        <x-button type='submit'>{{ __('Submit') }}</x-button>
      </form>

    </x-card>

  </x-container>

  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
      // Summernote
      $('#description').jqte({
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
      });
      $('[data-toggle="popover"]').popover();
      $('.custom-select').select2();
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
