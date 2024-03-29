@extends('layouts.main')

@section('content')
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      {{ __('Product Checkout') }}
    </h2>
    <form x-data="{ payment_method: '{{ isset($paymentGateways[0]) ? $paymentGateways[0]->name : '' }}', clicked: false }" x-ref="form" action="{{ route('payment.pay') }}" method="POST" class="overflow-x-auto">
      @csrf
      @method('post')

      <div class="">
        <h4 class="flex justify-between">
          <span>{{ config('app.name', 'Laravel') }}</span>
          <span class="float-right">{{ __('Date') }}:
            {{ Carbon\Carbon::now()->isoFormat('LL') }}</span>
        </h4>
      </div>
      <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="py-3 px-6">
                {{ __('Quantity') }}
              </th>
              <th scope="col" class="py-3 px-6">
                {{ __('Product') }}
              </th>
              <th scope="col" class="py-3 px-6">
                {{ __('Description') }}
              </th>
              <th scope="col" class="py-3 px-6">
                {{ __('Subtotal') }}
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
              <th scope="row" class="py-4 px-6 font-medium whitespace-nowrap">
                1
              </th>
              <td class="py-4 px-6">
                {{ $product->quantity }}
                {{ strtolower($product->type) == 'credits' ? CREDITS_DISPLAY_NAME : $product->type }}
              </td>
              <td class="py-4 px-6">
                {{ $product->description }}
              </td>
              <td class="py-4 px-6">{{ $product->formatToCurrency($product->price) }}
              </td>
            </tr>
          </tbody>
        </table>
        <input type="hidden" name="product_id" value="{{ $product->id }}">
      </div>
      <div class="my-4 p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">

        <div class="grid gap-6 sm:grid-cols-2 ">
          @if (!$productIsFree)
            <div class="w-full overflow-hidden">
              <h2 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200 flex justify-between items-center">
                {{ __('Payment Methods') }}:
              </h2>
              <div class="mb-4 grid sm:grid-cols-2 gap-6">
                @foreach ($paymentGateways as $gateway)
                  <div class="">
                    <label class="inline-flex flex-col items-center text-gray-600 dark:text-gray-400 relative"
                      for="{{ $gateway->name }}">
                      <img class="w-44 " src="{{ $gateway->image }}" alt="{{ $gateway->name }} logo">
                      <div class="inline-flex items-center">
                        <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 "
                          x-on:click="clicked = false" x-model="payment_method" id="{{ $gateway->name }}"
                          value="{{ $gateway->name }}" name="payment_method">
                        <span class="ml-2 font-bold text-lg dark:text-gray-200 text-gray-800">{{ $gateway->name }}</span>
                      </div>
                    </label>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          <div class="w-full overflow-hidden">
            <h2 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200 flex justify-between items-center">
              <span>{{ __('Amount Due') }}</span>
              <span class="text-sm text-gray-500">
                Date: {{ Carbon\Carbon::now()->isoFormat('LL') }}
              </span>
            </h2>
            <div class="w-full overflow-x-auto rounded-lg shadow-sm ">
              <table class="w-full whitespace-no-wrap text-left">
                @if ($discountpercent && $discountvalue)
                  <tr>
                    <th class="px-4 py-3 font-semibold">{{ __('Discount') }} ({{ $discountpercent }}%):</th>
                    <td class="px-4 py-3">{{ $product->formatToCurrency($discountvalue) }}</td>
                  </tr>
                @endif
                <tr>
                  <th class="px-4 py-3 font-semibold">{{ __('Subtotal') }}:</th>
                  <td class="px-4 py-3">{{ $product->formatToCurrency($discountedprice) }}</td>
                </tr>
                <tr>
                  <th class="px-4 py-3 font-semibold">{{ __('Tax') }} ({{ $taxpercent }}%)</th>
                  <td class="px-4 py-3">{{ $product->formatToCurrency($taxvalue) }}</td>
                </tr>
                <tr>
                  <th class="px-4 py-3 font-semibold">{{ __('Total') }}:</th>
                  <td class="px-4 py-3">{{ $product->formatToCurrency($total) }}</td>
                </tr>
              </table>
            </div>
            <button type="submit" :disabled="(!payment_method || clicked) && {{ !$productIsFree }}"
              :class="(!payment_method || clicked) && {{ !$productIsFree }} ? 'disabled' : ''" @click="clicked = true"
              x-on:click="clicked = true; $refs.form.submit()"
              class="print:hidden mt-28 inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800 disabled:bg-purple-500 disabled:dark:bg-purple-800 disabled:cursor-not-allowed">
              @if ($productIsFree)
                {{ __('Get for free') }}
              @else
                {{ __('Submit Payment') }}
              @endif
              <svg aria-hidden="true" class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
              </svg>
            </button>
          </div>
        </div>
    </form>
  </div>
  </div>
@endsection
