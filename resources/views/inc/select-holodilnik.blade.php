@foreach ($holodilniks as $holodilnik)
  <option class="text-truncate" value="{{ $holodilnik }}" @if(!empty($request->holodilnik) AND $holodilnik == $request->holodilnik) selected @endif>{{ $holodilnik }}</option>
@endforeach
