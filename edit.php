<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        input[type="text"], input[type="submit"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .action-column {
            display: flex;
            justify-content: space-around;
        }
        .action-column button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .action-column button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        // Function to confirm before updating record
        function confirmUpdate() {
            return confirm("Are you sure you want to update this record?");
        }
    </script>
</head>
<body>
    <h2>Edit Student Records</h2>

    <?php
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "student_records";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $name = $_POST["name"];
        $class = $_POST["class"];
        $gender = $_POST["gender"];
        $dob = $_POST["dob"];

        // Prepare and execute the SQL query to update student records
        $sql = "UPDATE students SET `Class` = '$class', `Gender` = '$gender', `D.O.B` = '$dob' WHERE `Name` = '$name'";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully! Redirecting...";
            // Redirect to index.html after a brief delay
            header("refresh:2;url=index.html");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    // Query to fetch all student records
    $sql = "SELECT * FROM students";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row in a form for editing
        echo "<form action=\"" . htmlspecialchars($_SERVER["PHP_SELF"]) . "\" method=\"post\">";
        echo "<table>";
        echo "<tr><th>Name</th><th>Class</th><th>Gender</th><th>D.O.B</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td><input type=\"text\" name=\"class\" value=\"" . $row["Class"] . "\"></td>";
            echo "<td><input type=\"text\" name=\"gender\" value=\"" . $row["Gender"] . "\"></td>";
            echo "<td><input type=\"text\" name=\"dob\" value=\"" . $row["D.O.B"] . "\"></td>";
            echo "<td class=\"action-column\">";
            echo "<input type=\"hidden\" name=\"name\" value=\"" . $row["Name"] . "\">";
            echo "<button type=\"submit\" onclick=\"return confirmUpdate()\">Update</button>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</form>";
    } else {
        echo "0 results";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
