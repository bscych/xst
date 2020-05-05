@if($schools->count()>1)
 <div class="dropdown-divider"></div>
@foreach($schools as $school)
    <a class="dropdown-item" href="{{ route('switchSchool',['school_id'=>$school->id]) }}">
    {{ $school->name }}
</a>
@endforeach

@endif
