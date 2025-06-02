import React, { useEffect, useState } from "react";
import axios from "../utils/Axiosinstance"; // Your configured Axios instance

interface Category {
  id: number;
  name: string;
}

interface Product {
  id: number;
  name: string;
  price: string;
  sku: string;
  stock_quantity: number;
  category?: Category;
}

const Products: React.FC = () => {
  const [products, setProducts] = useState<Product[]>([]);
  const [loading, setLoading] = useState<boolean>(true);

  useEffect(() => {
    axios.get("api/products")
      .then(response => {
        setProducts(response.data.products.data);
      })
      .catch(error => {
        console.error("Failed to fetch products", error);
      })
      .finally(() => setLoading(false));
  }, []);

  if (loading) return <div>Loading products...</div>;

  return (
    <div className="p-4">
  <h2 className="text-2xl font-bold mb-4">Products</h2>

  <div className="overflow-x-auto">
    <table className="min-w-full bg-white border border-gray-200 shadow rounded-lg">
      <thead className="bg-gray-100">
        <tr>
          <th className="text-left px-4 py-2 border-b">Name</th>
          <th className="text-left px-4 py-2 border-b">Price</th>
          <th className="text-left px-4 py-2 border-b">SKU</th>
          <th className="text-left px-4 py-2 border-b">Stock</th>
          <th className="text-left px-4 py-2 border-b">Category</th>
        </tr>
      </thead>
      <tbody>
        {products.map(product => (
          <tr key={product.id} className="hover:bg-gray-50">
            <td className="px-4 py-2 border-b">{product.name}</td>
            <td className="px-4 py-2 border-b">₱{product.price}</td>
            <td className="px-4 py-2 border-b">{product.sku}</td>
            <td className="px-4 py-2 border-b">{product.stock_quantity}</td>
            <td className="px-4 py-2 border-b">
              {product.category?.name ?? "—"}
            </td>
          </tr>
        ))}
      </tbody>
    </table>
  </div>
</div>

  );
};

export default Products;
