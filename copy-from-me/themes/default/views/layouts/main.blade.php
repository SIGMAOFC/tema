<?php
$themeClass = 'dark';
if (!empty($_COOKIE['theme'])) {
    $themeClass = $_COOKIE['theme'];
}
?>

<!DOCTYPE html>
<html :class="{ 'dark': dark }" x-data="data" lang="en" id="html"
  class="<?php echo $themeClass; ?> overflow-hidden h-full">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta content="{{ config('SETTINGS::SYSTEM:SEO_TITLE') }}" property="og:title">
  <meta content="{{ config('SETTINGS::SYSTEM:SEO_DESCRIPTION') }}" property="og:description">
  <meta
    content='{{ \Illuminate\Support\Facades\Storage::disk('public')->exists('logo.png') ? asset('storage/logo.png') : asset('images/controlpanel_logo.png') }}'
    property="og:image">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'ControlPanel') }}</title>
  <link rel="icon"
    href="{{ \Illuminate\Support\Facades\Storage::disk('public')->exists('favicon.ico') ? asset('storage/favicon.ico') : asset('favicon.ico') }}"
    type="image/x-icon">

  <style>
    [x-cloak] {
      display: none !important;
    }
  </style>

  <script>
    const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");
    if (prefersDarkScheme.matches && !window.localStorage.getItem('dark') && "<?php echo $themeClass; ?>" == "") {
      document.querySelector("html").classList.add("dark");
    }
  </script>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <script defer src="{{ asset('js/app.js') }}"></script>
  <script defer src="{{ asset('js/focus-trap.js') }}"></script>

  <script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  @yield('head')

  <script src="{{ asset('js/pace.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('css/pace.css') }}" />

  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  <script src={{ asset('plugins/tinymce/js/tinymce/tinymce.min.js') }}></script>

  {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> --}}
</head>

<body>
  <div class="pointer-events-auto flex h-screen bg-gray-50 dark:bg-gray-900"
    :class="{ 'overflow-hidden': isSideMenuOpen }">
    <!-- Desktop sidebar -->
    @include('includes.desktop-sidebar')

    <!-- Mobile sidebar -->
    @include('includes.mobile-sidebar')

    <div class="flex flex-col flex-1 w-full">
      @include('includes.header')
      <main class="flex flex-col justify-between h-full overflow-y-auto text-gray-700 dark:text-gray-400">
        <div>

          @if (!Auth::user()->hasVerifiedEmail())
            @if (Auth::user()->created_at->diffInHours(now(), false) > 1 ||
                    strtolower(config('SETTINGS::USER:FORCE_EMAIL_VERIFICATION')) == 'true')
              <x-alert title="You have not yet verified your email address!" type="warn" class="mt-6 mb-0">
                <p>
                  <a class="text-primary underline"
                    href="{{ route('verification.send') }}">{{ __('Resend verification email') }}</a>
                  <br>
                  {{ __('Please contact support If you didnt receive your verification email.') }}
                </p>
              </x-alert>
            @endif
          @endif

          @yield('content')
        </div>

        <footer
          class="p-4 mt-4 bg-white shadow-md dark:bg-gray-800 flex flex-col sm:flex-row justify-between items-center">
          <div>
            Copyright &copy; 2021-{{ date('Y') }} <a
              href="{{ url('/') }}">{{ env('APP_NAME', 'Laravel') }}</a>.
            All rights
            reserved. <br />Powered by <a href="https://ctrlpanel.gg" class="text-purple-600 underline">CtrlPanel
              @if (!str_contains(config('BRANCHNAME'), 'main') && !str_contains(config('BRANCHNAME'), 'unknown'))
                [v{{ config('app')['version'] }} - {{ config('BRANCHNAME') }}]
              @endif
            </a> | <a href="https://market.ctrlpanel.gg/resources/resource/32-phoenix-theme/" target="__blank"
              class="text-purple-600 underline">Phoenix Theme [v1.8.0]</a>
          </div>
          <div>
            <x-information />
          </div>
        </footer>
      </main>
    </div>
  </div>
  @include('models.redeem_voucher_modal')
  {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script> --}}
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function() {
      $('[data-toggle="popover"]').popover();

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    });
  </script>
  <script>
    @if (Session::has('error'))
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        html: '{{ Session::get('error') }}',
      })
    @endif
    @if (Session::has('success'))
      Swal.fire({
        icon: 'success',
        title: '{{ Session::get('success') }}',
        position: 'bottom-end',
        showConfirmButton: false,
        background: '#343a40',
        toast: true,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
    @endif
    @if (Session::has('info'))
      Swal.fire({
        icon: 'info',
        title: '{{ Session::get('info') }}',
        position: 'bottom-end',
        showConfirmButton: false,
        background: '#343a40',
        toast: true,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
    @endif
  </script>
  @yield('scripts')

</body>

</html>
