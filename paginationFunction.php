<?php
function Pagination ($tb_name,$per_page_record,$page){

$sql = "SELECT * FROM $tb_name;";
$res = mysqli_query($conn, $sql);
$record = mysqli_num_rows($res);
$total_pages = ceil($record/$per_page_record);

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
}


?>