
import axios from "axios";

import { useState } from "react";

export default function EcommerceCard() {
  const [quantity, setQuantity] = useState(1);

  const increaseQuantity = () => setQuantity((q) => q + 1);
  const decreaseQuantity = () =>
    setQuantity((q) => (q > 1 ? q - 1 : 1));

  return (
    <div className="bg-white rounded-2xl shadow-md p-4 w-full max-w-sm mx-auto">
      <img
        className="w-full h-64 object-cover rounded-xl"
        src="https://images.unsplash.com/photo-1629367494173-c78a56567877?auto=format&fit=crop&w=800&q=80"
        alt="Product"
      />
      <div className="py-4">
        <h2 className="text-xl font-semibold text-gray-800">
          Apple AirPods
        </h2>
       
        <p className="text-lg font-bold text-gray-900 mt-3">$95.00</p>
      </div>

      <div className="flex items-center justify-between mt-4">
        <div className="flex items-center border border-gray-300 rounded-lg">
          <button
            onClick={decreaseQuantity}
            className="px-3 py-1 text-xl font-semibold text-gray-700 hover:bg-gray-100"
          >
            −
          </button>
          <span className="px-4 py-1 text-gray-900">{quantity}</span>
          <button
            onClick={increaseQuantity}
            className="px-3 py-1 text-xl font-semibold text-gray-700 hover:bg-gray-100"
          >
            +
          </button>
        </div>

        <button className="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
          Add to Cart
        </button>
      </div>
    </div>
  );
}
