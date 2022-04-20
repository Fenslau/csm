@foreach ($departments as $department)
  <option class="text-truncate" value="{{ $department }}">{{ $department }}</option>
@endforeach
