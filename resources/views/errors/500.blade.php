@extends('layouts.app')

@section('title-block',  'Ошибка 500')

@section('content')
<h2 class="m-3 text-center h4">Ошибка 500 при работе приложения</h2>
<div class="text-center">
  <input class="btn btn-success" type="button" onclick="history.back();" value="Назад"/>
</div>
@endsection
