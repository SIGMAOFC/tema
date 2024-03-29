<div class="tab-pane mt-3 active" id="language">
  <form method="POST" enctype="multipart/form-data" class="p-4  mb-3 bg-white rounded-lg shadow-sm dark:bg-gray-800"
    action="{{ route('admin.settings.update.languagesettings') }}">
    @csrf
    @method('PATCH')

    <div class="pb-4">
      <div class="min-w-0 ">
        <!-- Availabe Languages -->
        <label class="block mt-4 text-sm">
          <span class="text-gray-700 dark:text-gray-400">
            {{ __('Available languages') }}
          </span>
          <select
            class="custom-select block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
            id="languages" name="languages[]" required multiple="multiple" autocomplete="off"
            @error('defaultLanguage') is-invalid @enderror>
            @foreach (config('app.available_locales') as $lang)
              <option value="{{ $lang }}" @if (strpos(config('SETTINGS::LOCALE:AVAILABLE'), $lang) !== false) selected @endif>
                {{ __($lang) }}
              </option>
            @endforeach
          </select>
        </label>

        <label class="block my-4 text-sm">
          <span class="text-gray-700 dark:text-gray-400">
            {{ __('Default Language') }}
          </span alt="{{ __('The fallback Language, if something goes wrong') }}">
          <select
            class="custom-select block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
            id="defaultLanguage" name="defaultLanguage" required autocomplete="off"
            @error('defaultLanguage') is-invalid @enderror>
            @foreach (config('app.available_locales') as $lang)
              <option value="{{ $lang }}" @if (config('SETTINGS::LOCALE:DEFAULT') == $lang) selected @endif>
                {{ __($lang) }}</option>
            @endforeach
          </select>
          <span class="text-xs text-gray-600 dark:text-gray-400">
            {{ __('The fallback Language, if something goes wrong') }}
          </span>
        </label>


        <label class="block text-sm my-4">
          <span class="text-gray-700 dark:text-gray-400">{{ __('Datatable language') }}</span>
          <input
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                        id="datatable-language"
            name="datatable-language" type="text" required value="{{ config('SETTINGS::LOCALE:DATATABLES') }}">
          <span class="text-xs text-gray-600 dark:text-gray-400">
            {{ __('The datatables lang-code.') }}
          </span>
        </label>

        <x-checkbox title="Auto Translate" value="true" id="autotranslate" name="autotranslate"
          checked="{{ config('SETTINGS::LOCALE:DYNAMIC') }}">
          {{ __('If this is checked, the Dashboard will translate itself to the Clients language, if available') }}
        </x-checkbox>
        <x-checkbox title="Clients Language Switch" value="true" id="canClientChangeLanguage"
          name="canClientChangeLanguage" checked="{{ config('SETTINGS::LOCALE:CLIENTS_CAN_CHANGE') }}">
          {{ __('If this is checked, Clients will have the ability to manually change their Dashboard language') }}
        </x-checkbox>

      </div>
    </div>
    <button
      class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
      type="submit">{{ __('Submit') }}</button>
  </form>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    $('[data-toggle="popover"]').popover();
    $('.custom-select').select2();
  });
</script>


@section('head')
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
  <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
@endsection
