<html>
<head>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
    .container { background: #fff; padding: 20px; border-radius: 8px; }
    h2 { color: #333; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    th { background: #007bff; color: white; }
    .footer { margin-top: 30px; font-size: 14px; color: #888; text-align: center; }
  </style>
</head>
<body>
  <div class='container'>
    <h2>Hello <?= htmlspecialchars($username) ?></h2>
    <p>Thank you for your order! Here are your details:</p>
    <p><strong>Order ID:</strong> <?= $order_id ?></p>
    <p><strong>Transaction Date:</strong> <?= $order_date ?></p>
    <p><strong>Amount Paid:</strong> ₹<?= $amount ?></p>
    <p><strong>Transaction ID:</strong> <?= $transactionId ?></p>
    <table>
      <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
      </tr>
      <?= $product_rows ?>
    </table>

    <div class='footer'>
      <p>Need help? Email us at support@specialagency.com</p>
      <p>&copy; <?= date("Y") ?> special agency</p>
    </div>
  </div>
</body>
</html>
