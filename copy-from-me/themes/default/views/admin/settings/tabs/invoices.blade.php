<div class="tab-pane mt-3 active" id="invoices">
  <form method="POST" enctype="multipart/form-data" class="p-4  mb-3 bg-white rounded-lg shadow-sm dark:bg-gray-800"
    action="{{ route('admin.settings.update.invoicesettings') }}">
    @csrf
    @method('PATCH')

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 pb-4">
      <div class="min-w-0 ">
        <!-- Name -->
        <label class="block text-sm mb-3">
          <span class="text-gray-700 dark:text-gray-400">{{ __('Company Name') }}</span>
          <input x-todo="name" id="company-name" name="company-name" type="text" required="required"
            value="{{ config('SETTINGS::INVOICE:COMPANY_NAME') }}"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('company-name') border-red-300 @enderror"
            placeholder="Big Tech LTD">
        </label>

        <!-- address -->
        <label class="block text-sm mb-3">
          <span class="text-gray-700 dark:text-gray-400">{{ __('Company Address') }}</span>
          <input x-todo="company-address" id="company-address" name="company-address" type="text"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                        @error('company-name') border-red-300 @enderror"
            value="{{ config('SETTINGS::INVOICE:COMPANY_ADDRESS') }}" placeholder="">
        </label>
        <!-- Phone -->
        <label class="block text-sm mb-3">
          <span class="text-gray-700 dark:text-gray-400">{{ __('Company Phonenumber') }}</span>
          <input x-todo="company-phone" id="company-phone" name="company-phone" type="text"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                        @error('company-name') border-red-300 @enderror"
            value="{{ config('SETTINGS::INVOICE:COMPANY_PHONE') }}" placeholder="">
        </label>

        <!-- VAT -->
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">{{ __('VAT ID') }}</span>
          <input x-todo="company-vat" id="company-vat" name="company-vat" type="text"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                        @error('company-name') border-red-300 @enderror"
            placeholder="" value="{{ config('SETTINGS::INVOICE:COMPANY_VAT') }}">
        </label>
      </div>

      <div class="min-w-0 ">
        <!-- email -->
        <label class="block text-sm mb-3">
          <span class="text-gray-700 dark:text-gray-400">{{ __('Company Mail') }}</span>
          <input x-todo="company-mail" id="company-mail" name="company-mail" type="email"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                        @error('company-name') border-red-300 @enderror"
            placeholder="contact@bigtech.org" value="{{ config('SETTINGS::INVOICE:COMPANY_MAIL') }}">
        </label>
        <!-- website -->
        <label class="block text-sm mb-3">
          <span class="text-gray-700 dark:text-gray-400">{{ __('Website') }}</span>
          <input x-todo="company-web" id="company-web" name="company-web" type="text"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                        @error('company-name') border-red-300 @enderror"
            value="{{ config('SETTINGS::INVOICE:COMPANY_WEBSITE') }}" placeholder="https://bigtech.org">
        </label>

        <!-- prefix -->
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">{{ __('Invoice Prefix') }}</span>
          <input x-todo="invoice-prefix" id="invoice-prefix" name="invoice-prefix" type="text" required="required"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                        @error('company-name') border-red-300 @enderror"
            placeholder="" value="{{ config('SETTINGS::INVOICE:PREFIX') }}">
        </label>
      </div>
      <div class="min-w-0  mr-4">

        <x-checkbox title="Enable Invoices" value="true" id="enable-invoices" name="enable-invoices"
          checked="{{ config('SETTINGS::INVOICE:ENABLED') }}">
        </x-checkbox>

        <!-- logo -->
        <div class="mt-4">
          <label for="invoice-logo" class="">{{ __('Logo') }}</label>
          <input type="file" accept="image/png,image/jpeg,image/jpg"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            name="logo" id="invoice-logo">
        </div>

      </div>
    </div>
    <button
      class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
      type="submit">{{ __('Submit') }}</button>
  </form>
</div>
