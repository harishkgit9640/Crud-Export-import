<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- main CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->
    <!-- jQuery link -->
    <script type="text/javascript" src="jquery.js"></script>
</head>
<style>
.alert {
    display: none;
}
</style>

<body>

    <div class="alert alert-success font-weight-bold" id="message" role="alert">
        A simple primary alert—check it out!
    </div>

    <main>
        <div class="container my-5 p-2">
            <div class="mb-3">
                <form class="form-inline" action="import_data.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col">
                            <input class="form-control" type="file" name="file" id="file">
                        </div>
                        <div class="col">
                            <button type="submit" name='upload_file' class="btn btn-success" id="upload-btn">Upload
                                Data</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <form class="form-inline" action="#" method="post">
                        <input class="form-control w-25" type="search" id="search" placeholder="Search"
                            autocomplete="off">
                    </form>
                </div>
                <div class="col-2">
                    <button type="button" name='export' class="btn btn-secondary" id="export">Export</button>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#model">
                        Add Record
                    </button>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger" id="delete-btn">Delete</button>
                </div>
            </div>

            <!-- <h1>Dashboard</h1> -->
            <?php include_once('add_model.php') ?>

            <div id="display_record">

            </div>

            <?php include_once('update_model.php') ?>
    </main>
</body>
<script>
$("upload-btn").click(function(e) {
    e.preventDefault();
    $.ajax({
        url: "export_data.php",
        type: "POST",
        data: {
            file: file
        },
        success: function(data) {
            alert("success!");
        }
    });

});
$("#export").click(function() {
    $.ajax({
        url: "export_data.php",
        success: function(data) {
            $('#message').html('Data exported successfully').fadeIn(800);
            $('#message').fadeOut(2000);
        }
    });
});

// Load Record the data 
function load_Record(page) {
    $.ajax({
        url: "pagination.php",
        type: "POST",
        data: {
            page_id: page
        },
        success: function(data) {
            $('#message').html('Letest Updated Data!').fadeIn(800);
            $('#message').fadeOut(2000);
            $('#display_record').html(data);
        }
    });
}
load_Record();

// pagination the database
$(document).on('click', '#pagination a', function(e) {
    e.preventDefault();
    var page_id = $(this).attr("id");
    // alert(page_id);
    load_Record(page_id);
});

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

    // Delete the Record from the database

    $("#delete-btn").click(function(e) {
        var id = [];
        $(":checkbox:checked").each(function(key) {
            id[key] = $(this).val();
        })
        if (id.length === 0) {
            $('#message').addClass('alert-danger');
            $('#message').html('please select at least on record!').fadeIn(800);
            $('#message').fadeOut(2000);
        } else {
            // alert(id);
            if (confirm("Are you sure!, Do you want delete!")) {
                $.ajax({
                    url: "delete.php",
                    type: "POST",
                    data: {
                        id
                    },
                    success: function(data) {
                        if (data == 1) {
                            $('#message').html('Data Deleted successfully').fadeIn(800);
                            $('#message').fadeOut(2000);
                            load_Record();
                        } else {
                            $('#message').addClass('alert-danger');
                            $('#message').html('something went wrong Data not Deleted!')
                                .fadeIn(
                                    800);
                            $('#message').fadeOut(2000);
                        }
                    }
                })
            } else {
                load_Record();
            }
        }

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
                    $('#message').html('something went wrong, data not updated!').fadeIn(
                        800);
                    $('#message').fadeOut(2000);
                }
            }
        })
    });

    // Search Record
    $("#search").on('keyup', function(e) {
        e.preventDefault();
        var search = $('#search').val();
        $.ajax({
            url: "search.php",
            type: "POST",
            data: {
                search
            },
            success: function(data) {
                $('#display_record').html(data);
            }
        })
    });

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