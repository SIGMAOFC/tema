@extends('layouts.main')

@section('content')
  <x-container title="Edit Server">

    <x-alert title="Only edit these settings if you know exactly what you are doing" type="danger">
      {{ __('You usually do not need to change anything here') }}
    </x-alert>

    <x-card>
      <form action="{{ route('admin.servers.update', $server->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <x-validation-errors :errors="$errors" />

        <x-label title="Server Identifier">
          <x-input value="{{ $server->identifier }}" id="identifier" name="identifier" type="text"></x-input>
        </x-label>

        <x-button type='submit'>{{ __('Submit') }}</x-button>
      </form>

    </x-card>

  </x-container>
@endsection
