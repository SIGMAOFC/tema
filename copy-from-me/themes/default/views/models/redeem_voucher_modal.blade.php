<!-- Modal backdrop. This what you want to place close to the closing body tag -->
<div x-cloak x-show="isRedeemModalOpen" x-transition:enter="transition ease-out duration-150"
  x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
  x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0"
  class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" id="redeem-modal">
  <!-- Modal -->
  <div x-cloak x-show="isRedeemModalOpen" x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeRedeemModal"
    @keydown.escape="closeRedeemModal"
    class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
    role="dialog" id="redeem-modal">
    <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
    <form id="redeemVoucherForm" action="{{ route('voucher.redeem') }}" method="post">
      @csrf
      @method('POST')

      <header class="flex justify-end">
        <button
          class="focus:ring focus:ring-indigo-200 focus:ring-opacity-50 inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
          aria-label="close" @click="closeRedeemModal">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
            <path
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd" fill-rule="evenodd"></path>
          </svg>
        </button>
      </header>
      <!-- Modal body -->
      <div class="mt-4 mb-6">
        <!-- Modal title -->
        <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
          {{ __('Redeem Voucher') }}
        </p>
        <!-- Modal description -->
        <p class="text-sm text-gray-700 dark:text-gray-400">
          {{ __('You can redeem a code to get coins!') }}
        </p>
        <x-label title="Redeem Code">
          <x-input id="redeemVoucherCode" name="code" type="text" required="required" placeholder="SUMMER" />
          <span id="redeemVoucherCodeError" class="text-xs text-red-600 dark:text-red-400">

          </span>
          <span id="redeemVoucherCodeSuccess" class="text-xs text-lime-600 dark:text-lime-400">

          </span>

        </x-label>
      </div>
      <footer
        class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
        <button @click="closeRedeemModal" type="reset" id="redeemVoucherClose"
          class="w-full px-5 py-3 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
          Cancel
        </button>
        <button
          class="focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
          name="submit" id="redeemVoucherSubmit" type="submit">
          Redeem
        </button>
      </footer>
    </form>

  </div>
</div>
<!-- End of modal backdrop -->


<script>
  function redeemVoucherCode() {
    let form = document.getElementById('redeemVoucherForm')
    let button = document.getElementById('redeemVoucherSubmit')
    let input = document.getElementById('redeemVoucherCode')
    let close = document.getElementById('redeemVoucherClose')

    console.log(form.method, form.action)
    button.disabled = true
    $.ajax({
      method: form.method,
      url: form.action,
      dataType: 'json',
      data: {
        "_token": "{{ csrf_token() }}",
        code: input.value
      },
      success: function(response) {
        resetForm()
        redeemVoucherSetSuccess(response)
        setTimeout(() => {
          close.click();
        }, 1000)
      },
      error: function(jqXHR, textStatus, errorThrown) {
        resetForm()
        redeemVoucherSetError(jqXHR)
        console.error(jqXHR.responseJSON)
      },
    })

  }

  function resetForm() {
    let button = document.getElementById('redeemVoucherSubmit')
    let input = document.getElementById('redeemVoucherCode')
    let successLabel = document.getElementById('redeemVoucherCodeSuccess')
    let errorLabel = document.getElementById('redeemVoucherCodeError')

    input.classList.remove('is-invalid')
    input.classList.remove('is-valid')
    successLabel.innerHTML = ''
    errorLabel.innerHTML = ''
    button.disabled = false
  }

  function redeemVoucherSetError(error) {
    let input = document.getElementById('redeemVoucherCode')
    let errorLabel = document.getElementById('redeemVoucherCodeError')

    input.classList.add("is-invalid")

    errorLabel.innerHTML = error.status === 422 ? error.responseJSON.errors.code[0] : error.responseJSON.message
  }

  function redeemVoucherSetSuccess(response) {
    let input = document.getElementById('redeemVoucherCode')
    let successLabel = document.getElementById('redeemVoucherCodeSuccess')

    successLabel.innerHTML = response.success
    input.classList.remove('is-invalid')
    input.classList.add('is-valid')
  }
  document.querySelector("#redeemVoucherSubmit").onclick = redeemVoucherCode;
</script>
