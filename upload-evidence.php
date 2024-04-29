<?php
session_start();
require_once('includes/config.php');
if(isset($_POST["submit"])){
    $target = "evidenceFiles/";
    $address = $target . basename($_FILES["file-upload"]["name"]);
    $upload = 1;
    $fileType = strtolower(pathinfo($address,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES['file-upload']['tmp_name']);
    if($check !== false){
        $upload = 1;
    }else{
        $upload = 0;
    }

    if ($_FILES["file-upload"]["size"] > 500000) {
        $upload = 0;
    }
    if($upload == 0){
        echo "File not uploaded.";
    }else{
        if(move_uploaded_file($_FILES['file-upload']["tmp_name"],$address)){
            $reviewID = $_SESSION['review_id'];
            
            $db->query("UPDATE reviews SET evidence = '".$address."' WHERE review_id = $reviewID");
        }else{
            echo "error uploading file.";
        }
    }

}
header('location: review-details.php');
?>