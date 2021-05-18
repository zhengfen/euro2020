@extends('layouts.admin')

@section('content')
<match-index :teams="{{ $teams }}" :stadiums="{{ $stadiums }}" :groups="{{ $groups }}"></match-index>
@endsection
