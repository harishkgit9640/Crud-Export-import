<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Load the database configuration file 
include_once 'db_config.php'; 
// Fetch records from database 
$query = "SELECT * FROM employees"; 
$res = mysqli_query($conn, $query);
$count = mysqli_num_rows($res);
if($count > 0){ 
    $delimiter = ","; 
    $filename = "employees_report_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    // $fiveMBs = 5 * 1024 * 1024;
    // $fp = fopen("php://temp/maxmemory:$fiveMBs", 'r+');
  $f = fopen("download/".$filename, 'a+'); 
     
    // Set column headers 
    $fields = array('ID','FULL NAME','ADDRESS', 'SALARY', 'CREATED'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = mysqli_fetch_assoc($res)){ 
        $lineData = array($row['id'], $row['name'], $row['address'], $row['salary'], $row['created'],); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 
 
?>