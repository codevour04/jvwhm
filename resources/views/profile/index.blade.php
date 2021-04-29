@extends('layouts.backend')

@section('title', 'Profile')

@section('content')
 	
    <profile leader="{{ $person->fullname }}" people="{{ $people }}"></profile>
  
@endsection