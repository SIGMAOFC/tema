<x-card class="mt-4">
  <form enctype="multipart/form-data" action="{{ route('admin.settings.update.miscsettings') }}" method="POST">
    @csrf
    @method('PATCH')

    <x-validation-errors :errors="$errors" />

    <div class="grid gap-x-4 md:grid-cols-2 lg:grid-cols-4">
      <x-card title="Mail" class="p-0 shadow-none" style="padding: 0 !important;">
        <x-label title="Mail Service">
          <x-select id="mailservice" name="mailservice" required autocomplete="off">
            @foreach (array_keys(config('mail.mailers')) as $mailer)
              <option value="{{ $mailer }}" @if (config('SETTINGS::MAIL:MAILER') == $mailer) selected @endif>
                {{ __($mailer) }}</option>
            @endforeach
          </x-select>
          @slot('text')
            {{ __('The Mailer to send e-mails with') }}
          @endslot

        </x-label>
        <x-label title="Mail Host">
          <x-input id="mailhost" name="mailhost" type="text" value="{{ config('SETTINGS::MAIL:HOST') }}" />
        </x-label>
        <x-label title="Mail Port">
          <x-input id="mailport" name="mailport" type="text" value="{{ config('SETTINGS::MAIL:PORT') }}" />
        </x-label>
        <x-label title="Mail Username">
          <x-input value="{{ config('SETTINGS::MAIL:USERNAME') }}" id="mailusername" name="mailusername"
            type="text" />
        </x-label>
        <x-label title="Mail Password">
          <x-input id="mailpassword" name="mailpassword" type="password"
            value="{{ config('SETTINGS::MAIL:PASSWORD') }}" />
        </x-label>
        <x-label title="Mail Encryption">
          <x-input x-todo="mailencryption" id="mailencryption" name="mailencryption" type="text"
            value="{{ config('SETTINGS::MAIL:ENCRYPTION') }}" />
        </x-label>
        <x-label title="Mail From Address">
          <x-input x-todo="mailfromadress" id="mailfromadress" name="mailfromadress" type="text"
            value="{{ config('SETTINGS::MAIL:FROM_ADDRESS') }}" />
        </x-label>
        <x-label title="Mail From Name">
          <x-input x-todo="mailfromname" id="mailfromname" name="mailfromname" type="text"
            value="{{ config('SETTINGS::MAIL:FROM_NAME') }}" />
        </x-label>
      </x-card>

      <x-card title="Discord" class="p-0 shadow-none" style="padding: 0 !important;">
        <x-label title="Discord Client ID">
          <x-input x-todo="discord-client-id" id="discord-client-id" name="discord-client-id" type="text"
            value="{{ config('SETTINGS::DISCORD:CLIENT_ID') }}" />
        </x-label>
        <x-label title="Discord Client Secret">
          <x-input x-todo="discord-client-secret" id="discord-client-secret" name="discord-client-secret" type="text"
            value="{{ config('SETTINGS::DISCORD:CLIENT_SECRET') }}" />
        </x-label>
        <x-label title="Discord Bot Token">
          <x-input x-todo="discord-bot-token" id="discord-bot-token" name="discord-bot-token" type="text"
            value="{{ config('SETTINGS::DISCORD:BOT_TOKEN') }}" />
        </x-label>
        <x-label title="Discord Guild ID">
          <x-input x-todo="discord-guild-id" id="discord-guild-id" name="discord-guild-id" type="number"
            value="{{ config('SETTINGS::DISCORD:GUILD_ID') }}" />
        </x-label>
        <x-label title="Discord Invite URL">
          <x-input x-todo="discord-invite-url" id="discord-invite-url" name="discord-invite-url" type="text"
            value="{{ config('SETTINGS::DISCORD:INVITE_URL') }}" />
        </x-label>
        <x-label title="Discord Role ID">
          <x-input x-todo="discord-role-id" id="discord-role-id" name="discord-role-id" type="number"
            value="{{ config('SETTINGS::DISCORD:ROLE_ID') }}" />
        </x-label>
      </x-card>

      <x-card title="ReCaptcha" class="p-0 shadow-none" style="padding: 0 !important;">
        <x-checkbox title="Enable Recaptch" value="true" id="enable-recaptcha" name="enable-recaptcha"
          checked="{{ config('SETTINGS::RECAPTCHA:ENABLED') }}">
        </x-checkbox>
        <x-label title="ReCaptcha Site Key">
          <x-input x-todo="recaptcha-site-key" id="recaptcha-site-key" name="recaptcha-site-key" type="text"
            value="{{ config('SETTINGS::RECAPTCHA:SITE_KEY') }}" />
        </x-label>
        <x-label title="ReCaptcha Secret Key">
          <x-input x-todo="recaptcha-secret-key" id="recaptcha-secret-key" name="recaptcha-secret-key"
            type="text" value="{{ config('SETTINGS::RECAPTCHA:SECRET_KEY') }}" />
        </x-label>
        @if (config('SETTINGS::RECAPTCHA:ENABLED') == 'true')
          <div class="form-group mb-3">
            <div class="custom-control p-0 shadow-none" style="padding: 0 !important;">
              <label>{{ __('Your Recaptcha') }}:</label>
              {!! htmlScriptTagJsApi() !!}
              {!! htmlFormSnippet() !!}
            </div>
          </div>
        @endif

      </x-card>

      <x-card title="Referral System" class="p-0 shadow-none" style="padding: 0 !important;">
        <x-checkbox title="Enable Referral" value="true" id="enable_referral" name="enable_referral"
          checked="{{ config('SETTINGS::REFERRAL::ENABLED') }}">
        </x-checkbox>

        <x-checkbox title="Always Give Commission" value="true" id="always_give_commission"
          name="always_give_commission" checked="{{ config('SETTINGS::REFERRAL::ALWAYS_GIVE_COMMISSION') }}">
          {{ __('Should users recieve the commission only for the first payment, or for every payment?') }}
        </x-checkbox>

        <x-label title="Mode">
          <x-select id="referral_mode" class="custom-select" name="referral_mode" required autocomplete="off">
            <option value="commission" @if (config('SETTINGS::REFERRAL:MODE') == 'commission') selected @endif>
              {{ __('Commission') }}</option>
            <option value="sign-up" @if (config('SETTINGS::REFERRAL:MODE') == 'sign-up') selected @endif>{{ __('Sign-Up') }}
            </option>
            <option value="both" @if (config('SETTINGS::REFERRAL:MODE') == 'both') selected @endif>{{ __('Both') }}
            </option>
          </x-select>
          @slot('text')
            {{ __('Should a reward be given if a new User registers or if a new user buys credits') }}
          @endslot
        </x-label>
        <x-label title="Referral reward in percent">
          <x-input x-todo="referral_percentage" id="referral_percentage" name="referral_percentage" type="number"
            value="{{ config('SETTINGS::REFERRAL:PERCENTAGE') }}" />
        </x-label>
        <x-label
          title="{{ __('Referral reward in') }}
                {{ config('SETTINGS::SYSTEM:CREDITS_DISPLAY_NAME', 'Credits') }}
                {{ __('(only for sign-up-mode)') }}">
          <x-input x-todo="referral_reward" id="referral_reward" name="referral_reward" type="number"
            value="{{ config('SETTINGS::REFERRAL::REWARD') }}" />
        </x-label>
        <x-label title="Allowed">
          <x-select id="referral_allowed" class="custom-select" name="referral_allowed" required autocomplete="off">
            <option value="everyone" @if (config('SETTINGS::REFERRAL::ALLOWED') == 'everyone') selected @endif>
              {{ __('Everyone') }}</option>
            <option value="client" @if (config('SETTINGS::REFERRAL::ALLOWED') == 'client') selected @endif>{{ __('Clients') }}
            </option>
          </x-select> @slot('text')
            {{ __('Who is allowed to see their referral-URL') }}
          @endslot
        </x-label>
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
          Ticket System
        </h4>

        <x-checkbox title="Enable Ticket System" value="true" id="ticket_enabled" name="ticket_enabled"
          checked="{{ config('SETTINGS::TICKET:ENABLED') }}">
        </x-checkbox>

        <x-label title="Notify on Ticket Creation">
          <x-select id="ticket_notify" name="ticket_notify" required autocomplete="off">
            <option value="admin" @if (config('SETTINGS::TICKET:NOTIFY') == 'admin') selected @endif>{{ __('Admins') }}
            </option>
            <option value="moderator" @if (config('SETTINGS::TICKET:NOTIFY') == 'moderator') selected @endif>
              {{ __('Moderators') }}</option>
            <option value="all" @if (config('SETTINGS::TICKET:NOTIFY') == 'all') selected @endif>{{ __('Both') }}
            </option>
            <option value="none" @if (config('SETTINGS::TICKET:NOTIFY') == 'none') selected @endif>{{ __('Disabled') }}
            </option>
          </x-select> @slot('text')
            {{ __('Who will receive an E-Mail when a new Ticket is created') }}
          @endslot
        </x-label>
      </x-card>
    </div>

    <x-button type='submit'>{{ __('Submit') }}</x-button>
  </form>

</x-card>
