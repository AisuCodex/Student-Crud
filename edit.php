<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM student_info WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_number = $_POST['id_number'];
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $bloodtype = $_POST['bloodtype'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];

    $sql = "UPDATE student_info SET id_number = ?, name = ?, birthday = ?, age = ?, gender = ?, bloodtype = ?, year_level = ?, section = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_number, $name, $birthday, $age, $gender, $bloodtype, $year_level, $section, $id]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
<h1>Edit Student</h1>
<form method="POST">
    <label>ID Number:</label>
    <input type="text" name="id_number" value="<?= $student['id_number'] ?>" required><br>
    <label>Name:</label>
    <input type="text" name="name" value="<?= $student['name'] ?>" required><br>
    <label>Birthday:</label>
    <input type="date" name="birthday" value="<?= $student['birthday'] ?>" required><br>
    <label>Age:</label>
    <input type="number" name="age" value="<?= $student['age'] ?>" required><br>
    <label>Gender:</label>
    <select name="gender" required>
        <option value="Male" <?= $student['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?= $student['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
        <option value="Other" <?= $student['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
    </select><br>
    <label>Blood Type:</label>
    <input type="text" name="bloodtype" value="<?= $student['bloodtype'] ?>"><br>
    <label>Year Level:</label>
    <input type="text" name="year_level" value="<?= $student['year_level'] ?>"><br>
    <label>Section:</label>
    <input type="text" name="section" value="<?= $student['section'] ?>"><br>
    <button type="submit">Update</button>
</form>
</body>
</html>
