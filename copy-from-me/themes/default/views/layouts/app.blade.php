<?php
$themeClass = 'dark';
if (!empty($_COOKIE['theme'])) {
    $themeClass = $_COOKIE['theme'];
}
?>

<!DOCTYPE html>
<html :class="{ 'dark': dark }" x-data="data" lang="en" id="html" class="<?php echo $themeClass; ?>">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta content="{{ config('SETTINGS::SYSTEM:SEO_TITLE') }}" property="og:title">
  <meta content="{{ config('SETTINGS::SYSTEM:SEO_DESCRIPTION') }}" property="og:description">
  <meta
    content='{{ \Illuminate\Support\Facades\Storage::disk('public')->exists('logo.png') ? asset('storage/logo.png') : asset('images/controlpanel_logo.png') }}'
    property="og:image">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'ControlPanel') }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

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

  <script defer src="{{ asset('js/app.js') }}" defer></script>

  @if (config('SETTINGS::RECAPTCHA:ENABLED') == 'true')
    {!! htmlScriptTagJsApi() !!}
  @endif
</head>

<body>
  <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900 dark:text-gray-300 text-gray-700">
    @yield('content')
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.14.1/dist/sweetalert2.all.min.js"></script>
  <script>
    @if (Session::has('error'))
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        html: "{{ Session::get('error') }}",
      })
    @endif

    @if (Session::has('success'))
      Swal.fire({
        icon: 'success',
        title: "{{ Session::get('success') }}",
        position: 'top-end',
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

</body>

</html>
