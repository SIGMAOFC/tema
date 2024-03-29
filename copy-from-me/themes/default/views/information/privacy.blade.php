@extends('layouts.information')

@section('content')
  <x-container title="Privacy Policy">

    <x-card title="">
      @include('information.privacy-content')
    </x-card>
  </x-container>
@endsection
