@extends('layouts.main')

@section('content')
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      {{ __('Ticket - ' . $ticket->title . ' (#' . $ticket->ticket_id . ')') }}
    </h2>
    <div class="">
      <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
        <div class="card-body">
          <div class="ticket-info">
            @if (!empty($server))
              <p><b>{{ __('Server') }}:</b> <a
                  href="{{ config('SETTINGS::SYSTEM:PTERODACTYL:URL') }}/server/{{ $server->identifier }}"
                  target="__blank">{{ $server->name }} </a></p>
            @endif
            <p><b>{{ __('Category') }}:</b> {{ $ticketcategory->name }}</p>
            <p><b>{{ __('Priority') }}:</b>
              @switch($ticket->priority)
                @case('Low')
                  <span
                    class="text-green-700 bg-green-100 dark:bg-green-500/20 dark:text-green-500 px-2 py-1 font-semibold leading-tight rounded-full text-xs">{{ __('Low') }}</span>
                @break

                @case('Medium')
                  <span
                    class="text-yellow-700 bg-yellow-100 dark:bg-yellow-500/20 dark:text-yellow-500 px-2 py-1 font-semibold leading-tight rounded-full text-xs">{{ __('Medium') }}</span>
                @break

                @case('High')
                  <span
                    class="text-red-700 bg-red-100 dark:bg-red-500/20 dark:text-red-500 px-2 py-1 font-semibold leading-tight rounded-full text-xs">{{ __('High') }}</span>
                @break
              @endswitch
            </p>
            <p>
              @if ($ticket->status === 'Open')
                <b>{{ __('Status') }}:</b> <span
                  class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-green-700 bg-green-100 dark:bg-green-500/20 dark:text-green-500">{{ __('Open') }}</span>
              @elseif ($ticket->status === 'Closed')
                <b>{{ __('Status') }}:</b> <span
                  class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-red-700 bg-red-100 dark:bg-red-500/20 dark:text-red-500">{{ __('Closed') }}</span>
              @elseif ($ticket->status === 'Answered')
                <b>{{ __('Status') }}:</b> <span
                  class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-blue-700 bg-blue-100 dark:bg-blue-500/20 dark:text-blue-500">{{ __('Answered') }}</span>
              @elseif ($ticket->status === 'Client Reply')
                <b>{{ __('Status') }}:</b> <span
                  class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-yellow-700 bg-yellow-100 dark:bg-yellow-500/20 dark:text-yellow-500">{{ __('Client Reply') }}</span>
              @endif
            </p>
            <p><b>{{ __('Created on') }}:</b> {{ $ticket->created_at->diffForHumans() }}</p>
            @if ($ticket->status == 'Closed')
              <form class="d-inline" method="post"
                action="{{ route('ticket.changeStatus', ['ticket_id' => $ticket->ticket_id]) }}">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <x-button type="submit">{{ __('Reopen') }}</x-button>
              </form>
            @else
              <form class="d-inline" method="post"
                action="{{ route('ticket.changeStatus', ['ticket_id' => $ticket->ticket_id]) }}">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <x-button type="submit">{{ __('Close') }}</x-button>
              </form>
            @endif

          </div>
        </div>
      </div>
      <div class="w-full overflow-hidden  shadow-sm col-span-2">
        <h2 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">
          {{ __('Comments') }}
        </h2>

      </div>
      <div class="col-lg-12">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
          <div class="flex gap-4 flex-col">
            <div
              class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800 flex sm:flex-row flex-col border dark:border-gray-700 border-gray-200">
              <div
                class="flex flex-row sm:flex-col justify-between items-center dark:border-gray-700 border-gray-200 border-b sm:border-b-0 sm:border-r pb-2 sm:pr-2 sm:pb-0 sm:mr-2">
                <h5 class="flex items-center gap-2"><img
                    src="https://www.gravatar.com/avatar/{{ md5(strtolower($ticket->user->email)) }}?s=25"
                    class="inline-block rounded-full" alt="User Image">
                  <a href="/admin/users/{{ $ticket->user->id }}">{{ $ticket->user->name }} </a>
                  @if ($ticket->user->role === 'member')
                    <span
                      class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-purple-700 bg-purple-100 dark:bg-purple-500/20 dark:text-purple-500">
                      Member </span>
                  @elseif ($ticket->user->role === 'client')
                    <span
                      class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-green-700 bg-green-100 dark:bg-green-500/20 dark:text-green-500">
                      Client </span>
                  @elseif ($ticket->user->role === 'moderator')
                    <span
                      class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-yellow-700 bg-yellow-100 dark:bg-yellow-500/20 dark:text-yellow-500">
                      Moderator </span>
                  @elseif ($ticket->user->role === 'admin')
                    <span
                      class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-red-700 bg-red-100 dark:bg-red-500/20 dark:text-red-500">
                      Admin </span>
                  @endif
                </h5>
                <span class="badge badge-primary">{{ $ticket->created_at->diffForHumans() }}</span>

              </div>
              <div class="mt-2" style="white-space:pre-wrap">{{ $ticket->message }}</div>
            </div>
            @foreach ($ticketcomments as $ticketcomment)
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800 flex sm:flex-row flex-col border dark:border-gray-700 border-gray-200">
                <div
                  class="flex flex-row sm:flex-col justify-between items-center dark:border-gray-700 border-gray-200 border-b sm:border-b-0 sm:border-r pb-2 sm:pr-2 sm:pb-0 sm:mr-2">

                  <h5 class="flex items-center gap-2"><img
                      src="https://www.gravatar.com/avatar/{{ md5(strtolower($ticketcomment->user->email)) }}?s=25"
                      class="inline-block rounded-full" alt="User Image">
                    <a href="/admin/users/{{ $ticketcomment->user->id }}">{{ $ticketcomment->user->name }}</a>
                    @if ($ticketcomment->user->role === 'member')
                      <span
                        class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-gray-700 bg-gray-100 dark:bg-gray-500/20 dark:text-gray-500 secondary">
                        Member </span>
                    @elseif ($ticketcomment->user->role === 'client')
                      <span
                        class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-green-700 bg-green-100 dark:bg-green-500/20 dark:text-green-500 success">
                        Client </span>
                    @elseif ($ticketcomment->user->role === 'moderator')
                      <span
                        class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-yellow-700 bg-yellow-100 dark:bg-yellow-500/20 dark:text-yellow-500 info">
                        Moderator </span>
                    @elseif ($ticketcomment->user->role === 'admin')
                      <span
                        class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-red-700 bg-red-100 dark:bg-red-500/20 dark:text-red-500 danger">
                        Admin </span>
                    @endif
                  </h5>
                  <span class="badge badge-primary">{{ $ticketcomment->created_at->diffForHumans() }}</span>

                </div>
                <div class="mt-2 whitespace-normal w-3/4">
                  {{ $ticketcomment->ticketcomment }}
                </div>
              </div>
            @endforeach
            <div class="comment-form">
              <form action="{{ route('ticket.reply') }}" method="POST" class="form reply-form">
                {!! csrf_field() !!}
                <x-validation-errors class="mb-4" :errors="$errors" />
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">{{ __('Message') }}</span>
                  <textarea id="ticketcomment" name="ticketcomment" type="text" rows="8"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </label>
                <button type="submit"
                  class="mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple
                            ticket-once disabled:opacity-50 disabled:cursor-not-allowed">
                  {{ __('Submit') }}
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END CONTENT -->
  <script type="text/javascript">
    $(".reply-form").submit(function(e) {

      $(".reply-once").attr("disabled", true);
      return true;
    })
  </script>
@endsection
