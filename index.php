<?php
include 'db.php';

// Handle form submission for adding a new student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_number = $_POST['id_number'];
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $bloodtype = $_POST['bloodtype'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];

    $sql = "INSERT INTO student_info (id_number, name, birthday, age, gender, bloodtype, year_level, section)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_number, $name, $birthday, $age, $gender, $bloodtype, $year_level, $section]);

    header("Location: index.php");
    exit();
}

// Fetch all students
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchField = isset($_GET['search_field']) ? $_GET['search_field'] : 'name';

$sql = "SELECT * FROM student_info";
if (!empty($search)) {
    $sql .= " WHERE $searchField LIKE :search";
}

$stmt = $conn->prepare($sql);
if (!empty($search)) {
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
}
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Students</h1>

<!-- Search Form -->
<div class="search-form">
    <h3>Search Students</h3>
    <form method="GET" action="">
        <select name="search_field">
            <option value="name" <?php echo $searchField === 'name' ? 'selected' : ''; ?>>Name</option>
            <option value="id_number" <?php echo $searchField === 'id_number' ? 'selected' : ''; ?>>ID Number</option>
            <option value="section" <?php echo $searchField === 'section' ? 'selected' : ''; ?>>Section</option>
            <option value="year_level" <?php echo $searchField === 'year_level' ? 'selected' : ''; ?>>Year Level</option>
        </select>
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Enter search term...">
        <button type="submit">Search</button>
        <?php if (!empty($search)): ?>
            <a href="index.php">Clear Search</a>
        <?php endif; ?>
    </form>
</div>

<h2>Student List</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>ID Number</th>
        <th>Name</th>
        <th>Birthday</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Blood Type</th>
        <th>Year Level</th>
        <th>Section</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($students as $student): ?>
    <tr>
        <td><?= $student['id'] ?></td>
        <td><?= $student['id_number'] ?></td>
        <td><?= $student['name'] ?></td>
        <td><?= $student['birthday'] ?></td>
        <td><?= $student['age'] ?></td>
        <td><?= $student['gender'] ?></td>
        <td><?= $student['bloodtype'] ?></td>
        <td><?= $student['year_level'] ?></td>
        <td><?= $student['section'] ?></td>
        <td>
            <a href="edit.php?id=<?= $student['id'] ?>">Edit</a> | 
            <a href="delete.php?id=<?= $student['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<button id="toggleBtn" class="toggle-btn" onclick="toggleForm()">Add New Student</button>
<div id="addStudentForm">
    <form method="POST" action="">
        <label>ID Number:</label>
        <input type="text" name="id_number" required><br>
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Birthday:</label>
        <input type="date" name="birthday" required><br>
        <label>Age:</label>
        <input type="number" name="age" required><br>
        <label>Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br>
        <label>Blood Type:</label>
        <input type="text" name="bloodtype"><br>
        <label>Year Level:</label>
        <input type="text" name="year_level"><br>
        <label>Section:</label>
        <input type="text" name="section"><br>
        <button type="submit">Add Student</button>
    </form>
</div>
<script>
        function toggleForm() {
            var form = document.getElementById('addStudentForm');
            var btn = document.getElementById('toggleBtn');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
                btn.textContent = 'Hide Add Student Form';
            } else {
                form.style.display = 'none';
                btn.textContent = 'Add New Student';
            }
        }
    </script>
</body>
</html>
