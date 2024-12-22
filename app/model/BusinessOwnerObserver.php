<?php
// BusinessOwnerObserver.php
require_once('Observer.php');  // Include the Observer interface
require_once('Inventory.php'); // Include the Inventory class if needed


// BusinessOwnerObserver class
 class BusinessOwnerObserver implements Observer {
    private $emailService;

    public function __construct() {
        $this->emailService = new EmailService(); // Instantiate EmailService
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

        // Use EmailService to send the email
        $response = $this->emailService->sendEmail($boEmail, $subject, $body);
    }
}
?>
