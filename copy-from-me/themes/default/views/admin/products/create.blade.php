@extends('layouts.main')


@section('head')
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
  <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
@endsection

@section('content')
  <x-container title="Products">

    <form action="{{ route('admin.products.store') }}" method="POST">
      @csrf
      <div class="grid gap-6 md:grid-cols-2">
        <x-card title="Details">

          <x-validation-errors :errors="$errors" />
          <div class="grid gap-6 md:grid-cols-2">
            <x-label title="Name">
              <x-input value="{{ $product->name ?? old('name') }}" id="name" name="name" type="text" />
            </x-label>
            <x-label title="Price in {{ CREDITS_DISPLAY_NAME }}">
              <x-input value="{{ $product->price ?? old('price') }}" id="price" name="price" step=".01"
                type="number" />
            </x-label>
            <x-label title="Memory">
              <x-input value="{{ $product->memory ?? old('memory') }}" id="memory" name="memory" type="number" />
            </x-label>
            <x-label title="CPU">
              <x-input value="{{ $product->cpu ?? old('cpu') }}" id="cpu" name="cpu" type="number" />
            </x-label>
            <x-label title="Disk">
              <x-input value="{{ $product->disk ?? (old('disk') ?? 1000) }}" id="disk" name="disk"
                type="number" />
            </x-label>
            <x-label title="Swap">
              <x-input value="{{ $product->swap ?? old('swap') }}" id="swap" name="swap" type="number" />
            </x-label>
            <x-label title="Description">
              <textarea id="description" name="description" type="text"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                required="required">{{ $product->description ?? old('description') }}</textarea>
            </x-label>
            <x-label title="Minimum {{ CREDITS_DISPLAY_NAME }}">
              <x-input value="{{ $product->minimum_credits ?? (old('minimum_credits') ?? -1) }}" id="minimum_credits"
                name="minimum_credits" type="number" />
            </x-label>
            <x-label title="IO">
              <x-input value="{{ $product->io ?? (old('io') ?? 500) }}" id="io" name="io" type="number" />
            </x-label>
            <x-label title="Databases">
              <x-input value="{{ $product->databases ?? (old('databases') ?? 1) }}" id="databases" name="databases"
                type="number" />
            </x-label>
            <x-label title="Backups">
              <x-input value="{{ $product->backups ?? (old('backups') ?? 1) }}" id="backups" name="backups"
                type="number" />
            </x-label>
            <x-label title="Allocations">
              <x-input value="{{ $product->allocations ?? (old('allocations') ?? 0) }}" id="allocations"
                name="allocations" type="number" />
            </x-label>
          </div>

        </x-card>
        <x-card title="Nodes">
          <div class="card-body">

            <div class="form-group">
              <label for="nodes">{{ __('Select Nodes') }}</label>
              <select id="nodes" style="width:100%" class="custom-select @error('nodes') is-invalid @enderror"
                name="nodes[]" multiple="multiple" autocomplete="off">
                @foreach ($locations as $location)
                  <optgroup label="{{ $location->name }}">
                    @foreach ($location->nodes as $node)
                      <option @if (isset($product)) @if ($product->nodes->contains('id', $node->id)) selected @endif
                        @endif
                        value="{{ $node->id }}">{{ $node->name }}</option>
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
                      <option @if (isset($product)) @if ($product->eggs->contains('id', $egg->id)) selected @endif
                        @endif
                        value="{{ $egg->id }}">{{ $egg->name }}</option>
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
