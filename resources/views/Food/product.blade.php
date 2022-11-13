@extends('layouts.master')

@section('title', 'Product')
@section('food', 'menu-open')
@section('food.active' , 'active')
@section('product' , 'active')

@section('content')
    <product :category="{{ $category }}"></product>
@endsection