<?php
session_start();
require '../conf.inc.php';
require '../functions.php';
if (isConnected() && isActivated()) {
    $title = $_POST["imageTitle"];
    $target_dir = "../newsletterImages/";
    $uploadOk = 1;
    $target_file = $target_dir . basename($_FILES["uploadImage"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["uploadImage"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Ce n'est pas une image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_dir . $title . $imageFileType)) {
        echo "Votre fichier existe déjà";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["uploadImage"]["size"] > 5000000) {
        echo "Votre fichier est trop gros";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Seuls les extensions .gif, .png, . jpg et .jpeg sont acceptés";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Desolé votre fichier n'est pas envoyé";
    } else {
        if (move_uploaded_file($_FILES["uploadImage"]["tmp_name"], "../newsletterImages/" . $title . "." . $imageFileType)) {
            $directory = "../newsletterImages/" . $title . "." . $imageFileType;
            echo "success";
        } else {
            echo "Une erreur a été rencontrée lors du téléchargement";
        }
    }
} else {
    header("Location: login");
}