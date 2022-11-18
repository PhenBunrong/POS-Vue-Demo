@extends('layouts.master')

@section('title', 'Table')
@section('table' , 'active')

@section('content')
  <table-form :token="{ value: '{{ csrf_token() }}'}"></table-form>
@endsection
