@extends('layouts.app')

@section('content')
<predictions-view :predictions="{{ $predictions }}" 
></predictions-view>
@endsection
