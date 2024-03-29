@extends('layouts.information')

@section('content')
  <x-container title="Imprint">

    <x-card title="">
      @include('information.imprint-content')
    </x-card>
  </x-container>
@endsection
