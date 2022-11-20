@extends('layouts.master')

@section('title', 'Export')
@section('food', 'menu-open')
@section('food.active' , 'active')
@section('export' , 'active')

@section('content')
  <export-component :token="{ value: '{{ csrf_token() }}'}"></export-component>
@endsection
