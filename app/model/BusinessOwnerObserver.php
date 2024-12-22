<?php
// BusinessOwnerObserver.php
require_once('Observer.php');  // Include the Observer interface
require_once('Inventory.php'); // Include the Inventory class if needed


// BusinessOwnerObserver class
 class BusinessOwnerObserver implements Observer {
    public function update($subject, $supplierEmail, $product) {
        // Call the function to send the product added notification
        $this->sendEmailNotification($businessOwnerEmail);
    }

    private function sendEmailNotification($businessOwnerEmail) {
        $subject = 'Product Added Notification';
        $message = 'Dear Business Owner,<br><br>A product has been added to your inventory.<br><br>Best regards,<br>Your Company Name';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        if (mail($businessOwnerEmail, $subject, $message, $headers)) {
            echo 'Notification sent to business owner successfully.';
        } else {
            echo 'Failed to send email to business owner.';
        }
    }
}
?>
