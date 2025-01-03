<?php
require_once 'Observer.php';
require_once 'EmailService.php'; 

class SupplierObserver implements Observer {
    private $emailService;

    public function __construct() {
        $this->emailService = new EmailService(); 
    }

    public function update($subject, $supplierEmail, $product) {
        $subject = 'Product Removed from Inventory';
        $body = "
            <p>Dear Supplier,</p>
            <p>The following product has been removed from the inventory:</p>
            <ul>
                <li>Product ID: {$product['id']}</li>
                <li>Product Name: {$product['name']}</li>
                <li>Quantity: {$product['qty']}</li>
            </ul>
            <p>Thank you.</p>
            <p>Best regards,<br>
        ";

        
        $response = $this->emailService->sendEmail($supplierEmail, $subject, $body);
    }
}

?>
