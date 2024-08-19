<?php
    include("./includes/dbcontroller.php");

    header("Content-Type: application/json");
    if (!isset($_GET["id"])){
        echo '{"error":"No id provided!"}';
    }
    $id = $_GET["id"];

    try {
        $stmt = $DB_con->prepare("UPDATE userregistration SET admin_approved = 1 WHERE id = ".$id.";");
        $stmt->execute();
            if ($stmt->rowCount() > 0) {
            echo "Record updated successfully.";
        } else {
            echo "No records were updated.";
        }
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    } catch(PDOException $e) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

?>