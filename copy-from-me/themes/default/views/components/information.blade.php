{{-- imprint and privacy policy --}}
<div class="my-2 text-gray-700">
  <div class="container text-center">
    @if (config('SETTINGS::SYSTEM:SHOW_IMPRINT') == 'true')
      <a target="_blank" href="{{ route('imprint') }}">{{ __('Imprint') }}</a> |
    @endif
    @if (config('SETTINGS::SYSTEM:SHOW_PRIVACY') == 'true')
      <a target="_blank" href="{{ route('privacy') }}">{{ __('Privacy') }}</a>
    @endif
    @if (config('SETTINGS::SYSTEM:SHOW_TOS') == 'true')
      | <a target="_blank" href="{{ route('tos') }}">{{ __('Terms of Service') }}</a>
    @endif
  </div>
</div>
