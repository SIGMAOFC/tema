@extends('layouts.main')

@section('content')
  <x-container title="Legal">
    <form method="POST" enctype="multipart/form-data" class="mb-3" action="{{ route('admin.legal.update') }}">
      @csrf
      @method('PATCH')

      <x-card title="">

        <x-label title="Terms Of Service">
          <x-textarea name="tos" id="textarea">{{ $tos }}</x-textarea>
        </x-label>

        <x-label title="Privacy Policy">
          <x-textarea name="privacy" id="textarea">{{ $privacy }}</x-textarea>
        </x-label>

        <x-label title="Imprint">
          <x-textarea name="imprint" id="textarea">{{ $imprint }}</x-textarea>
        </x-label>

        <x-button type="submit">{{ __('Save') }}</x-button>

      </x-card>
    </form>
  </x-container>

  <script>
    tinymce.init({
      selector: 'textarea',
      skin: "Phoenix",
      promotion: false,
      // content_css: "Phoenix",
      skin_url: "/css/tinymce",
      body_class: 'tinymce-phoenix',
      branding: false,
      height: 500,
      plugins: ['image', 'link'],
    });
  </script>
@endsection
