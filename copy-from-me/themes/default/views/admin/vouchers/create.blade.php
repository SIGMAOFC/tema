@extends('layouts.main')

@section('content')
  <x-container title="Vouchers Details">

    <x-card>
      <form action="{{ route('admin.vouchers.store') }}" method="POST">
        @csrf

        <x-validation-errors :errors="$errors" />

        <x-label title="Memo">
          <x-input value="{{ old('memo') }}" placeholder="{{ __('Summer break voucher') }}" id="memo" name="memo"
            type="text"></x-input>
          @slot('text')
            {{ __('Only admins can see this') }}
          @endslot
        </x-label>
        <x-label title="{{ CREDITS_DISPLAY_NAME }} *">
          <x-input value="{{ old('credits') }}" placeholder="500" id="credits" name="credits" type="number"
            step="any" min="0" max="99999999"></x-input>
        </x-label>
        <x-label title="Code">
          <x-input value="{{ old('code') }}" placeholder="SUMMER" id="code" name="code" type="text">
            <x-button onclick="setRandomCode()" type="button" size="normal">
              {{ __('Random') }}
            </x-button>
          </x-input>
        </x-label>
        <x-label title="Uses">
          <x-input type="number" value="{{ old('uses') }}" id="uses" min="1" max="2147483647"
            name="uses"></x-input>
          @slot('text')
            {{ __('A voucher can only be used one time per user. Uses specifies the number of different users that can use this voucher.') }}
          @endslot
        </x-label>
        <x-label title="Expires At">
          <x-input value="{{ old('expires_at') }}" name="expires_at" placeholder="dd-mm-yyyy hh:mm:ss" type="text"
            id="expires_at"></x-input>
          @slot('text')
            Timezone: {{ Config::get('app.timezone') }}
          @endslot
        </x-label>

        <x-button type='submit'>{{ __('Submit') }}</x-button>
      </form>

    </x-card>

  </x-container>



  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
      $('#expires_at').datetimepicker({
        format: 'd-m-Y H:i:s'
      });
    })

    function setMaxUses() {
      let element = document.getElementById('uses')
      element.value = element.max;
      console.log(element.max)
    }


    function setRandomCode() {
      let element = document.getElementById('code')
      element.value = getRandomCode(12)
    }

    function getRandomCode(length) {
      let result = '';
      let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-';
      let charactersLength = characters.length;
      for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
          charactersLength));
      }
      return result;
    }
  </script>
@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"
    integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('head')
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"
    integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
