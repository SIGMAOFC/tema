@extends('layouts.main')

@section('content')
  <x-container title="Partner Details">
    <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST">
      @csrf
      @method('PATCH')
      <x-card title="">

        <x-validation-errors :errors="$errors" />

        <div class="grid gap-6 md:grid-cols-2">
          <x-label title="User">
            <x-select name='user_id' autocomplete="off">
              @foreach ($users as $user)
                <option @if ($partners->contains('user_id', $user->id) && $partner->user_id != $user->id) disabled @endif
                  @if ($partner->user_id == $user->id) selected @endif value="{{ $user->id }}">
                  {{ $user->name }} ({{ $user->email }})</option>
              @endforeach
            </x-select>
          </x-label>
          <x-label title="Partner Discount">
            <x-input value="{{ $partner->partner_discount }}" placeholder="{{ __('Discount in percent') }}"
              id="partner_discount" name="partner_discount" type="number" step="any" min="0" max="100" />
            @slot('text')
              {{ __('The discount in percent given to the partner at checkout.') }}
            @endslot
          </x-label>
          <x-label title="Registered User Discount">
            <x-input value="{{ $partner->registered_user_discount }}" placeholder="Discount in percent"
              id="registered_user_discount" name="registered_user_discount" type="number" />
            @slot('text')
              {{ __('The discount in percent given to all users registered using the partners referral link.') }}
            @endslot
          </x-label>
          <x-label title="Referral Commission">
            <x-input value="{{ $partner->referral_system_commission }}" placeholder="{{ __('Commission in percent') }}"
              id="referral_system_commission" name="referral_system_commission" type="number" step="any"
              min="-1" max="100" />
            @slot('text')
              {{ __('Override value for referral system commission. You can set it to -1 to get the default commission from settings.') }}
            @endslot
          </x-label>

        </div>
        <x-button type='submit' class="mt-4">{{ __('Submit') }}</x-button>

      </x-card>
    </form>
  </x-container>
@endsection
