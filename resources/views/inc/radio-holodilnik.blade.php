@foreach ($holodilniks as $holodilnik)
    <label class="btn btn-outline-info shadow-none mr-3">
      <input type="radio" name="holodilnik" value="{{ $holodilnik }}" autocomplete="off"> {{ $holodilnik }}
    </label>
@endforeach
