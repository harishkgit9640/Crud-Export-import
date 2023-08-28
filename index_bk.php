<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- main CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.3.js"
        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <style>
    table {
        border-collapse: collapse;
    }

    .inline {
        display: inline-block;
        float: right;
        margin: 20px 0px;
    }

    input,
    button {
        height: 34px;
    }

    .pagination {
        display: inline-block;
    }

    .pagination a {
        font-weight: bold;
        font-size: 18px;
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        border: 1px solid black;
    }

    .pagination a.active {
        background-color: pink;
    }

    .pagination a:hover:not(.active) {
        background-color: skyblue;
    }
    </style>
</head>
<style>
.alert {
    display: none;
}
</style>

<body>

    <?php  
    // Import the file where we defined the connection to Database.     
        require_once "db_config.php";   
    
        $per_page_record = 3;  // Number of entries to show in a page.   
        // Look for a GET variable page if not found default is 1.        
        if (isset($_GET["page"])) {    
            $page  = $_GET["page"];    
        }    
        else {    
          $page=1;    
        }    
    
        $start_from = ($page-1) * $per_page_record;     
        
    ?>

    <div class="alert alert-success font-weight-bold" id="message" role="alert">
        A simple primary alert—check it out!
    </div>

    <main>
        <div class="container my-5 p-2">
            <!-- <h1>Dashboard</h1> -->
            <?php include_once('add_model.php') ?>
            <table class='table table-bordered'>
                <thead class='table-dark text-uppercase'>
                    <tr>
                        <th>Sno</th>
                        <th>User Name</th>
                        <th>Address</th>
                        <th>Salary</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="display_record">
                   
                </tbody>
            </table>

            <div class="pagination text-center">
    <?php  
        $query = "SELECT COUNT(*) FROM employees";     
        $rs_result = mysqli_query($conn, $query);     
        $row = mysqli_fetch_row($rs_result);     
        $total_records = $row[0];     
          
    echo "</br>";     
        // Number of pages required.   
        $total_pages = ceil($total_records / $per_page_record);     
        $pagLink = "";       
      
        if($page>=2){   
            echo "<a href='index.php?page=".($page-1)."'>  Prev </a>";   
        }       
                   
        for ($i=1; $i<=$total_pages; $i++) {   
          if ($i == $page) {   
              $pagLink .= "<a class = 'active' href='index.php?page="  
                                                .$i."'>".$i." </a>";   
          }               
          else  {   
              $pagLink .= "<a href='index.php?page=".$i."'>   
                                                ".$i." </a>";     
          }   
        };     
        echo $pagLink;   
  
        if($page<$total_pages){   
            echo "<a href='index.php?page=".($page+1)."'>  Next </a>";   
        }   
      ?>
    </div>

            <?php include_once('update_model.php') ?>
    </main>
</body>
<script>
// Load Record the data 
function load_Record() {
    $.ajax({
        url: "display.php",
        type: "POST",
        success: function(data) {
            $('#message').html('Letest Updated Data!').fadeIn(800);
            $('#message').fadeOut(2000);
            $('#display_record').html(data);
        }
    })
}
load_Record();

// pagination the database
//     $(document).on('click', '#pagination a', function(e) {
//     e.preventDefault();
//     var page_id = $(this).attr("id");
//     // alert(page_id);
//     load_Record(page_id);
// });

// Insert the data into the table
$(document).ready(function() {
    $('#save_record').on('click', function(e) {
        var name = $('#name').val();
        var address = $('#address').val();
        var salary = $('#salary').val();
        $.ajax({
            url: "insert.php",
            type: "POST",
            data: {
                name,
                address,
                salary
            },
            success: function(data) {
                if (data == 1) {
                    $('#message').html('data inserted successfully').fadeIn(800);
                    $('#message').fadeOut(2000);
                    $('#add_form').trigger("reset");
                    $("#model").slideUp(800);
                    document.location = "index.php";
                    load_Record();
                } else {
                    $('#message').addClass('alert-danger');
                    $('#message').html('something went wrong! data not inserted').fadeIn(
                        800);
                    $('#message').fadeOut(2000);
                }
            }
        })
    });
});

// Delete the Record from the database
$(document).on('click', '.delete_btn', function(e) {
    var new_id = $(this).data("id");
    $.ajax({
        url: "delete.php",
        type: "POST",
        data: {
            new_id
        },
        success: function(data) {
            if (data == 1) {
                $('#message').html('Data Deleted successfully').fadeIn(800);
                $('#message').fadeOut(2000);
                load_Record();
            } else {
                $('#message').addClass('alert-danger');
                $('#message').html('something went wrong Data not Deleted!').fadeIn(800);
                $('#message').fadeOut(2000);
            }
        }
    })
});


// fetch data for update the table
$(document).on('click', '.edit_btn', function(e) {
    var fetch_id = $(this).data("id");
    $.ajax({
        type: "POST",
        url: "fetch_data.php",
        data: {
            fetch_id
        },
        success: function(data) {
            $("#fetch_form").html(data);
        }
    });
});

// save record
$("#update_record").on("click", function(e) {
    e.preventDefault();
    var update_id = $('#update_id').val();
    var u_name = $('#u_name').val();
    var u_address = $('#u_address').val();
    var u_salary = $('#u_salary').val();
    $.ajax({
        url: "update.php",
        type: "POST",
        data: {
            update_id,
            u_name,
            u_address,
            u_salary,
        },
        success: function(data) {
            if (data) {
                $('#message').html('data updated successfully').fadeIn(800);
                $('#message').fadeOut(2000);
                document.location = "index.php";
                load_Record();
            } else {
                $('#message').addClass('alert-danger');
                $('#message').html('something went wrong, data not updated!').fadeIn(800);
                $('#message').fadeOut(2000);
            }
        }
    })
});
</script>

<!-- others links -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
    integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
</script>

</html>