<?php

require_once('Observer.php');  
require_once('Inventory.php'); 



 class BusinessOwnerObserver implements Observer {
    private $emailService;

    public function __construct() {
        $this->emailService = new EmailService(); 
    }

    public function update($subject, $boEmail, $product) {
        $subject = 'Product Removed from Inventory';
        $body = "
            <p>Dear Supplier,</p>
            <p>The following product has besadasdadasdasdasdasen removed from the inventory:</p>
            <ul>
                <li>Product ID: {$product['id']}</li>
                <li>Product Name: {$product['name']}</li>
                <li>Quantity: {$product['qty']}</li>
            </ul>
            <p>Thank you.</p>
            <p>Best regards,<br>
        ";

        
        $response = $this->emailService->sendEmail($boEmail, $subject, $body);
    }
}
?>
