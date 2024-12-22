<?php
interface Observer {
    public function update($subject, $supplierEmail, $product); // Add $product parameter
}
?>
