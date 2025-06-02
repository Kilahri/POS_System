@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Add New Product</h2>

<form id="product-form" class="space-y-4">
    <input type="text" name="name" placeholder="Product Name" class="border p-2 w-full" required>
    <input type="number" name="price" placeholder="Price" class="border p-2 w-full" required>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2">Save</button>
</form>
@endsection

@push('scripts')
<script>
    document.getElementById('product-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const data = new FormData(this);

        axios.post('/api/products', {
            name: data.get('name'),
            price: data.get('price')
        }).then(() => {
            window.location.href = "/products";
        });
    });
</script>
@endpush
