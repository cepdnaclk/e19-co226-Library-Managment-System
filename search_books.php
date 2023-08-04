<?php
    // Database connection credentials
$host = 'sql.freedb.tech';
$dbUsername = 'freedb_rootdasun';
$dbPassword = '9VXyBFw@%atPRHn';
$dbName = 'freedb_co226123';

    // Establish a database connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the search form was submitted
    if (isset($_GET['submit'])) {
        // Retrieve and sanitize the search query
        $searchQuery = $_GET['search_query'];

        // Prepare the SQL statement to search by Title or Author
        $sql = "SELECT * FROM book WHERE Title LIKE ? OR Author LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchQuery = '%' . $searchQuery . '%'; // Add wildcards for partial matching
        $stmt->bind_param("ss", $searchQuery, $searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();

       // Display search results in a table
        if ($result->num_rows > 0) {
            echo "<h3>Search Results:</h3>";
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
            echo "<p>No results found.</p>";
        }

        $stmt->close();
    }

    $conn->close();
    ?>