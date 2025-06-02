@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Welcome to POS System</h1>
    <a href="{{ route('products.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">View Products</a>
@endsection
