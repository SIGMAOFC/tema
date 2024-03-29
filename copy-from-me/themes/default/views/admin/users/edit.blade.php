@extends('layouts.main')

@section('content')
  <x-container title="Users">

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
      @csrf
      @method('PATCH')

      <div class="grid gap-6 md:grid-cols-2">
        <x-card>

          <x-validation-errors :errors="$errors" />

          <div class="grid gap-6 md:grid-cols-2">
            <x-label title="Username">
              <x-input value="{{ $user->name }}" id="name" name="name" type="text" />
            </x-label>
            <x-label title="Email">
              <x-input value="{{ $user->email }}" id="email" name="email" type="email" />
            </x-label>
            <x-label title="Pterodactyl ID"
              text="This ID refers to the user account created on pterodactyls panel. Only edit this if you know what youre doing">
              <x-input value="{{ $user->pterodactyl_id }}" id="pterodactyl_id" name="pterodactyl_id" type="number" />
            </x-label>
            <x-label title="{{ CREDITS_DISPLAY_NAME }}">
              <x-input value="{{ $user->credits }}" min="0" max="99999999" step="any" id="credits"
                name="credits" type="number" />
            </x-label>
            <x-label title="Server Limit">
              <x-input value="{{ $user->server_limit }}" id="server_limit" name="server_limit" min="0"
                max="99999999" type="number" />
            </x-label>
            <x-label title="Role">
              <x-select id="role" name="role" required="required">
                <option @if ($user->role == 'admin') selected @endif
                  class="font-medium text-red-600 dark:text-red-500 hover:underline" value="admin">
                  {{ __(' Administrator') }}
                </option>
                <option @if ($user->role == 'moderator') selected @endif
                  class="font-medium text-orange-600 dark:text-orange-500 hover:underline" value="moderator">
                  {{ __('Moderator') }}
                </option>
                <option @if ($user->role == 'client') selected @endif
                  class="font-medium text-purple-600 dark:text-purple-500 hover:underline" value="client">
                  {{ __('Client') }}
                </option>
                <option @if ($user->role == 'member') selected @endif
                  class="font-medium text-green-600 dark:text-green-500 hover:underline" value="member">
                  {{ __('Member') }}
                </option>
              </x-select>
            </x-label>
            <x-label title="Referral Code">
              <x-input value="{{ $user->referral_code }}" id="referral_code" name="referral_code" type="text" />
            </x-label>
          </div>
          <x-button type='submit' class="mt-4">{{ __('Submit') }}</x-button>

        </x-card>
        <x-card title="{{ __('Password') }}">
          <br>

          <x-label title="New Password">
            <x-input id="new_password" name="new_password" type="password" placeholder="••••••" />
          </x-label>
          <x-label title="Confirm Password">
            <x-input id="new_password_confirmation" name="new_password_confirmation" type="password"
              placeholder="••••••" />
          </x-label>

        </x-card>
      </div>
    </form>
  </x-container>
@endsection
