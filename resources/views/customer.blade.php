@extends('layouts.master')

@section('title', 'Customer')
@section('customer' , 'active')

@section('content')
    <customer :token="{ value: '{{ csrf_token() }}'}"></customer> 
@endsection