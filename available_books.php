<?php
require_once 'db.php';

// Establish a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to retrieve available books
$sql = "SELECT * FROM book WHERE Availability = 1";
$result = $conn->query($sql);

// Display available books in a table
if ($result->num_rows > 0) {
    echo "<h2>Available Books</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Title</th><th>Author</th><th>ISBN</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Title'] . "</td>";
        echo "<td>" . $row['Author'] . "</td>";
        echo "<td>" . $row['ISBN'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No available books found.</p>";
}

$conn->close();
?>