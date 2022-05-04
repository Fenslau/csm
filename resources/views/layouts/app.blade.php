<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title-block')</title>
  <meta name="description" content="@yield('description-block')">
  <meta name="csrf-token" content="{{ csrf_token() }}" />


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css">
  <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
</head>
<body>
<header class="sticky-top">
  @include('inc.header')
</header>

  @include('inc.messages')
<main>
  @include('inc.toast')  
  @yield('content')
</main>
<footer>
  @include('inc.footer')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

  <script src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.proto.js"></script>
  <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="//cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="//cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
  <script src="//cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
  <script src="{{ mix('/js/app.js') }}"></script>
</footer>
</body>
</html>
