<?php
include_once('db_config.php');
$name = $_POST['name'];
$address = $_POST['address'];
$salary = $_POST['salary'];
$sql = "INSERT INTO employees(name, address, salary) VALUES ('$name', '$address', '$salary')";
if(mysqli_query($conn,$sql)){
    echo 1;
}else{
    echo 0;
}
mysqli_close($conn);  

?>