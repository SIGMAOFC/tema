@extends('layouts.main')

@section('content')
  <div class="container px-6 mx-auto grid">
    <h2 class="text-xl py-4 font-semibold text-gray-700 dark:text-gray-200">
      {{ __('Create Ticket') }}
    </h2>
    <!-- FORM -->
    <form action="{{ route('ticket.new.store') }}" method="post" class="ticket-form">
      @csrf
      <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="min-w-0 bg-white rounded-lg shadow-sm dark:bg-gray-800">

          <div class="px-4 py-3 pb-4 mb-8 bg-white rounded-lg dark:bg-gray-800">
            <div class="card">

              <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                {{ __('Open a new ticket') }}
              </h3>

              <div class="card-body">

                <x-validation-errors class="mb-4" :errors="$errors" />

                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">{{ __('Title') }}</span>
                  <input id="title" name="title" type="text" required="required"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="Title" value="{{ old('title') }}">
                </label>
                @if ($servers->count() >= 1)
                  <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                      {{ __('Servers') }}
                    </span>
                    <select
                      class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                      required name="server" id="server">
                      <option selected disabled hidden value="null">
                        {{ __('Select Servers') }}</option>
                      @foreach ($servers as $server)
                        <option value="{{ $server->id }}">{{ $server->name }}</option>
                      @endforeach
                    </select>
                  </label>
                @endif

                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">
                    {{ __('Category') }}
                  </span>
                  <select
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    id="ticketcategory" required name="ticketcategory" required="required">
                    <option value="">{{ __('Select Category') }}</option>
                    @foreach ($ticketcategories as $ticketcategory)
                      <option value="{{ $ticketcategory->id }}">{{ $ticketcategory->name }}
                      </option>
                    @endforeach
                  </select>
                </label>
                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">
                    {{ __('Priority') }}
                  </span>
                  <select
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    name="priority" required id="priority">
                    <option value="" disabled selected>Select Priority</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                  </select>
                </label>

              </div>
            </div>
            <button type="submit"
              class="mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple
                            ticket-once disabled:opacity-50 disabled:cursor-not-allowed">
              {{ __('Open Ticket') }}
            </button>
          </div>

        </div>
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
          <div class="card">

            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
              {{ __('Ticket Details') }}
            </h3>

            <div class="card-body">
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">{{ __('Message') }}</span>
                <textarea id="message" name="message" type="text" rows="8" required
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('message') }}</textarea>
              </label>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <script type="text/javascript">
    document.querySelector(".ticket-form").onsubmit(function(e) {

      document.querySelector(".ticket-once").attributes.disabled.value = true;
      return true;
    })
  </script>

@endsection
