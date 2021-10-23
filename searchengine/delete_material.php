<?php
require "connection.php";

$materialid = $_GET["materialid"];

$sql="DELETE FROM materialbeloong WHERE materialid = '$materialid'"; //Delete material
if ($result === FALSE) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql = "DELETE FROM material WHERE materialid = '$materialid'";
$result= mysqli_query($conn,$sql);
if ($result === FALSE) {
    die("Error deleting record: " . $conn->error);
}

$conn->close();

header("Location: dashboard.php");
?>