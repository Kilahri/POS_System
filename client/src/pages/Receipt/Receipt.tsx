import React from "react";
import './Receipt.css';
import Sidebar from "../../components/Sidebar";
import { useLocation } from "react-router-dom";

const Receipt: React.FC = () => {
  const location = useLocation();
  const { transaction, farewellMessage } = location.state || {};

  if (!transaction) {
    return (
      <div className="flex">
        <Sidebar />
        <div className="p-6">No transaction data.</div>
      </div>
    );
  }

  return (
    <div className="flex">
      <Sidebar />
      <div className="receipt-container p-4 text-sm max-w-xl mx-auto border rounded shadow bg-white flex-1">
        <div className="header text-center mb-4">
          <div className="text-xl font-bold">Possibilitea</div>
          <div className="text-gray-600">
            123 Tea Street, Tea City<br />
            Phone: +1-234-567-8900<br />
            Email: info@possibilitea.com
          </div>
        </div>

        <div className="transaction-info flex justify-between mb-4">
          <div>
            <strong>Transaction #:</strong> {transaction.transaction_number}<br />
            <strong>Date:</strong> {transaction.transaction_date}<br />
            <strong>Cashier:</strong> {transaction.user_name}
          </div>
          <div className="text-right">
            {transaction.customer_name && (
              <>
                <strong>Customer:</strong> {transaction.customer_name}<br />
              </>
            )}
            <strong>Payment:</strong> {transaction.payment_method}
          </div>
        </div>

        <table className="items-table w-full border-t border-b mb-4">
          <thead className="bg-gray-100">
            <tr>
              <th className="text-left p-2">Item</th>
              <th className="text-left p-2">Qty</th>
              <th className="text-right p-2">Price</th>
              <th className="text-right p-2">Total</th>
            </tr>
          </thead>
          <tbody>
            {transaction.items.map((item: any, index: number) => (
              <tr key={index} className="border-t">
                <td className="p-2">{item.name}</td>
                <td className="p-2">{item.quantity}</td>
                <td className="p-2 text-right">${item.unit_price.toFixed(2)}</td>
                <td className="p-2 text-right">${item.total_price.toFixed(2)}</td>
              </tr>
            ))}
          </tbody>
        </table>

        <div className="totals space-y-1 mb-6">
          <div className="flex justify-between">
            <span>Subtotal:</span>
            <span>${transaction.subtotal.toFixed(2)}</span>
          </div>
          {transaction.discount_amount > 0 && (
            <div className="flex justify-between">
              <span>Discount:</span>
              <span>-${transaction.discount_amount.toFixed(2)}</span>
            </div>
          )}
          <div className="flex justify-between">
            <span>Tax:</span>
            <span>${transaction.tax_amount.toFixed(2)}</span>
          </div>
          <div className="flex justify-between font-bold text-lg">
            <span>Total:</span>
            <span>${transaction.total_amount.toFixed(2)}</span>
          </div>
          <div className="flex justify-between">
            <span>Paid:</span>
            <span>${transaction.paid_amount.toFixed(2)}</span>
          </div>
          {transaction.change_amount > 0 && (
            <div className="flex justify-between">
              <span>Change:</span>
              <span>${transaction.change_amount.toFixed(2)}</span>
            </div>
          )}
        </div>

        <div className="footer text-center text-gray-600 text-xs">
          {farewellMessage && (
            <div className="farewell-message italic text-sm mb-4">
              "{farewellMessage}"
            </div>
          )}

          <div className="feedback-section mb-4">
            <h3 className="font-semibold">How was your experience?</h3>
            <p>We'd love to hear your feedback about your purchase and our service.</p>
            <a
              href={`https://your-app-url.com/feedback/${transaction.transaction_number}`}
              className="inline-block mt-2 px-4 py-1 text-white bg-blue-500 rounded hover:bg-blue-600"
            >
              Leave Feedback
            </a>
          </div>

          <p className="mt-6">
            This is an automated receipt. Please keep this for your records.<br />
            For questions, contact info@possibilitea.com
          </p>
        </div>
      </div>
    </div>
  );
};

export default Receipt;
