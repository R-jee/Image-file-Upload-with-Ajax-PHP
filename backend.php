<?php
header('Access-Control-Allow-Origin: *');
header('Content-Security-Policy: frame-ancestors *');
include_once("../inc/database.php");
include_once("../inc/functions.php");



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/sweetalert2.min.css">

    <!-- CSS -->

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="../js/sweetalert2.all.min.js"></script>

</head>

<body>

    <div class="container add_new_section_template">
        <button type="button" class="btn btn-primary mt-4 " data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Add New Section details</button>


        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload New Section</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="section_create_form_id" class="section_create_form_">
                        <div class="modal-body">
                            <div class="container create_section_form_cls">

                                <div class="row align-items-start">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="mb-3">
                                            <label for="section-name" class="col-form-label">Section Name:</label>
                                            <input type="text" class="form-control" id="section-name" name="section-name">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <div class="mb-3">
                                            <label for="section-type" class="col-form-label">Section Type:</label>
                                            <select class="form-select" aria-label="Select Section type" id="section-type" name="section-type">
                                                <option selected>Select Section type</option>

                                                <?php
                                                $temp__sections_names_array = get__files_dir_names("../scripts/sections");
                                                for ($i = 0; $i < count($temp__sections_names_array); $i++) {
                                                    echo '<option value="' . $temp__sections_names_array[$i] . '">' . $temp__sections_names_array[$i] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 col-sm-12">
                                        <div class="mb-3">
                                            <label for="section-title" class="col-form-label">Title:</label>
                                            <input type="text" class="form-control" id="section-title" name="section-title">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="section-img" class="col-form-label">Image:</label>
                                            <input type="file" class="form-control form-control-sm" id="section-img" accept="image/png, image/jpeg, image/jpg" name="section-image">
                                            <div id="err"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="section-file" class="col-form-label">File:</label>
                                            <input type="file" class="form-control form-control-sm" id="section-file" accept=".txt" name="section-file">
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="mb-3">
                                            <label for="section-description" class="form-label">Description</label>
                                            <textarea class="form-control form-control-sm" id="section-description" name="section-description" rows="3"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary create_section_btn" id="create_section_btn___id">Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>



    </div>



    <script>
        $("#create_section_btn___id").on('click', function(e) {
            e.preventDefault();
            var formdata = new FormData($("#section_create_form_id").get(0));
            $.ajax({
                url: "create_section_ajax.php",
                type: "POST",
                data: formdata,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#err").fadeOut();
                },
                success: function(data) {
                    if (data == 'invalid') {
                        // invalid file format.
                        $("#err").html("Invalid File !").fadeIn();
                    } else {
                        $("#section_create_form_id")[0].reset();
                    }

                },
                error: function(e) {
                    $("#err").html(e).fadeIn();
                }
            });
        });
        jQuery('#section-name').keyup(function() {
            this.value = this.value.replace(/[^0-9a-z\-\_]/g, '');
        });

    </script>




</body>

</html>