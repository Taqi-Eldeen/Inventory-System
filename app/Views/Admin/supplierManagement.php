<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Suppliers</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/supplierManagement.css">
</head>
<body>

    <?php require 'sidebaradmin.php'; ?>

    <div class="main-content">
        <div class="content">
            <h1>Supplier Management</h1>

            <div class="supplier-management-container">
                <div class="form-container">
                    <h2>Add Supplier</h2>
                    <form>
                        <label for="supplier-name">Supplier Name:</label>
                        <input type="text" id="supplier-name" name="supplier_name" required>

                        <label for="supplier-contact">Contact Details (Phone/Email):</label>
                        <input type="text" id="supplier-contact" name="supplier_contact" required>

                        <label for="payment-terms">Payment Terms:</label>
                        <input type="text" id="payment-terms" name="payment_terms" required>

                        <label for="products-supplied">Products Supplied:</label>
                        <textarea id="products-supplied" name="products_supplied" rows="4"></textarea>

                        <button type="submit">Add Supplier</button>
                    </form>
                </div>

                <div class="supplier-table">
                    <h2>Manage Suppliers</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Supplier Name</th>
                                <th>Contact Details</th>
                                <th>Payment Terms</th>
                                <th>Products Supplied</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Supplier 1</td>
                                <td>supplier1@example.com / +123456789</td>
                                <td>Net 30 Days</td>
                                <td>Product A, Product B</td>
                                <td>
                                    <button class="edit-btn">Edit</button>
                                    <button class="remove-btn">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Supplier 2</td>
                                <td>supplier2@example.com / +987654321</td>
                                <td>Cash on Delivery</td>
                                <td>Product X, Product Y</td>
                                <td>
                                    <button class="edit-btn">Edit</button>
                                    <button class="remove-btn">Remove</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
