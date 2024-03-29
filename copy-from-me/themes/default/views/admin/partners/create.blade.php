@extends('layouts.main')

@section('content')
  <x-container title="Partner Details">
    <form action="{{ route('admin.partners.store') }}" method="POST">
      @csrf
      <x-card title="">

        <x-validation-errors :errors="$errors" />
        <div class="grid gap-6 md:grid-cols-2">
          <x-label title="User">
            <x-select name='user_id' autocomplete="off">
              @foreach ($users as $user)
                <option @if ($partners->contains('user_id', $user->id)) disabled @endif value="{{ $user->id }}">
                  {{ $user->name }} ({{ $user->email }})</option>
              @endforeach
            </x-select>
          </x-label>
          <x-label title="Partner Discount">
            <x-input value="{{ old('partner_discount') }}" placeholder="{{ __('Discount in percent') }}"
              id="partner_discount" name="partner_discount" type="number" step="any" min="0" max="100" />
            @slot('text')
              {{ __('The discount in percent given to the partner at checkout.') }}
            @endslot
          </x-label>
          <x-label title="Registered User Discount">
            <x-input value="{{ old('registered_user_discount') }}" placeholder="Discount in percent"
              id="registered_user_discount" name="registered_user_discount" type="number" />
            @slot('text')
              {{ __('The discount in percent given to all users registered using the partners referral link.') }}
            @endslot
          </x-label>
          <x-label title="Referral Commission">
            <x-input value="{{ old('referral_system_commission') }}" placeholder="{{ __('Commission in percent') }}"
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

@section('scripts')
  <script type="application/javascript">
        function initUserIdSelect(data) {
            function escapeHtml(str) {
                var div = document.createElement('div');
                div.appendChild(document.createTextNode(str));
                return div.innerHTML;
            }

            $('#user_id').select2({
                ajax: {
                    url: '/admin/users.json',
                    dataType: 'json',
                    delay: 250,

                    data: function (params) {
                        return {
                            filter: { name: params.term },
                            page: params.page,
                        };
                    },

                    processResults: function (data, params) {
                        return { results: data };
                    },

                    cache: true,
                },

                data: data,
                escapeMarkup: function (markup) { return markup; },
                minimumInputLength: 2,
                templateResult: function (data) {
                    if (data.loading) return escapeHtml(data.text);

                    return '<div class="user-block"> \
                        <img class="img-circle img-bordered-xs" src="' + escapeHtml(data.avatarUrl) + '?s=120" alt="User Image"> \
                        <span class="username"> \
                            <a href="#">' + escapeHtml(data.name) +'</a> \
                        </span> \
                        <span class="description"><strong>' + escapeHtml(data.email) + '</strong>' + '</span> \
                    </div>';
                },
                templateSelection: function (data) {
                    return '<div> \
                        <span> \
                            <img class="img-rounded img-bordered-xs" src="' + escapeHtml(data.avatarUrl) + '?s=120" style="height:28px;margin-top:-4px;" alt="User Image"> \
                        </span> \
                        <span style="padding-left:5px;"> \
                            ' + escapeHtml(data.name) + ' (<strong>' + escapeHtml(data.email) + '</strong>) \
                        </span> \
                    </div>';
                }

            });
        }

        $(document).ready(function() {
            @if (old('user_id'))
            $.ajax({
                url: '/admin/users.json?user_id={{ old('user_id') }}',
                dataType: 'json',
            }).then(function (data) {
                initUserIdSelect([ data ]);
            });
            @else
            initUserIdSelect();
            @endif
        });
    </script>
@endsection
