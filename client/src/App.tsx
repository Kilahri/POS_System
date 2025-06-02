import React from 'react';

import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import  Login  from './pages/Login/Login.tsx';
import Dashboard from './pages/Dashboard/Dashboard.tsx';
import Order from './pages/Order/Order.tsx'
import Products from './pages/Products/Products.tsx'
import Transaction from './pages/Transaction/Transaction.tsx'
import Receipt from './pages/Receipt/Receipt.tsx';
import './App.css';



function App ()  {
  return (
     <Router>

      
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/dashboard" element={<Dashboard />} />
        <Route path="/order" element={<Order />} />
        <Route path="/api/products" element={<Products />} />
        <Route path="/transaction" element={<Transaction />} />
        <Route path="/receipt" element={<Receipt />} />
      </Routes>
    </Router>
  );
}

export default App;