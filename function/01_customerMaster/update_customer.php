<?php
// เชื่อมต่อฐานข้อมูล MySQL
include "../connectionDb.php";

if(isset($_POST["customer_id"])) {
    $query = "
    UPDATE customer_master SET 
    customer_name = :customer_name, 
    address = :address, 
    branch = :branch, 
    tax_id = :tax_id, 
    contact_1 = :contact_1, 
    phone_1 = :phone_1, 
    contact_2 = :contact_2, 
    phone_2 = :phone_2, 
    email = :email 
    WHERE customer_id = :customer_id
    ";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':customer_name' => $_POST["customer_name"],
            ':address' => $_POST["address"],
            ':branch' => $_POST["branch"],
            ':tax_id' => $_POST["tax_id"],
            ':contact_1' => $_POST["contact_1"],
            ':phone_1' => $_POST["phone_1"],
            ':contact_2' => $_POST["contact_2"],
            ':phone_2' => $_POST["phone_2"],
            ':email' => $_POST["email"],
            ':customer_id' => $_POST["customer_id"]
        )
    );
    echo 'success';
}
?>