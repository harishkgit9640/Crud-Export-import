<?php
include_once('db_config.php');
$id = $_POST['update_id'];
//  upudate  query
if(isset($_POST['update_id'])){ 
    $name = $_POST['u_name'];
    $address = $_POST['u_address'];
    $salary = $_POST['u_salary'];
$sql = "UPDATE employees SET name='$name', address='$address', salary='$salary',modified=NOW() WHERE id='$id'";
if(mysqli_query($conn,$sql)){
    echo "data updated successfully";
}else{
    echo "Sorry ! Data update failed!";
}
mysqli_close($conn);  
}



?>