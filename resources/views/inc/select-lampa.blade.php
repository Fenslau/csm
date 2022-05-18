@foreach ($lampas as $lampa)
  <option class="text-nowrap" value="{{ $lampa }}" @if(!empty(session('lampa')) AND $lampa == session('lampa')) selected @endif>{{ $lampa }}</option>
@endforeach
