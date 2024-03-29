@extends('layouts.main')

@section('content')
  <x-container title="Server Settings">
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">

      <div class="flex items-center p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
        <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
          <!-- heroicons icon -->
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01">
            </path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            {{ __('Server Name') }}
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $server->name }}
          </p>
        </div>
      </div>

      <div class="flex items-center p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z">
            </path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            CPU
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            @if ($server->product->cpu == 0)
              {{ __('Unlimited') }}
            @else
              {{ $server->product->cpu }} %
            @endif
          </p>
        </div>
      </div>

      <div class="flex items-center p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Memory
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            @if ($server->product->memory == 0)
              {{ __('Unlimited') }}
            @else
              {{ $server->product->memory }}MB
            @endif
          </p>
        </div>
      </div>

      <div class="flex items-center p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
        <div class="p-3 mr-4 text-violet-500 bg-violet-100 rounded-full dark:text-violet-100 dark:bg-violet-500">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z">
            </path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            STORAGE
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            @if ($server->product->disk == 0)
              {{ __('Unlimited') }}
            @else
              {{ $server->product->disk }}MB
            @endif
          </p>
        </div>
      </div>
    </div>

    <x-card title="Server Information">
      <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="w-full overflow-x-auto rounded-lg shadow-sm ">
          <table class="w-full whitespace-no-wrap">
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Server ID') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $server->id }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Pterodactyl ID') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $server->identifier }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Hourly Price') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ number_format($server->product->getHourlyPrice(), 2, '.', '') }}
                  {{ CREDITS_DISPLAY_NAME }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Monthly Price') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $server->product->getHourlyPrice() * 24 * 30 }} {{ CREDITS_DISPLAY_NAME }}
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
                      {{ __('Location') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $server->location }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Node') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $server->node }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Backups') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $server->product->backups }}
                </td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('MySQL Database') }}
                    </p>
                  </div>
                </td>

                <td class="px-4 py-3 text-sm">
                  {{ $server->product->databases }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      @if (config('SETTINGS::SYSTEM:ENABLE_UPGRADE'))
        <x-modal title="{{ __('Upgrade/Downgrade Server') }}" btnTitle="{{ __('Upgrade / Downgrade') }}"
          btnClass=" mr-4 bg-purple-600 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
          @slot('content')
            <strong>{{ __('FOR DOWNGRADE PLEASE CHOOSE A PLAN BELOW YOUR PLAN') }}</strong>
            <br>
            <br>
            <strong>{{ __('YOUR PRODUCT') }} : </strong> {{ $server->product->name }}
            <br>
            <br>

            <form action="{{ route('servers.upgrade', ['server' => $server->id]) }}" method="POST" class="upgrade-form"
              id="upgrade-form">
              @csrf

              <x-select name="product_upgrade" id="product_upgrade">
                <option value="">{{ __('Select the product') }}</option>
                @foreach ($products as $product)
                  @if (in_array($server->egg, $product->eggs) && $product->id != $server->product->id)
                    <option value="{{ $product->id }}" @if ($product->doesNotFit) disabled @endif>
                      {{ $product->name }} [ {{ CREDITS_DISPLAY_NAME }} {{ $product->price }} ]
                      @if ($product->doesNotFit)
                        {{ __('Server can´t fit on this node') }}
                      @else
                        @if ($product->minimum_credits != -1)
                          /
                          {{ __('Required') }}: {{ $product->minimum_credits }}
                          {{ CREDITS_DISPLAY_NAME }}
                        @endif
                      @endif
                    </option>
                  @endif
                @endforeach

              </x-select>
              <br>
              {{ __('Once the Upgrade button is pressed, we will automatically deduct the amount for the first hour according to the new product from your credits') }}.
              <br>{{ __('Server will be automatically restarted once upgraded') }}
            </form>
          @endslot

          @slot('buttons')
            <x-button
              class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
              type="button" onclick="document.querySelector('#upgrade-form').submit()">
              {{ __('Change Product') }}
            </x-button>
          @endslot
        </x-modal>
      @endif
      <x-modal title="{{ __('Are you sure?') }}" btnTitle="Delete"
        btnClass="bg-red-600 active:bg-red-600 hover:bg-red-700 focus:shadow-outline-red">
        @slot('content')
          {{ __('This is an irreversible action, all files of this server will be removed.') }}
        @endslot
        @slot('buttons')
          <form method="post" action="{{ route('servers.destroy', ['server' => $server->id]) }}">
            @csrf
            @method('DELETE')
            <x-button
              class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red"
              type="submit">
              {{ __('Delete') }}
            </x-button>
          </form>
        @endslot
      </x-modal>
    </x-card>


  </x-container>


  {{-- <!-- MAIN CONTENT -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-footer">
                    <div class="col-md-12 text-center">
                        <!-- Upgrade Button trigger modal -->
                        @if (!config('SETTINGS::SYSTEM:PTERODACTYL:ADMIN_USER_TOKEN') and Auth::user()->role == 'admin')
                            <i data-toggle="popover" data-trigger="hover"
                                data-content="{{ __('To enable the upgrade/downgrade system, please set your Ptero Admin-User API Key in the Settings!') }}"
                                class="fas fa-info-circle"></i>
                        @endif
                        <button type="button" data-toggle="modal" @if (!config('SETTINGS::SYSTEM:PTERODACTYL:ADMIN_USER_TOKEN')) disabled @endif
                            data-target="#UpgradeModal{{ $server->id }}" target="__blank" class="btn btn-info btn-md">
                            <i class="fas fa-upload mr-2"></i>
                            <span>{{ __('Upgrade / Downgrade') }}</span>
                        </button>


                        <!-- Upgrade Modal -->
                        <div style="width: 100%; margin-block-start: 100px;" class="modal fade"
                            id="UpgradeModal{{ $server->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header card-header">
                                        <h5 class="modal-title">{{ __('Upgrade/Downgrade Server') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body card-body">
                                        <strong>{{ __('FOR DOWNGRADE PLEASE CHOOSE A PLAN BELOW YOUR PLAN') }}</strong>
                                        <br>
                                        <br>
                                        <strong>{{ __('YOUR PRODUCT') }} : </strong> {{ $server->product->name }}
                                        <br>
                                        <br>

                                        <form action="{{ route('servers.upgrade', ['server' => $server->id]) }}"
                                            method="POST" class="upgrade-form">
                                            @csrf
                                            <select name="product_upgrade" id="product_upgrade"
                                                class="form-input2 form-control">
                                                <option value="">{{ __('Select the product') }}</option>
                                                @foreach ($products as $product)
                                                    @if (in_array($server->egg, $product->eggs) && $product->id != $server->product->id)
                                                        <option value="{{ $product->id }}">{{ $product->name }} [
                                                            {{ CREDITS_DISPLAY_NAME }} {{ $product->price }} ]
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <br>
                                            {{ __('Once the Upgrade button is pressed, we will automatically deduct the amount for the first hour according to the new product from your credits') }}.
                                            <br>
                                            <br> {{ _('Server will be automatically restarted once upgraded') }}
                                    </div>
                                    <div class="modal-footer card-body">
                                        <button type="submit" class="btn btn-primary upgrade-once"
                                            style="width: 100%"><strong>{{ __('Change Product') }}</strong></button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Button trigger modal -->
                        <button type="button" data-toggle="modal" data-target="#DeleteModal" target="__blank"
                            class="btn btn-danger btn-md">
                            <i class="fas fa-trash mr-2"></i>
                            <span>{{ __('Delete') }}</span>
                        </button>

                    </div>
                </div>
            </div>



        </div>
        <!-- END CUSTOM CONTENT -->
        </div>
    </section>
    <!-- END CONTENT --> --}}
  <script type="text/javascript">
    $(".upgrade-form").submit(function(e) {

      $(".upgrade-once").attr("disabled", true);
      return true;
    })
  </script>
@endsection
