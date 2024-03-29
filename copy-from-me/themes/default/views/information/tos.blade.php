@extends('layouts.information')

@section('content')
  <x-container title="Terms of Service">

    <x-card title="">
      @include('information.tos-content')
    </x-card>
  </x-container>
@endsection
