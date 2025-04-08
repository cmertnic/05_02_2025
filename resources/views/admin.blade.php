@extends('layouts.main')

@section('content')
    @foreach ($works as $work)
        <x-admin-card :work="$work" />
    @endforeach
@endsection
