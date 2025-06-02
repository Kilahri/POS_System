import React from 'react';
import './Order.css';
import Sidebar from '../../components/Sidebar.tsx';
import OrderPage from '../../components/OrderPage.tsx';

function Order() {
  return (
    <div className="min-h-screen bg-gray-100 flex">
      <Sidebar />


        
        <div >
          <OrderPage />
         
        </div>
      </div>
  );
}

export default Order;
