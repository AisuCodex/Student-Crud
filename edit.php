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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Edit Student</h1>
<div id="addStudentForm" style="display: block;">
    <form method="POST">
        <div class="form-group">
            <label>ID Number:</label>
            <input type="text" name="id_number" value="<?= $student['id_number'] ?>" required><br>
        </div>
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="<?= $student['name'] ?>" required><br>
        </div>
        <div class="form-group">
            <label>Birthday:</label>
            <input type="date" name="birthday" value="<?= $student['birthday'] ?>" required><br>
        </div>
        <div class="form-group">
            <label>Age:</label>
            <input type="number" name="age" value="<?= $student['age'] ?>" required><br>
        </div>
        <div class="form-group">
            <label>Gender:</label>
            <select name="gender" required>
                <option value="Male" <?= $student['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $student['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= $student['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select><br>
        </div>
        <div class="form-group">
            <label>Blood Type:</label>
            <input type="text" name="bloodtype" value="<?= $student['bloodtype'] ?>"><br>
        </div>
        <div class="form-group">
            <label>Year Level:</label>
            <input type="text" name="year_level" value="<?= $student['year_level'] ?>"><br>
        </div>
        <div class="form-group">
            <label>Section:</label>
            <input type="text" name="section" value="<?= $student['section'] ?>"><br>
        </div>
        <button type="submit" class="toggle-btn">Update Student</button>
        <a href="index.php" class="toggle-btn" style="text-decoration: none; display: inline-block; background-color: #808080;">Back</a>
    </form>
</div>
</body>
</html>
