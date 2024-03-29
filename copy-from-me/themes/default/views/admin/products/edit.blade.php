@extends('layouts.main')

@section('head')
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
  <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
@endsection

@section('content')
  <x-container title="Products">

    @if ($product->servers()->count() > 0)
      <x-alert title="Editing the resource options will not automatically update the servers on
        pterodactyls side!"
        type="danger">
        {{ __('Automatically updating resource options on pterodactyl side is on my todo list :)') }}
      </x-alert>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
      @csrf
      @method('PATCH')

      <div class="grid gap-6 md:grid-cols-2">
        <x-card title="{{ __('Product Details') }}">

          <x-validation-errors :errors="$errors" />

          <div class="grid gap-6 md:grid-cols-2">
            <x-label title="Name">
              <x-input value="{{ $product->name }}" id="name" name="name" type="text" />
            </x-label>
            <x-label title="Price in {{ CREDITS_DISPLAY_NAME }}">
              <x-input value="{{ $product->price }}" id="price" name="price" step=".01" type="number" />
            </x-label>
            <x-label title="Memory">
              <x-input value="{{ $product->memory }}" id="memory" name="memory" type="number" />
            </x-label>
            <x-label title="CPU">
              <x-input value="{{ $product->cpu }}" id="cpu" name="cpu" type="number" />
            </x-label>
            <x-label title="Disk">
              <x-input value="{{ $product->disk }}" id="disk" name="disk" type="number" />
            </x-label>
            <x-label title="Swap">
              <x-input value="{{ $product->swap }}" id="swap" name="swap" type="number" />
            </x-label>
            <x-label title="Description" text="{{ __('This is what the users sees') }}">
              <textarea id="description" name="description" type="text"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                required="required">{{ $product->description }}</textarea>

            </x-label>
            <x-label title="Minimum {{ CREDITS_DISPLAY_NAME }}"
              text="{{ __('Setting to -1 will use the value from configuration.') }}">
              <x-input value="{{ $product->minimum_credits }}" id="minimum_credits" name="minimum_credits"
                type="number" />
            </x-label>
            <x-label title="IO">
              <x-input value="{{ $product->io }}" id="io" name="io" type="number" />
            </x-label>
            <x-label title="Databases">
              <x-input value="{{ $product->databases }}" id="databases" name="databases" type="number" />
            </x-label>
            <x-label title="Backups">
              <x-input value="{{ $product->backups }}" id="backups" name="backups" type="number" />
            </x-label>
            <x-label title="Allocations">
              <x-input value="{{ $product->allocations }}" id="allocations" name="allocations" type="number" />
            </x-label>
          </div>

        </x-card>
        <x-card title="{{ __('Product Linking') }}">
          {{ __('Link your products to nodes and eggs to create dynamic pricing for each option') }}
          <br>
          <div class="card-body">
            <div class="form-group">
              <label for="nodes">{{ __('Nodes') }}</label>
              <select id="nodes" style="width:100%" class="custom-select @error('nodes') is-invalid @enderror"
                name="nodes[]" multiple="multiple" autocomplete="off">
                @foreach ($locations as $location)
                  <optgroup label="{{ $location->name }}">
                    @foreach ($location->nodes as $node)
                      <option @if (isset($product) && $product->nodes->contains('id', $node->id)) selected @endif value="{{ $node->id }}">
                        {{ $node->name }}</option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
              @error('nodes')
                <div class="text-danger">
                  {{ $message }}
                </div>
              @enderror
              <div class="text-muted">
                {{ __('This product will only be available for these nodes') }}
              </div>
            </div>


            <div class="form-group">
              <label for="eggs">{{ __('Eggs') }}</label>
              <select id="eggs" style="width:100%" class="custom-select @error('eggs') is-invalid @enderror"
                name="eggs[]" multiple="multiple" autocomplete="off">
                @foreach ($nests as $nest)
                  <optgroup label="{{ $nest->name }}">
                    @foreach ($nest->eggs as $egg)
                      <option @if (isset($product) && $product->eggs->contains('id', $egg->id)) selected @endif value="{{ $egg->id }}">
                        {{ $egg->name }}</option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
              @error('eggs')
                <div class="text-danger">
                  {{ $message }}
                </div>
              @enderror
              <div class="text-muted">
                {{ __('This product will only be available for these eggs') }}
              </div>
            </div>
            <div class="text-muted">
              {{ __('No Eggs or Nodes shown?') }} <a href="{{ route('admin.overview.sync') }}"
                class="text-purple-600 underline">{{ __('Sync now') }}</a>
            </div>
          </div>
          <x-button type='submit' class="mt-4">{{ __('Submit') }}</x-button>

        </x-card>
      </div>
    </form>
  </x-container>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('[data-toggle="popover"]').popover();
      $('.custom-select').select2();
    });
  </script>
  <x-page_script></x-page_script>
@endsection
