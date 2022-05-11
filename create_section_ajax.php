<?php
header('Access-Control-Allow-Origin: *');
header('Content-Security-Policy: frame-ancestors *');
include_once("../inc/database.php");
include_once("../inc/functions.php");


if (!empty($_POST['section-type']) && !empty($_POST['section-name']) && !empty($_POST['section-title']) && !empty($_POST['section-description']) && !empty($_FILES['section-image'])  && !empty($_FILES['section-file'])) :

    $section_type = ($_POST['section-type'] != "") ? ($_POST['section-type']) : "";
    $section_name = ($_POST['section-name'] != "") ? ($_POST['section-name']) : "";
    $section_title = ($_POST['section-title'] != "") ? ($_POST['section-title']) : "";
    $section_description = ($_POST['section-description'] != "") ? ($_POST['section-description']) : "";

    $filename = $_FILES['section-file']['name'];
    $section_file_extension = pathinfo($filename, PATHINFO_EXTENSION);
    $fileTmpLoc = $_FILES["section-file"]["tmp_name"]; // File in the PHP tmp folder
    $fileType = $_FILES["section-file"]["type"]; // The type of file it is
    $fileSize = $_FILES["section-file"]["size"]; // File size in bytes
    $fileErrorMsg = $_FILES["section-file"]["error"]; // 0 for false... and 1 for true

    $location = "../scripts/sections/" . $section_type . "/" . $section_name . "." . $section_file_extension;
    /* Save the uploaded file to the local filesystem */

    if (!$fileTmpLoc) { // if file not chosen
        echo "ERROR: Please browse for a file before clicking the upload button.";
        exit();
    } else if ($fileSize > 102400000) { // if file is larger than we want to allow
        echo "ERROR: Your file was larger than 100mb in file size.";
        exit();
    }
    if (file_exists($location)) unlink($location);
    if (move_uploaded_file($fileTmpLoc, $location)) {
        // echo 'Success';
        $img = $_FILES["section-image"]["name"];
        $tmp_img_name = $_FILES["section-image"]["tmp_name"];
        $errorimg = $_FILES["section-image"]["error"];
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'doc', 'ppt'); // valid extensions
        $path = '../images/'; // upload directory
        $path = $path . strtolower($img);
        if (move_uploaded_file($tmp_img_name, $path)) {
            // echo "<img src='$path' />";
            $section_name = $_POST['section-name'];
            $section_type = $_POST['section-type'];
            $section_title = $_POST['section-title'];

            //insert form data in the database
            $insert = $db->query("INSERT INTO `sections_data`( `name`, `type`, `title`, `description`, `image_url`, `section_file_url`) VALUES ('" . $section_name . "','" . $section_type . "','" . $section_title . "','" . $section_description . "','" . $img . "', '". ($section_type . "/" . $section_name . "." . $section_file_extension) ."' )");
            echo $insert ? 'ok' : 'err';
        } else {
            echo 'invalid Image';
        }
    } else {
        unlink($location);
        echo 'Failure';
    }

endif;

