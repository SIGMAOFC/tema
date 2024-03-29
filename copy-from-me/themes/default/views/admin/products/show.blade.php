@extends('layouts.main')

@section('content')
  <x-container title="Product" btnLink="{{ route('admin.products.edit', $product->id) }}" btnText="Edit">

    <x-card title="Product Information">
      <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="w-full overflow-x-auto rounded-lg shadow-sm ">
          <table class="w-full whitespace-no-wrap">
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Name') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $product->name }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('ID') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $product->id }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Price') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $product->price }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Description') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $product->description }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Minimum') }} {{ CREDITS_DISPLAY_NAME }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  @if ($product->minimum_credits == -1)
                    {{ $minimum_credits }}
                  @else
                    {{ $product->minimum_credits }}
                  @endif
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Created At') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $product->created_at ? $product->created_at->diffForHumans() : '' }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Updated At') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $product->updated_at ? $product->updated_at->diffForHumans() : '' }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="w-full overflow-x-auto rounded-lg shadow-sm ">
          <table class="w-full whitespace-no-wrap">
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Memory') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $product->memory }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('CPU') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $product->cpu }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Disk') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $product->disk }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Swap') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $product->swap }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('IO') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $product->io }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Databases') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $product->databases }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Allocations') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $product->allocations }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </x-card>
    <x-card title="Servers">
      @include('admin.servers.table', ['filter' => '?product=' . $product->id])

    </x-card>
  </x-container>
@endsection

@section('head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />
@endsection

@section('scripts')
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script>
@endsection
