@extends('layouts.app')

@section('content')
<match-phase :groups="{{ $groups }}"  :teams="{{ $teams }}" :matches="{{ $matches }}" :stadiums="{{ $stadiums }}"
></match-phase>
@endsection
