@extends('layouts.home')

@section('title', 'View')
@section('view' , 'active')

@section('content')
 <home :orders ="{ categories: {{ $category }}, tables: {{ $table }}}"></home>
@endsection
