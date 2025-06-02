import React from 'react';
import { useNavigate } from 'react-router-dom';

const TransactionTable = () => {
  const navigate = useNavigate();

  // Example dummy data; in real use, you'd fetch this from an API
  const transactions = [
    {
      transaction_number: 'TXN123456',
      transaction_date: 'Jun 01, 2025 14:30',
      user_name: 'John Doe',
      customer_name: 'Jane Smith',
      payment_method: 'Cash',
      items: [
        { name: 'Green Tea', quantity: 2, unit_price: 3.5, total_price: 7.0 },
        { name: 'Milk Tea', quantity: 1, unit_price: 4.0, total_price: 4.0 },
      ],
      subtotal: 11.0,
      discount_amount: 1.0,
      tax_amount: 0.55,
      total_amount: 10.55,
      paid_amount: 15.0,
      change_amount: 4.45,
    },
  ];

  const handleViewReceipt = (transaction: any) => {
    navigate('/receipt', {
      state: {
        transaction,
        farewellMessage: 'Thank you for ordering at Possibilitea!',
      },
    });
  };

  return (
    <div className="p-4 w-full">
      <h2 className="text-xl font-semibold mb-4">Transactions</h2>
      <table className="w-full border">
        <thead className="bg-gray-200">
          <tr>
            <th className="p-2">Transaction #</th>
            <th className="p-2">Date</th>
            <th className="p-2">Cashier</th>
            <th className="p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          {transactions.map((txn, idx) => (
            <tr key={idx} className="border-t">
              <td className="p-2">{txn.transaction_number}</td>
              <td className="p-2">{txn.transaction_date}</td>
              <td className="p-2">{txn.user_name}</td>
              <td className="p-2">
                <button
                  className="bg-blue-500 hover:bg-blue-600 text-black px-3 py-1 rounded"
                  onClick={() => handleViewReceipt(txn)}
                >
                  View Receipt
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default TransactionTable;
