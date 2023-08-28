<?php
// $host_name = $_POST['host_name'];
// $user_name = $_POST['user_name'];
// $password = $_POST['password'];
// $db_name = $_POST['db_name'];
// $conn = mysqli_connect(`'$host_name','$user_name','$password','$db_name'`) or die ("Can't connect");
// if($conn){
//     echo "success!";
//     header('Location:index.php');
// }

$conn = mysqli_connect("localhost","root","","user_db") or die ("Can't connect");
if(!$conn){
    echo "conncect failled !";
}


?>