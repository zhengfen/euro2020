@extends('layouts.app')

@section('content')
<phase-view :groups="{{ $groups }}"  :teams="{{ $teams }}" :games="{{ $games }}" :stadiums="{{ $stadiums }}"
></phase-view>
@endsection
