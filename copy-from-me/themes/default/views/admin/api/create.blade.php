@extends('layouts.main')

@section('content')
  <x-container title="Application API" btnLink="{{ route('admin.api.create') }}" btnText="Create">

    <x-card>
      <form action="{{ route('admin.api.store') }}" method="POST">
        @csrf

        <x-validation-errors :errors="$errors" />

        <x-label title="Memo">
          <x-input value="{{ old('memo') }}" id="memo" name="memo" type="text"></x-input>
        </x-label>

        <x-button type='submit'>{{ __('Submit') }}</x-button>
      </form>

    </x-card>

  </x-container>
@endsection
