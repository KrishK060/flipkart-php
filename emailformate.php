<html>
<head>
  <link href="/assests/css/emailformate.css" rel="stylesheet">
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
        <th>discount</th>
        <th>totalAmount</th>
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