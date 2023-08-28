<?php
include_once('db_config.php');
$id = $_POST['id'];
$str = implode(",",$id);
$sql = mysqli_query($conn, "DELETE FROM employees WHERE id IN ($str)");
if($sql){
    echo 1;
}else{
    echo 0;
}
mysqli_close($conn);  

?>