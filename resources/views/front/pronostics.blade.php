@extends('layouts.app')

@section('content')
<pronostics-view :groups="{{ $groups }}"  :teams="{{ $teams }}" :games="{{ $games }}" :stadiums="{{ $stadiums }}" :pronostics="{{ $pronostics }}"
></pronostics-view>
@endsection
