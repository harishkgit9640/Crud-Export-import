<?php
include_once('db_config.php');
$per_page_record = 3;
$page = "";
if(isset($_POST['page_id'])){
    $page = $_POST['page_id'];
}else{
    $page = 1;
}
$start_from = ($page-1) * $per_page_record;   
$query = "SELECT * FROM employees LIMIT $start_from, $per_page_record;";   
// $query = "SELECT * FROM employees;";   
$res = mysqli_query($conn, $query);
$count = mysqli_num_rows($res);
if($count>0){
        $i=1;
        $output = "";
        $output .= "
        <table class='table table-bordered'>
        <thead class='table-dark text-uppercase'>
    <tr>
    <th>Sno</th>
    <th>User Name</th>
    <th>address</th>
    <th>salary</th>
    <th>Edit</th>
    <th>Delete</th>
</tr>
</thead>
<tbody>";
        while($row = mysqli_fetch_assoc($res)){
            $output .= "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['address']}</td>
            <td>{$row['salary']}</td>
            <td>
               <button class='btn btn-success edit_btn' data-id='{$row["id"]}' data-toggle='modal' data-target='#update_model' >Edit</button>
            </td>
            <td>
               <button class='btn btn-danger delete_btn' data-id='{$row["id"]}'>Delete</button>
            </td>
        </tr>";
            $i++;
        }
        $output .= '</tbody> </table>';
        $sql = "SELECT * FROM employees;";
        $res = mysqli_query($conn, $sql);
        $record = mysqli_num_rows($res);
        $total_pages = ceil($record/$per_page_record);

        // pagination section
        $output .= '<div aria-label="pagination">
        <ul class="pagination" id="pagination">';
        if($page >= 2){
            $output .= "<li class='page-item'> <a class='page-link' id=".($page-1)."' aria-disabled='false'>Previous</a> </li>";
        }else{
            $output .= "<li class='page-item page-item disabled'> <a class='page-link' id=".($page-1)."' aria-disabled='true'>Previous</a> </li>";
        }

        for ($i=1; $i <= $total_pages; $i++) { 
        if($i == $page){
            $output .=  "<li class='page-item active' ><a class='page-link'id=".$i."'> $i <span class='sr-only'>(current)</span> </a></li>";
        }else{
            $output .=  "<li class='page-item'> <a class='page-link'id=".$i."'> $i </a></li>";
        }  
        }
        
        if($page == $total_pages){
            $output .= "<li class='page-item page-item disabled'> <a class='page-link' id=".($page+1)."' aria-disabled='true'>Next</a> </li>";
        }else{
            $output .= "<li class='page-item'> <a class='page-link' id=".($page+1)."' aria-disabled='false'>Next</a> </li>";
        }
         $output .= '</ul> </div>';
        echo $output;
        
mysqli_close($conn);             
    }else{
        echo "Data not found";
    }
?>