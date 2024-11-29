<?php
include 'db.php';

$id = $_GET['id'];
$sql = "DELETE FROM student_info WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

header("Location: index.php");
exit();
?>
