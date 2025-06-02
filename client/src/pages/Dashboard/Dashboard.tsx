import React from 'react';
import './Dashboard.css';
import Sidebar from '../../components/Sidebar.tsx';

const Dashboard: React.FC = () => {
  return (
    <div className="flex flex-col lg:flex-row">
      <Sidebar />

      <main className="flex-1 p-4 font-sans mt-16 lg:mt-0 lg:ml-64 min-h-screen">
        {/* Header */}
        <header className="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
          <h1 className="text-3xl font-bold text-green-800">Dashboard</h1>
          <div className="flex items-center space-x-4">
            <span className="text-green-700">Hello, TeaMaster</span>
            <img
              src="https://i.pravatar.cc/40"
              alt="User Avatar"
              className="w-10 h-10 rounded-full border-2 border-green-300"
            />
          </div>
        </header>

        {/* Stat Cards */}
        <section className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
          <div className="bg-white p-4 rounded-xl shadow hover:shadow-lg transition">
            <h2 className="text-sm text-gray-500">Total Orders</h2>
            <p className="text-2xl font-bold text-green-800">1,284</p>
          </div>
          <div className="bg-white p-4 rounded-xl shadow hover:shadow-lg transition">
            <h2 className="text-sm text-gray-500">Revenue</h2>
            <p className="text-2xl font-bold text-green-800">₱24,560</p>
          </div>
          <div className="bg-white p-4 rounded-xl shadow hover:shadow-lg transition">
            <h2 className="text-sm text-gray-500">Best Seller</h2>
            <p className="text-2xl font-bold text-green-800">Matcha Latte</p>
          </div>
          <div className="bg-white p-4 rounded-xl shadow hover:shadow-lg transition">
            <h2 className="text-sm text-gray-500">Low Stock Items</h2>
            <p className="text-2xl font-bold text-red-500">4</p>
          </div>
        </section>

       {/* Navigation Section */}
<section className="bg-white p-6 rounded-xl shadow-md">
  <h3 className="text-xl font-semibold text-green-800 mb-4">Manage</h3>
  <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <a
      href="#"
      className="block border p-6 rounded-xl text-center hover:shadow transition hover:bg-green-50"
    >
      <h4 className="font-bold text-green-700 text-lg">Actions</h4>
      <p className="text-sm text-gray-500">Manage quick tasks and updates</p>
    </a>
    <a
      href="#"
      className="block border p-6 rounded-xl text-center hover:shadow transition hover:bg-green-50"
    >
      <h4 className="font-bold text-green-700 text-lg">Orders</h4>
      <p className="text-sm text-gray-500">View and manage customer orders</p>
    </a>
    <a
      href="#"
      className="block border p-6 rounded-xl text-center hover:shadow transition hover:bg-green-50"
    >
      <h4 className="font-bold text-green-700 text-lg">Transactions</h4>
      <p className="text-sm text-gray-500">Track payments and sales history</p>
    </a>
    <a
      href="#"
      className="block border p-6 rounded-xl text-center hover:shadow transition hover:bg-green-50"
    >
      <h4 className="font-bold text-green-700 text-lg">Users</h4>
      <p className="text-sm text-gray-500">Manage staff or customer accounts</p>
    </a>
  </div>
</section>

      </main>
    </div>
  );
};

export default Dashboard;