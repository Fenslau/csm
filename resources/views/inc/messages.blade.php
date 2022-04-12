@if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
      <ul class="m-0">
        @foreach ($errors->all() as $formerror)
          <li>
            {{ $formerror }}
            <button type="button" class="close" data-dismiss="alert">
              <span>&times;</span>
            </button>
          </li>
        @endforeach
      </ul>
    </div>
@endif

@php ($sessions = ['success' => 'success', 'danger' => 'error', 'warning' => 'warning', 'info' => 'info'])
@foreach ($sessions as $class => $session)
  @if (session($session))
      <div class="alert alert-{{ $class }} alert-dismissible">
        {!! (session($session)) !!}
        <button type="button" class="close" data-dismiss="alert">
          <span>&times;</span>
        </button>
      </div>
  @endif
@endforeach
