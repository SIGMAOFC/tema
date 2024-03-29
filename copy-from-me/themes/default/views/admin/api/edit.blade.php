@extends('layouts.main')

@section('content')
  <x-container title="Application API">
    <x-card>
      <form action="{{ route('admin.api.update', $applicationApi->token) }}" method="POST">
        @csrf
        @method('PATCH')

        <x-validation-errors :errors="$errors" />

        <x-label title="Memo">
          <x-input value="{{ $applicationApi->memo }}" id="memo" name="memo" type="text"></x-input>
        </x-label>

        <x-button type='submit'>{{ __('Submit') }}</x-button>
      </form>
    </x-card>
  </x-container>
@endsection
