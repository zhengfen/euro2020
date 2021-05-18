@extends('layouts.app')

@section('content')
<pronostics :groups="{{ $groups }}"  :teams="{{ $teams }}" :matches="{{ $matches }}" :stadiums="{{ $stadiums }}" :pronostics="{{ $pronostics }}"
></pronostics>
@endsection
