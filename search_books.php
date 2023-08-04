<?php
    // Database connection credentials
    $host = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'library_management_system';

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

        // Display search results
        if ($result->num_rows > 0) {
            echo "<h3>Search Results:</h3>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['Title'] . " by " . $row['Author'] . " (ISBN: " . $row['ISBN'] . ")</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No results found.</p>";
        }

        $stmt->close();
    }

    $conn->close();
    ?>