<?php
// Database connection credentials
$host = 'sql.freedb.tech';
$dbUsername = 'freedb_rootdasun';
$dbPassword = '9VXyBFw@%atPRHn';
$dbName = 'freedb_co226123';

// Establish a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Close the connection to recreate connection with the selected database
$conn->close();

// Re-establish connection to the created database
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// SQL statements to create tables
$sql1 = "CREATE TABLE IF NOT EXISTS members (
    MemberID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(255) NOT NULL
)";

$sql2 = "CREATE TABLE IF NOT EXISTS borrower (
    BorrowerID INT PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Address VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(15) NOT NULL,
    Email VARCHAR(50) NOT NULL
)";

$sql3 = "CREATE TABLE IF NOT EXISTS author (
    AuthorID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    DateOfBirth DATE NOT NULL,
    Nationality VARCHAR(50) NOT NULL
)";

$sql4 = "CREATE TABLE IF NOT EXISTS book (
    BookID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    ISBN VARCHAR(13) NOT NULL,
    Publisher VARCHAR(100) NOT NULL,
    PublicationYear YEAR NOT NULL,
    Language VARCHAR(50) NOT NULL,
    Genre VARCHAR(50) NOT NULL,
    Availability INT NOT NULL,
    Author INT NOT NULL,
    FOREIGN KEY (Author) REFERENCES author (AuthorID)
)";

$sql5 = "CREATE TABLE IF NOT EXISTS loantransaction (
    LoanID INT AUTO_INCREMENT PRIMARY KEY,
    BookID INT,
    BorrowerID INT,
    LoanDate DATE NOT NULL,
    DueDate DATE NOT NULL,
    ReturnDate DATE,
    Fine DECIMAL(10, 2),
    FOREIGN KEY (BookID) REFERENCES book (BookID),
    FOREIGN KEY (BorrowerID) REFERENCES borrower (BorrowerID)
)";


// Execute the SQL statements
if ($conn->query($sql1) === TRUE) {
    echo "Table 'members' created successfully<br>";
} else {
    echo "Error creating table 'members': " . $conn->error;
}

if ($conn->query($sql2) === TRUE) {
    echo "Table 'borrower' created successfully<br>";
} else {
    echo "Error creating table 'borrower': " . $conn->error;
}

if ($conn->query($sql3) === TRUE) {
    echo "Table 'author' created successfully<br>";
} else {
    echo "Error creating table 'author': " . $conn->error;
}

if ($conn->query($sql4) === TRUE) {
    echo "Table 'book' created successfully<br>";
} else {
    echo "Error creating table 'book': " . $conn->error;
}

if ($conn->query($sql5) === TRUE) {
    echo "Table 'loantransaction' created successfully<br>";
} else {
    echo "Error creating table 'loantransaction': " . $conn->error;
}

// Check if the Approved column exists in the loantransaction table
$checkSql = "SHOW COLUMNS FROM loantransaction LIKE 'Approved'";
$result = $conn->query($checkSql);

if ($result->num_rows === 0) {
    // Column does not exist, add it using ALTER TABLE
    $alterSql = "ALTER TABLE loantransaction
                 ADD COLUMN Approved BOOLEAN DEFAULT FALSE";

    // Execute the SQL statement to add the Approved column
    if ($conn->query($alterSql) === TRUE) {
        echo "Table 'loantransaction' altered successfully (Added Approved column)<br>";
    } else {
        echo "Error altering table 'loantransaction': " . $conn->error;
    }
} else {
    echo "Column 'Approved' already exists in table 'loantransaction'. No alteration needed.<br>";
}

// Close the connection
$conn->close();
?>