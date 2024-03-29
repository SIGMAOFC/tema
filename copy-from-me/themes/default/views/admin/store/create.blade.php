@extends('layouts.main')
@section('content')
  <x-container title="Store">

    <x-card>
      <form action="{{ route('admin.store.store') }}" method="POST">
        @csrf
        <x-validation-errors :errors="$errors" />

        <x-label title="Type">
          <select required name="type" id="type"
            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
            <option selected value="Credits">
              {{ CREDITS_DISPLAY_NAME }}</option>
            <option value="Server slots">
              {{ __('Server Slots') }}</option>
          </select>
        </x-label>
        <x-label title="Currency Code">
          <select required name="currency_code" id="currency_code"
            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
            @foreach ($currencyCodes as $code)
              <option @if ($code == 'EUR') selected @endif value="{{ $code }}">
                {{ $code }}</option>
            @endforeach
          </select>
          <x-slot name="text">
            {{ __('Checkout the paypal docs to select the appropriate code') }} <a target="_blank"
              href="https://developer.paypal.com/docs/api/reference/currency-codes/">link</a>
          </x-slot>
        </x-label>

        <x-label title="Price">
          <x-input value="{{ old('price') }}" id="price" name="price" type="number" placeholder="10.00"
            step="any"></x-input>
        </x-label>
        <x-label title="Quantity">
          <x-input value="{{ old('quantity') }}" id="quantity" name="quantity" type="number" placeholder="1000">
          </x-input>
          <x-slot name="text">{{ __('Amount given to the user after purchasing') }}</x-slot>
        </x-label>
        <x-label title="Display">
          <x-input value="{{ old('display') }}" id="display" name="display" type="text"
            placeholder="750 + 250"></x-input>
          <x-slot name="text">
            {{ __('This is what the user sees at store and checkout') }}
          </x-slot>
        </x-label>
        <x-label title="Description">
          <x-input value="{{ old('description') }}" id="description" name="description" type="text"
            placeholder="{{ __('Adds 1000 credits to your account') }}"></x-input>
          <x-slot name="text">
            {{ __('This is what the user sees at checkout') }}
          </x-slot>
        </x-label>

        <x-button type='submit'>{{ __('Submit') }}</x-button>
      </form>

    </x-card>

  </x-container>
@endsection
