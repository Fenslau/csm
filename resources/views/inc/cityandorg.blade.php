@empty(auth()->user()->city)
  <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
    <label class="mr-3" for="city">Город: </label>
    <select id="city" class="form-control text-truncate chosen-select" name="city">
      @foreach ($cities as $city)
        <option class="text-truncate" value="{{ $city }}" @if(!empty(auth()->user()->city) AND $city == auth()->user()->city) selected @endif>{{ $city }}</option>
      @endforeach
    </select>
  </div>
@else
  <input type="hidden" name="city" value="{{ auth()->user()->city }}">
@endempty
@empty(auth()->user()->organization)
  <div class="d-flex flex-nowrap justify-content-between align-items-baseline form-group m-1">
    <label class="mr-3" for="organization">Организация: </label>
    <select id="organization" class="form-control text-truncate chosen-select" name="organization">
      @foreach ($organizations as $organization)
        <option class="text-truncate" value="{{ $organization }}" @if(!empty(auth()->user()->organization) AND $organization == auth()->user()->organization) selected @endif>{{ $organization }}</option>
      @endforeach
    </select>
  </div>
@else
  <input type="hidden" name="organization" value="{{ auth()->user()->organization }}">
@endempty
