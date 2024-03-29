<x-card class="mt-4">
  <form method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update.paymentsettings') }}">
    @csrf
    @method('PATCH')

    <x-validation-errors :errors="$errors" />

    <div class="grid gap-x-4 md:grid-cols-2 lg:grid-cols-3">
      <x-card title="Paypal" class="p-0 shadow-none" style="padding: 0 !important;">
        <x-label title="Paypal Client ID">
          <x-input x-todo="paypal-client-id" id="paypal-client-id" name="paypal-client-id" type="text"
            value="{{ config('SETTINGS::PAYMENTS:PAYPAL:CLIENT_ID') }}" />
        </x-label>
        <x-label title="Paypal Secret Key">
          <x-input x-todo="paypal-client-secret" id="paypal-client-secret" name="paypal-client-secret" type="text"
            value="{{ config('SETTINGS::PAYMENTS:PAYPAL:SECRET') }}" />
        </x-label>
        <x-label title="Paypal Sandbox Client ID (optional)">
          <x-input x-todo="paypal-sandbox-id" id="paypal-sandbox-id" name="paypal-sandbox-id" type="text"
            value="{{ config('SETTINGS::PAYMENTS:PAYPAL:SANDBOX_CLIENT_ID') }}" />
        </x-label>
        <x-label title="Paypal Sandbox Secret key (optional)">
          <x-input x-todo="paypal-sandbox-secret" id="paypal-sandbox-secret" name="paypal-sandbox-secret" type="text"
            value="{{ config('SETTINGS::PAYMENTS:PAYPAL:SANDBOX_SECRET') }}" />
        </x-label>
      </x-card>

      <x-card title="Stripe" class="p-0 shadow-none" style="padding: 0 !important;">
        <x-label title="Stripe Secret key">
          <x-input x-todo="stripe-secret" id="stripe-secret" name="stripe-secret" type="text"
            value="{{ config('SETTINGS::PAYMENTS:STRIPE:SECRET') }}" />
        </x-label>
        <x-label title="Stripe Endpoint Secret Key">
          <x-input x-todo="stripe-endpoint-secret" id="stripe-endpoint-secret" name="stripe-endpoint-secret"
            type="text" value="{{ config('SETTINGS::PAYMENTS:STRIPE:ENDPOINT_SECRET') }}" />
        </x-label>
        <x-label title="Stripe Test Secret key (optional)">
          <x-input x-todo="stripe-test-secret" id="stripe-test-secret" name="stripe-test-secret" type="text"
            value="{{ config('SETTINGS::PAYMENTS:STRIPE:TEST_SECRET') }}" />
        </x-label>
        <x-label title="Stripe Test Endpoint Secret key (optional)">
          <x-input x-todo="stripe-endpoint-test-secret" id="stripe-endpoint-test-secret"
            name="stripe-endpoint-test-secret" type="text"
            value="{{ config('SETTINGS::PAYMENTS:STRIPE:ENDPOINT_TEST_SECRET') }}" />
        </x-label>
        <x-label title="Payment Methods">
          <x-input x-todo="stripe-methods" id="stripe-methods" name="stripe-methods" type="text"
            value="{{ config('SETTINGS::PAYMENTS:STRIPE:METHODS') }}" />
          @slot('text')
            Comma separated list of payment methods without whitespaces. <br> Example: card,klarna,sepa
          @endslot
        </x-label>
      </x-card>

      <x-card title="Other" class="p-0 shadow-none" style="padding: 0 !important;">
        <x-label title="Tax Value in %">
          <x-input x-todo="sales-tax" id="sales-tax" name="sales-tax" type="number" step=".01"
            value="{{ config('SETTINGS::PAYMENTS:SALES_TAX') }}" />
          @slot('text')
            Tax Value that will be added to the total price of the order. <br>Example: 19 results in (19%)
          @endslot
        </x-label>
      </x-card>

    </div>

    <x-button type='submit'>{{ __('Submit') }}</x-button>
  </form>

</x-card>
