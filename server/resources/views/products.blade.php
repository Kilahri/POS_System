@extends('layouts.app') <!-- I-extend ang layout na ginawa mo -->

@section('content')
    <h2 class="text-xl font-bold mb-4">All Products</h2>
    <a href="#" class="bg-green-500 text-white px-3 py-1 rounded mb-2 inline-block">Add Product</a>

    <table class="table-auto w-full bg-white border">
        <thead>
            <tr>
                <th class="border px-2 py-1">Name</th>
                <th class="border px-2 py-1">Price</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody id="product-list"></tbody>
    </table>
@endsection

@push('scripts')
<script>
    axios.get('/api/products')
        .then(res => {
            let rows = '';
            res.data.forEach(p => {
                rows += `
                    <tr>
                        <td class="border px-2 py-1">${name}</td>
                        <td class="border px-2 py-1">₱${price}</td>
                        <td class="border px-2 py-1">
                            <a href="/products/${id}/edit" class="text-blue-500">Edit</a>
                            <button onclick="deleteProduct(${id})" class="text-red-500 ml-2">Delete</button>
                        </td>
                    </tr>`;
            });
            document.getElementById('product-list').innerHTML = rows;
        });

    function deleteProduct(id) {
        if (confirm('Are you sure?')) {
            axios.delete(`/api/products/${id}`)
                .then(() => location.reload());
        }
    }
</script>
@endpush
