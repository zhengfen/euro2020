@extends('layouts.admin')

@section('content')
<game-index :teams="{{ $teams }}" :stadiums="{{ $stadiums }}" :groups="{{ $groups }}"></game-index>
@endsection
