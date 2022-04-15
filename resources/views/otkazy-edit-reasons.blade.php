@extends('layouts.app')

@section('title-block', 'Редактирование причин отказов ЦСМ')
@section('description-block', '')

@section('content')

<div class="container">
  <div class="row">
    <div class="col">
      {{ Breadcrumbs::render('reason') }}
      <h4 class="mb-3 text-center">Редактирование причин отказов</h4>
      <form action="{{ route('reason-add') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" autocomplete="off" class="border-success border-right-0 form-control" name="reason" placeholder="Причина отказа">
          <div class="input-group-append">
            <button class="btn btn-outline-success text-nowrap shadow-none" type="submit">Добавить причину</button>
          </div>
        </div>
      </form>
      <div class="d-flex flex-column mt-3 p-3 shadow border">
          <h5 class="mb-3 text-center">Все причины</h5>
          <div class="py-3 d-flex flex-wrap">
            @forelse ($reasons as $reason)
              <div class="m-2 p-1 px-2 bg-light rounded border max-content input-group">
                {{ $reason->reason }}
                <div class="input-group-append">
                  <button url="{{ route('reason-del') }}" name="{{ $reason->id }}" type="button" class="close pl-2 text-danger del-reason">
                    <span>&times;</span>
                  </button>
                </div>
              </div>
            @empty
              Ни одной причины не найдено
            @endforelse
          </div>
      </div>
    </div>
  </div>
</div>

@endsection
