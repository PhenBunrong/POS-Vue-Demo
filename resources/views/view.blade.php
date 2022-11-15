@extends('layouts.home')

@section('title', 'View')
@section('view' , 'active')

@section('content')
 <home :orders ="{ tables: {{ $table }}, customers: {{ $customer }}}"></home>
@endsection
