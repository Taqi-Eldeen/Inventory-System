<?php
include_once 'sidebar.php';
?>
<html>
    <head>
        <link rel="stylesheet" href="logs.css">
    </head>
    <body>

        
        <div class="main-content">
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Suppliers</h3>
                    </div>
                    <table id="productsTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Remaining Pieces</th>
                                <th>Delete</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="pname">Product 1</td>
                               
                                <td class="pprice">$19.99</td>
                              
                                <td class="psold">10</td>
                                <td class="premain">5</td>
                                <td class="de" id="delete">
                                    
                                    </td>
                                    <td class="de" id="edit">
                                        <a href="/manageProducts/edit/product1_id">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                                
                                
                            </tbody>
                        </table>
                    </div>
                </div>
   
            </div>
    </body>

        </html>