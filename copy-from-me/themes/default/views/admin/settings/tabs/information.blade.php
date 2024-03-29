<div class="tab-pane mt-3 active" id="invoices">
  <form method="POST" enctype="multipa rt/form-data" class="p-4  mb-3 bg-white rounded-lg shadow-sm dark:bg-gray-800"
    action="{{ route('admin.settings.update.informationsettings') }}">
    @csrf
    @method('PATCH')

    <div class="grid gap-6 mb-8 md:grid-cols-3">

      <div class="w-full overflow-hidden col-span-2">
        <x-card title="Alert" no_top_padding="true">

          <x-checkbox title="Enable the Alert Message on Dashboard" value="true" id="alert-enabled"
            name="alert-enabled" checked="{{ config('SETTINGS::SYSTEM:ALERT_ENABLED') }}">
          </x-checkbox>

          <x-label title="Alert Color/Type">
            <x-select id="alert-type" name="alert-type" required="required">
              <option value="info" @if (config('SETTINGS::SYSTEM:ALERT_TYPE') == 'info') selected @endif>
                {{ __('Information (Purple)') }}
              </option>
              <option value="success" @if (config('SETTINGS::SYSTEM:ALERT_TYPE') == 'success') selected @endif>
                {{ __('Success (Green)') }}
              </option>
              <option value="warn" @if (config('SETTINGS::SYSTEM:ALERT_TYPE') == 'warn') selected @endif>
                {{ __('Warning (Yellow)') }}
              </option>
              <option value="danger" @if (config('SETTINGS::SYSTEM:ALERT_TYPE') == 'danger') selected @endif>
                {{ __('Danger (Red)') }}
              </option>
            </x-select>
          </x-label>

          <x-label title="Alert Message (HTML might be used)">
            <x-textarea id="alert-message" name="alert-message">
              {{ config('SETTINGS::SYSTEM:ALERT_MESSAGE', '') }}
            </x-textarea>

          </x-label>
        </x-card>
      </div>

      <div class="w-full overflow-hidden col-span-2 md:col-span-1">
        <x-card title="Information" no_top_padding="true">
          <x-checkbox title="Enable Useful-Links" value="true" id="usefullinks-enabled" name="usefullinks-enabled"
            checked="{{ config('SETTINGS::SYSTEM:USEFULLINKS_ENABLED') }}">
            {{ __('Show the Useful-Links Section on Dashboard Home') }}
          </x-checkbox>

          <x-checkbox title="Show Terms of Service" value="true" id="show-tos" name="show-tos"
            checked="{{ config('SETTINGS::SYSTEM:SHOW_TOS') }}">
            {{ __('Show the TOS link in the footer of every page.') }} <br />
            <a href="/admin/legal">{{ __('Edit Contents') }}</a>
          </x-checkbox>
          <x-checkbox title="Show Imprint" value="true" id="show-imprint" name="show-imprint"
            checked="{{ config('SETTINGS::SYSTEM:SHOW_IMPRINT') }}">
            {{ __('Show the Imprint link in the footer of every page.') }} <br />
            <a href="/admin/legal">{{ __('Edit Contents') }}</a>
          </x-checkbox>
          <x-checkbox title="Show Privacy Policy" value="true" id="show-privacy" name="show-privacy"
            checked="{{ config('SETTINGS::SYSTEM:SHOW_PRIVACY') }}">
            {{ __('Show the Privacy Policy link in the footer of every page.') }} <br />
            <a href="/admin/legal">{{ __('Edit Contents') }}</a>
          </x-checkbox>
        </x-card>
      </div>


    </div>

    <x-card title="Message of the Day (MOTD)" no_top_padding="true">

      <x-checkbox title="Enable the MOTD on the Homepage" value="true" id="motd-enabled" name="motd-enabled"
        checked="{{ config('SETTINGS::SYSTEM:MOTD_ENABLED') }}">
      </x-checkbox>

      <div class="custom-control mb-3 p-0">
        <label for="alert-message">{{ __('MOTD-Text') }}</label>
        <textarea id="motd-message" name="motd-message" class="form-control @error('motd-message') is-invalid @enderror">
            {{ config('SETTINGS::SYSTEM:MOTD_MESSAGE', '') }}
            </textarea>
        @error('motd-message')
          <div class="text-danger">
            {{ $message }}
          </div>
        @enderror
      </div>
    </x-card>

    <button
      class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
      type="submit">{{ __('Submit') }}</button>
  </form>
</div>
<script>
  tinymce.init({
    selector: 'textarea',
    skin: "Phoenix",
    // content_css: "Phoenix",
    skin_url: "/css/tinymce",
    body_class: 'tinymce-phoenix',
    branding: false,
    height: 500,
    plugins: ['image', 'link']
  });
</script>
