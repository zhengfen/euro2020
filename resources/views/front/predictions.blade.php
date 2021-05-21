@extends('layouts.app')

@section('content')
<predictions-view :groups="{{ $groups }}"  :teams="{{ $teams }}" :games="{{ $games }}" :stadiums="{{ $stadiums }}" :predictions="{{ $predictions }}"
></predictions-view>
@endsection
