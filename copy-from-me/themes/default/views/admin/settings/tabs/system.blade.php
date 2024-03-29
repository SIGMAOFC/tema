<x-card class="mt-4">
  <form method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update.systemsettings') }}">
    @csrf
    @method('PATCH')

    <x-validation-errors :errors="$errors" />

    <div class="grid gap-x-4 md:grid-cols-2 lg:grid-cols-3">
      <x-card title="System" class="p-0 shadow-none" style="padding: 0 !important;">

        <x-checkbox title="Register IP Check" value="true" id="register-ip-check" name="register-ip-check"
          checked="{{ config('SETTINGS::SYSTEM:REGISTER_IP_CHECK') }}">
          {{ __('Prevent users from making multiple accounts using the same IP address.') }}
        </x-checkbox>

        <x-checkbox title="Charge first hour at creation" value="true" id="server-create-charge-first-hour"
          name="server-create-charge-first-hour"
          checked="{{ config('SETTINGS::SYSTEM:SERVER_CREATE_CHARGE_FIRST_HOUR') }}">
          {{ __('Charge first hour at creation') }}
        </x-checkbox>
        <x-label title="Credits Display Name">
          <x-input x-todo="credits-display-name" id="credits-display-name" name="credits-display-name" type="text"
            value="{{ config('SETTINGS::SYSTEM:CREDITS_DISPLAY_NAME', 'Credits') }}" required />
        </x-label>
        <x-label title="PHPMyAdmin URL">
          <x-input x-todo="phpmyadmin-url" id="phpmyadmin-url" name="phpmyadmin-url" type="text"
            value="{{ config('SETTINGS::MISC:PHPMYADMIN:URL') }}" />
          @slot('text')
            {{ __('Enter the URL to your PHPMyAdmin installation. <strong>Without a trailing slash!</strong>') }}
          @endslot
        </x-label>
        <x-label title="Pterodactyl URL">
          <x-input x-todo="pterodactyl-url" id="pterodactyl-url" name="pterodactyl-url" type="text"
            value="{{ config('SETTINGS::SYSTEM:PTERODACTYL:URL') }}" required />
          @slot('text')
            {!! __('Enter the URL to your Pterodactyl installation. <strong>Without a trailing slash!</strong>') !!}
          @endslot
        </x-label>
        <x-label title="Pterodactyl API perPage limit">
          <x-input id="per-page-limit" name="per-page-limit" type="number"
            value="{{ config('SETTINGS::SYSTEM:PTERODACTYL:PER_PAGE_LIMIT') }}" reauired />
          @slot('text')
            {{ __('The Pterodactyl API perPage limit. It is necessary to set it higher than your server count.') }}
          @endslot
        </x-label>
        <x-label title="Pterodactyl API Key">
          <x-input x-todo="pterodactyl-api-key" id="pterodactyl-api-key" name="pterodactyl-api-key" type="text"
            value="{{ config('SETTINGS::SYSTEM:PTERODACTYL:TOKEN') }}" reauired />
          @slot('text')
            {{ __('Enter the API Key to your Pterodactyl installation.') }}
          @endslot
        </x-label>
        <x-label title="Pterodactyl Admin-Account API Key">
          <x-input x-todo="pterodactyl-admin-api-key" id="pterodactyl-admin-api-key" name="pterodactyl-admin-api-key"
            type="text" value="{{ config('SETTINGS::SYSTEM:PTERODACTYL:ADMIN_USER_TOKEN') }}" reauired />
          @slot('text')
            {{ __('Enter the Client-API Key to a Pterodactyl-Admin-User here.') }}
          @endslot
        </x-label>
        <a href="{{ route('admin.settings.checkPteroClientkey') }}">
          <x-button type="button" size="small">{{ __('Test API') }}</x-button>
        </a>
      </x-card>

      <x-card title="User" class="p-0 shadow-none" style="padding: 0 !important;">
        <x-checkbox title="Force Discord Verification" value="true" id="force-discord-verification"
          name="force-discord-verification" checked="{{ config('SETTINGS::USER:FORCE_DISCORD_VERIFICATION') }}">
        </x-checkbox>
        <x-checkbox title="Force E-Mail Verification" value="true" id="force-email-verification"
          name="force-email-verification" checked="{{ config('SETTINGS::USER:FORCE_EMAIL_VERIFICATION') }}">
        </x-checkbox>
        <x-checkbox title="Creation of new users" value="true" id="enable-disable-new-users"
          name="enable-disable-new-users" checked="{{ config('SETTINGS::SYSTEM:CREATION_OF_NEW_USERS') }}">
          If unchecked, it will disable the registration of new users in the system, and this will also apply
          to the API.
        </x-checkbox>
        <x-label title="Initial Credits">
          <x-input x-todo="initial-credits" id="initial-credits" name="initial-credits" type="number"
            value="{{ config('SETTINGS::USER:INITIAL_CREDITS') }}" required />
        </x-label>
        <x-label title="Initial Server Limit">
          <x-input x-todo="initial-server-limit" id="initial-server-limit" name="initial-server-limit" type="number"
            value="{{ config('SETTINGS::USER:INITIAL_SERVER_LIMIT') }}" required />
        </x-label>
        <x-label title="Credits Reward Amount - Discord">
          <x-input x-todo="credits-reward-amount-discord" id="credits-reward-amount-discord"
            name="credits-reward-amount-discord" type="number"
            value="{{ config('SETTINGS::USER:CREDITS_REWARD_AFTER_VERIFY_DISCORD') }}" required />
        </x-label>
        <x-label title="Credits Reward Amount - Email">
          <x-input x-todo="credits-reward-amount-email" id="credits-reward-amount-email"
            name="credits-reward-amount-email" type="number"
            value="{{ config('SETTINGS::USER:CREDITS_REWARD_AFTER_VERIFY_EMAIL') }}" required />
        </x-label>
        <x-label title="Server Limit Increase - Discord">
          <x-input x-todo="server-limit-discord" id="server-limit-discord" name="server-limit-discord" type="number"
            value="{{ config('SETTINGS::USER:SERVER_LIMIT_REWARD_AFTER_VERIFY_DISCORD') }}" required />
        </x-label>
        <x-label title="Server Limit Increase - Email">
          <x-input x-todo="server-limit-email" id="server-limit-email" name="server-limit-email" type="number"
            value="{{ config('SETTINGS::USER:SERVER_LIMIT_REWARD_AFTER_VERIFY_EMAIL') }}" required />
        </x-label>

        <x-label title="Server Limit after Credits Purchase">
          <x-input x-todo="server-limit-purchase" id="server-limit-purchase" name="server-limit-purchase"
            type="number" value="{{ config('SETTINGS::USER:SERVER_LIMIT_AFTER_IRL_PURCHASE') }}" requried />
        </x-label>
      </x-card>


      <x-card title="Other" class="p-0 shadow-none" style="padding: 0 !important;">
        <x-card title="Server" class="p-0 shadow-none" style="padding: 0 !important;">
          <x-checkbox title="Creation or new Servers" value="true" id="enable-disable-servers"
            name="enable-disable-servers" checked="{{ config('SETTINGS::SYSTEM:CREATION_OF_NEW_SERVERS') }}">
            If unchecked, it will disable the creation of new servers in the system.
          </x-checkbox>
          <x-checkbox title="Enable Upgrade/Downgrade of Servers" value="true" id="enable-upgrade"
            name="enable-upgrade" checked="{{ config('SETTINGS::SYSTEM:ENABLE_UPGRADE') }}">
            Allow upgrade/downgrade to a new product for the given server.
          </x-checkbox>
          <x-label title="Server Allocation Limit">
            <x-input x-todo="allocation-limit" id="allocation-limit" name="allocation-limit" type="number"
              value="{{ config('SETTINGS::SERVER:ALLOCATION_LIMIT') }}" required />
            @slot('text')
              {{ __('The maximum amount of allocations to pull per node for automatic deployment, if more allocations are being used than this limit is set to, no new servers can be created!') }}
            @endslot
          </x-label>
          <x-label title="Minimum Credits">
            <x-input x-todo="minimum-credits" id="minimum-credits" name="minimum-credits" type="number"
              min="0" max="99999999"
              value="{{ config('SETTINGS::USER:MINIMUM_REQUIRED_CREDITS_TO_MAKE_SERVER') }}" required />
            @slot('text')
              {{ __('The minimum amount of credits user has to have to create a server. Can be overridden by package limits.') }}
            @endslot
          </x-label>
        </x-card>
        <x-card title="SEO" class="p-0 shadow-none" style="padding: 0 !important;">
          <x-label title="SEO Title">
            <x-input x-todo="seo-title" id="seo-title" name="seo-title" type="text"
              value="{{ config('SETTINGS::SYSTEM:SEO_TITLE') }}" required />
            @slot('text')
              {{ __('An SEO title tag must contain your target keyword. This tells both Google and searchers that your web page is relevant to this search query!') }}
            @endslot
          </x-label>
          <x-label title="SEO Description">
            <x-input x-todo="seo-description" id="seo-description" name="seo-description" type="text"
              value="{{ config('SETTINGS::SYSTEM:SEO_DESCRIPTION') }}" required />
            @slot('text')
              {{ __('The SEO site description represents your homepage. Search engines show this description in search results for your homepage if they dont find content more relevant to a visitors search terms.') }}
            @endslot
          </x-label>
        </x-card>
        <x-card title="Design" class="p-0 shadow-none" style="padding: 0 !important;">

          {{-- <x-label title="Theme">
                        <x-select id="theme" name="theme" required="required" disabled
                            data-content="Theme Switching isn't supported in Phoenix Theme" data-toggle="popover"
                            data-trigger="hover" data-placement="top">
                            @foreach ($themes as $theme)
                                <option class="font-medium hover:underline" value="member"
                                    value="{{ $theme }}" @if ($active_theme == $theme) selected @endif>
                                    {{ $theme }}</option>
                            @endforeach
                        </x-select>
                    </x-label> --}}
          <x-checkbox title="Show logo on Login Page" value="true" id="enable-login-logo" name="enable-login-logo"
            checked="{{ config('SETTINGS::SYSTEM:ENABLE_LOGIN_LOGO') }}">
          </x-checkbox>

          <x-label title="Panel Icon">
            <x-input type='file' accept="image/png,image/jpeg,image/jpg" class="custom-file-input" name="icon"
              id="icon"></x-input>
          </x-label>
          <x-label title="Login Page Icon">
            <x-input type='file' accept="image/png,image/jpeg,image/jpg" class="custom-file-input" name="logo"
              id="logo"></x-input>
          </x-label>
          <x-label title="Panel Favicon">
            <x-input type='file' accept="image/x-icon" class="custom-file-input" name="favicon"
              id="favicon"></x-input>
          </x-label>
        </x-card>
      </x-card>

    </div>

    <x-button type='submit'>{{ __('Submit') }}</x-button>
  </form>

</x-card>
