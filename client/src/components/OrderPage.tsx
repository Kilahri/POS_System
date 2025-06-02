import React from "react";

function OrderPage() {
  return (
    <div className="min-h-screen w-full bg-amber-50 border-4 border-blue-300 p-6">
      {/* Top bar */}
      <div className="flex justify-between items-center p-4 border-b border-blue-300 rounded bg-white">
        <h1 className="text-xl font-semibold text-blue-900">POSsibilitea</h1>
        <button className="border px-4 py-2 rounded bg-white hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
          LOG OUT
        </button>
      </div>

      {/* Main content */}
      <div className="flex flex-col lg:flex-row gap-4 p-4 w-full">
        {/* Left Panel */}
        <div className="w-full lg:w-2/3 space-y-4">
          {/* Search and Filter Row */}
          <div className="flex flex-wrap items-center gap-2">
            <input
              type="text"
              placeholder="Search..."
              className="border rounded px-3 py-2 flex-1 min-w-[200px] focus:outline-none focus:ring-2 focus:ring-blue-500"
              aria-label="Search products"
            />
            <button
              className="px-3 py-2 border rounded bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
              aria-label="Previous category"
            >
              &lt;
            </button>
            <select
              className="border rounded px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
              aria-label="Filter category"
            >
              <option>All</option>
              <option>Drinks</option>
              <option>Snacks</option>
            </select>
            <button
              className="px-3 py-2 border rounded bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
              aria-label="Next category"
            >
              &gt;
            </button>
          </div>

          {/* Product Grid */}
          <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-3">
            {Array.from({ length: 8 }).map((_, i) => (
              <div
                key={i}
                className="bg-white rounded border p-2 flex flex-col items-center text-xs"
                style={{ maxHeight: "180px" }}
              >
                <div
                  className="bg-gray-200 flex items-center justify-center w-full rounded mb-2 text-gray-400"
                  style={{ height: "90px" }}
                >
                 Image
                </div>
                <h3 className="font-semibold truncate w-full text-center leading-tight">
                  Product {i + 1}
                </h3>
                <p className="text-gray-700">$19.99</p>
                <input
                  id={`quantity-${i}`}
                  type="number"
                  min="1"
                  defaultValue="1"
                  className="w-12 border rounded px-1 py-0.5 text-center mb-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  aria-label={`Quantity for product ${i + 1}`}
                />
                <button
                  type="button"
                  className="text-[#000000] rounded px-2 py-0.5 hover:bg-blue-700 transition w-full text-[11px] focus:outline-none focus:ring-2 focus:ring-blue-500"
                  onClick={() => alert(`Added Product ${i + 1} to cart`)}
                >
                  Add
                </button>
              </div>
            ))}
          </div>

          {/* Settings Button */}
          <button className="mt-2 px-4 py-2 border rounded bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Settings
          </button>
        </div>

        {/* Right Panel: Order Summary */}
        <div className="w-full lg:w-1/3 bg-white border rounded p-4 space-y-4 flex flex-col">
          <div className="h-40 border border-dashed flex items-center justify-center rounded">
            <p className="text-gray-500">Order Items List</p>
          </div>

          <button className="border px-3 py-1 rounded bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Apply Discount
          </button>

          {/* Totals */}
          <div className="space-y-1 text-right">
            <p>
              Subtotal: <strong>₱ 60.00</strong>
            </p>
            <p>
              Discounted Total: <strong>₱ 48.00</strong>
            </p>
            <p className="font-bold text-lg">Grand Total: ₱ 48.00</p>
          </div>

          {/* Action Buttons */}
          <div className="flex gap-2 mt-auto">
            <button className="flex-1 px-4 py-2 bg-red-400 text-black rounded hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-600">
              Cancel Order
            </button>
            <button className="flex-1 px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-900">
              Pay
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default OrderPage;
