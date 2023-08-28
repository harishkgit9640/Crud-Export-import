<?php 
include_once('db_config.php');
$id = $_POST['fetch_id'];
// fetch query 
    $res = mysqli_query($conn, "SELECT * FROM employees WHERE id='$id'");
    $count = mysqli_num_rows($res);
    if($count>0){
        $output = "";
            while($row = mysqli_fetch_array($res)){
                       $output = " <div class='form-group'>
                            <label for='First Name'>First name</label>
                            <input type='text' class='form-control' id='u_name' value='{$row["name"]}' required>
                            <input type='hidden' class='form-control' id='update_id' value='{$row["id"]}' required>
                        </div>
    
                        <div class='form-group'>
                            <label for='First Name'>Address</label>
                            <input type='text' class='form-control' id='u_address' value='{$row["address"]}' required>
                        </div>
                        <div class='form-group'>
                            <label for='First Name'>salary</label>
                            <input type='text' class='form-control' id='u_salary' value='{$row["salary"]}' required>
                        </div> ";
                    }
                    echo $output;
    
        }
        else{
            echo "<td class='text-danger'>Opps! Data not found.</td>";
        }
        mysqli_close($conn);  
    
    
    ?>