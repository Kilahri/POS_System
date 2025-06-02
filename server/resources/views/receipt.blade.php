<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt - Possibilitea</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .receipt-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2d3748;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .business-name {
            font-size: 28px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 10px;
        }
        .business-info {
            color: #666;
            font-size: 14px;
        }
        .transaction-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .transaction-info div {
            flex: 1;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th,
        .items-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .items-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .price-column {
            text-align: right;
        }
        .totals {
            border-top: 2px solid #2d3748;
            padding-top: 15px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .total-row.final {
            font-weight: bold;
            font-size: 18px;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            margin-top: 8px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .farewell-message {
            font-style: italic;
            color: #4a5568;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .feedback-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .feedback-button {
            display: inline-block;
            background-color: #38a169;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <div class="business-name">Possibilitea</div>
            <div class="business-info">
                123 Tea Street, Tea City<br>
                Phone: +1-234-567-8900<br>
                Email: info@possibilitea.com
            </div>
        </div>

        <div class="transaction-info">
            <div>
                <strong>Transaction #:</strong> {{ $transaction->transaction_number }}<br>
                <strong>Date:</strong> {{ $transaction->transaction_date->format('M d, Y H:i') }}<br>
                <strong>Cashier:</strong> {{ $transaction->user->name }}
            </div>
            <div style="text-align: right;">
                @if($transaction->customer_name)
                    <strong>Customer:</strong> {{ $transaction->customer_name }}<br>
                @endif
                <strong>Payment:</strong> {{ ucfirst($transaction->payment_method) }}
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th class="price-column">Price</th>
                    <th class="price-column">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="price-column">${{ number_format($item->unit_price, 2) }}</td>
                    <td class="price-column">${{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>${{ number_format($transaction->subtotal, 2) }}</span>
            </div>
            @if($transaction->discount_amount > 0)
            <div class="total-row">
                <span>Discount:</span>
                <span>-${{ number_format($transaction->discount_amount, 2) }}</span>
            </div>
            @endif
            <div class="total-row">
                <span>Tax:</span>
                <span>${{ number_format($transaction->tax_amount, 2) }}</span>
            </div>
            <div class="total-row final">
                <span>Total:</span>
                <span>${{ number_format($transaction->total_amount, 2) }}</span>
            </div>
            <div class="total-row">
                <span>Paid:</span>
                <span>${{ number_format($transaction->paid_amount, 2) }}</span>
            </div>
            @if($transaction->change_amount > 0)
            <div class="total-row">
                <span>Change:</span>
                <span>${{ number_format($transaction->change_amount, 2) }}</span>
            </div>
            @endif
        </div>

        <div class="footer">
            @if($farewellMessage)
            <div class="farewell-message">
                "{{ $farewellMessage->message }}"
            </div>
            @endif

            <div class="feedback-section">
                <h3>How was your experience?</h3>
                <p>We'd love to hear your feedback about your purchase and our service.</p>
                <a href="{{ config('app.url') }}/feedback/{{ $transaction->id }}" class="feedback-button">
                    Leave Feedback
                </a>
            </div>

            <p style="color: #666; font-size: 12px; margin-top: 20px;">
                This is an automated email receipt. Please keep this for your records.<br>
                If you have any questions, please contact us at info@possibilitea.com
            </p>
        </div>
    </div>
</body>
</html> 