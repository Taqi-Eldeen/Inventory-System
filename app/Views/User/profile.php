<?php
include_once 'sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="sidebar.css" rel="stylesheet">
</head>

<body>

    <div class="container" style="margin-top: 50px;">

        <div class="row">
         
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">User  Details</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUser Modal">Edit Details</button>
                    </div>
                    <div class="card-body">
                        <p><strong>Business Name:</strong> <span id="displayBusinessName">Business Name</span></p>
                        <p><strong>Business Email:</strong> <span id="displayBusinessEmail">business@example.com</span></p>
                        <p><strong>Phone Number:</strong> <span id="displayPhoneNumber">+1234567890</span></p>
                        <p><strong>Location:</strong> <span id="displayLocation">City, Country</span></p>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Current Suppliers</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Supplier Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Supplier A</td>
                                    <td>supplierA@example.com</td>
                                    <td>+1234567891</td>
                                    <td>Location A</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Supplier B</td>
                                    <td>supplierB@example.com</td>
                                    <td>+1234567892</td>
                                    <td>Location B</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Supplier C</td>
                                    <td>supplierC@example.com</td>
                                    <td>+1234567893</td>
                                    <td>Location C</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="editUser Modal" tabindex="-1" aria-labelledby="editUser ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUser ModalLabel">Edit User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUser Form">
                        <div class="mb-3">
                            <label for="password" class="form-label">Enter Password to Edit</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="businessName" class="form-label">Business Name</label>
                            <input type="text" class="form-control" id="businessName" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="businessEmail" class="form-label">Business Email</label>
                            <input type="email" class="form-control " id="businessEmail" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phoneNumber" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location </label>
                            <input type="text" class="form-control" id="location" disabled>
                        </div>
                        <button type="button" class="btn btn-primary" id="verifyPasswordButton">Verify Password</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
     
        const editUserForm = document.getElementById('editUserForm'); 
        const passwordInput = document.getElementById('password');
        const businessNameInput = document.getElementById('businessName');
        const businessEmailInput = document.getElementById('businessEmail');
        const phoneNumberInput = document.getElementById('phoneNumber');
        const locationInput = document.getElementById('location');
        const verifyPasswordButton = document.getElementById('verifyPasswordButton');
        const displayBusinessName = document.getElementById('displayBusinessName');
        const displayBusinessEmail = document.getElementById('displayBusinessEmail');
        const displayPhoneNumber = document.getElementById('displayPhoneNumber');
        const displayLocation = document.getElementById('displayLocation');

        
        verifyPasswordButton.addEventListener('click', () => {
         
            businessNameInput.disabled = false;
            businessEmailInput.disabled = false;
            phoneNumberInput.disabled = false;
            locationInput.disabled = false;
         
            passwordInput.value = '';
        });

    
        editUserForm.addEventListener('submit', (e) => {
            e.preventDefault();
         
            displayBusinessName.textContent = businessNameInput.value;
            displayBusinessEmail.textContent = businessEmailInput.value;
            displayPhoneNumber.textContent = phoneNumberInput.value;
            displayLocation.textContent = locationInput.value;
            alert('Changes saved!'); 
        });
    </script>
</body>
</html>