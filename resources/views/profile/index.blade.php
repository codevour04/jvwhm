@extends('layouts.create')

@section('title', 'Profile')

@section('content')
 	
    <profile user="{{ $person }}" people="{{ $people }}"></profile>
  
@endsection