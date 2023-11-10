<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice {
            width: 210mm;
            height: 297mm;
            padding: 20px;
            box-sizing: border-box;
        }

        .header,
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f2f2f2;
            margin-bottom: 20px;
        }

        .bill-to {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            margin-top: 20px;
            float: right;
        }
    </style>
</head>

<body>
    <div class="invoice">
        <div class="header">
            <h2>Your Company</h2>
            <p>123 Main Street, City</p>
            <p>Phone: (123) 456-7890</p>
            <p>Email: info@yourcompany.com</p>
        </div>

        <div class="main-content">
            <h3>Invoice #001</h3>
            <p>Date: November 10, 2023</p>

            <div class="bill-to">
                <h4>Bill To:</h4>
                <p>Customer Name</p>
                <p>Customer Address</p>
                <p>City, Country</p>
            </div>

            <table>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>Product 1</td>
                    <td>2</td>
                    <td>$50.00</td>
                    <td>$100.00</td>
                </tr>
                <tr>
                    <td>Product 2</td>
                    <td>1</td>
                    <td>$75.00</td>
                    <td>$75.00</td>
                </tr>
                <tr>
                    <td>Product 3</td>
                    <td>3</td>
                    <td>$30.00</td>
                    <td>$90.00</td>
                </tr>
            </table>

            <div class="total">
                <p>Subtotal: $265.00</p>
                <p>Tax (8%): $21.20</p>
                <h3>Total: $286.20</h3>
            </div>
        </div>

        <div class="footer">
            <p>Payment Due Date: November 30, 2023</p>
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>

</html>
