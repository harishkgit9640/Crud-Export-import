<?php
include_once('db_config.php');

if(isset($_POST['upload_file'])){

    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    // Validate whether selected file is a CSV file


    // if(!empty($_FILES['file']['name'])){
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){

        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);
            $count = 0;
            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data
                $name = $line[0];
                $address = $line[1];
                $salary = $line[2];
              
                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT name FROM employees WHERE name = '$line[0]'";
                $prevResult = mysqli_query($conn,$prevQuery);
                $res = mysqli_num_rows($prevResult);
                if($res > 0){
                    // Update member data in the database
                   $result = mysqli_query($conn,"UPDATE employees SET name = '$name', address ='$address', salary = '$salary', modified = NOW() WHERE name = '$name'");
                }else{
                    // Insert member data in the database
                   $result = mysqli_query($conn,"INSERT INTO employees (name, address, salary, created, modified) VALUES ('$name', '$address', '$salary', NOW(), NOW())");
                }
                $count++;
            }
            // $result = mysqli_query($conn,$sql);
            if($result){
                echo $count;
                header("Location:index.php");
            }else{
                echo $count;
                echo "data is not Inserted";
            }
            mysqli_close($conn);  
            // Close opened CSV file
            fclose($csvFile);

        }else{
            echo "level - 2";
        }
    }else{
        echo "level - 1";
    }
}
?>
