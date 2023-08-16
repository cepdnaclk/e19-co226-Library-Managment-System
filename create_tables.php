<?php
session_start();
require_once 'db.php';

// Establish a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

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
    Password VARCHAR(255) NOT NULL,
    Role VARCHAR(50) NOT NULL
)";

$sql2 = "CREATE TABLE IF NOT EXISTS borrower (
    BorrowerID INT PRIMARY KEY,
    UserName VARCHAR(50) NOT NULL,
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
    ImgURL VARCHAR(255) NOT NULL,
    Discription VARCHAR(500) NOT NULL,
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
    LoanDate DATE ,
    DueDate DATE ,
    ReturnDate DATE,
    Fine DECIMAL(10, 2),
    Approved BOOLEAN DEFAULT FALSE,
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
// $checkSql = "SHOW COLUMNS FROM loantransaction LIKE 'Approved'";
// $result = $conn->query($checkSql);

// if ($result->num_rows === 0) {
//     // Column does not exist, add it using ALTER TABLE
//     $alterSql = "ALTER TABLE loantransaction
//                  ADD COLUMN Approved BOOLEAN DEFAULT FALSE";

//     // Execute the SQL statement to add the Approved column
//     if ($conn->query($alterSql) === TRUE) {
//         echo "Table 'loantransaction' altered successfully (Added Approved column)<br>";
//     } else {
//         echo "Error altering table 'loantransaction': " . $conn->error;
//     }
// } else {
//     echo "Column 'Approved' already exists in table 'loantransaction'. No alteration needed.<br>";
// }

// SQL queries to insert staff members into the members table
$hashedPassword1 = password_hash('password1', PASSWORD_BCRYPT);
$hashedPassword2 = password_hash('password2', PASSWORD_BCRYPT);

$query1 = "INSERT INTO members (username, password, role) VALUES ('staff1', '$hashedPassword1', 'staff')";
$query2 = "INSERT INTO members (username, password, role) VALUES ('staff2', '$hashedPassword2', 'staff')";


// Execute the queries
if ($conn->query($query1) && $conn->query($query2)) {
    echo "Staff members inserted successfully.";
} else {
    echo "Error: " . $conn->error;
}

$query_authors = "INSERT INTO author (AuthorID, FirstName, LastName, DateOfBirth, Nationality)
VALUES
    (1, 'Stephenie', 'Meyer', '1973-12-24', 'American'),
    (2, 'J.K.', 'Rowling', '1965-07-31', 'British'),
    (3, 'J.R.R.', 'Tolkien', '1892-01-03', 'British'),
    (4, 'Mark', 'Twain', '1835-11-30', 'American'),
    (5, 'Rick', 'Riordan', '1964-06-05', 'American'),
    (6, 'Suzanne', 'Collins', '1962-08-10', 'American'),
    (7, 'Maxim', 'Gorky', '1868-03-28', 'Russian')";

if ($conn->query($query_authors) === TRUE) {
    echo "Authors added to database<br>";
} else {
    echo "Error in adding authors: " . $conn->error;
}

$query_books = "INSERT INTO book (BookID, Title,ImgURL,Discription, ISBN, Publisher, PublicationYear, Language, Genre, Availability, Author)
VALUES
    (1, 'Twilight saga','assert/img/bookprew/twilight.jpg','Bella\'s vampire love, Edward, challenges norms. Their unique romance intertwines danger and devotion in this captivating supernatural tale.', '9780316015844', 'Little, Brown and Company', 2005, 'English', 'Fantasy', 1, 1),
    (2, 'Harry Potter and the Half-Blood Prince','assert/img/bookprew/harrypotter.jpeg','Voldemort\'s origins explored. Dumbledore guides Harry. Secrets deepen, alliances shift, setting stage for final confrontation.' ,'9780439784542', 'Scholastic', 2005, 'English', 'Fantasy', 1, 2),
    (3, 'The Hobbit','assert/img/bookprew/hobbit.jpeg','Bilbo joins dwarves\' quest for treasure, grows brave. Battles creatures, finds courage in epic adventure.', '9780547928227', 'Mariner Books', 1937, 'English', 'Fantasy', 1, 3),
    (4, 'The Adventures of Huckleberry Finn', 'assert/img/bookprew/adventuers.jpeg','\"Huckleberry Finn\" follows Huck\'s escape with Jim, a runaway slave. Journey unfolds social commentary, friendship, and freedom.','9780486280615', 'Dover Publications', 1884, 'English', 'Adventure', 1, 4),
    (5, 'Heroes of Olympus: The Lost Hero','assert/img/bookprew/heros.jpeg','The Lost Hero,\' demigods quest to rescue Hera, facing challenges, forging bonds, and uncovering ancient mysteries.', '9781423113393', 'Disney-Hyperion', 2010, 'English', 'Fantasy', 1, 5),
    (6, 'The Hunger Games','assert/img/bookprew/hungergames.jpeg','In a post-apocalyptic society, \'The Hunger Games\' annually pits teens against each other. Katniss Everdeen\'s sacrificial choice thrusts her into the deadly arena, challenging authority and kindling a rebellion against oppression.', '9780439023528', 'Scholastic', 2008, 'English', 'Dystopian', 1, 6),
    (7, 'Percy Jackson and the Titan\'s Curse','assert/img/bookprew/percyjackson.jpeg','Percy joins friends to rescue Artemis, battling Titans. Quest unfolds dangers, tests loyalties, reveals secrets in gripping mythological adventure.', '9781423101451', 'Disney-Hyperion', 2007, 'English', 'Fantasy', 1, 5),
    (8, 'Mother','assert/img/bookprew/mother.jpg','Maxim Gorky\'s \"Mother\" portrays working-class hardship and revolt in pre-revolution Russia. Protagonist Nilovna transforms from submissive wife to revolutionary, reflecting societal upheaval and individual empowerment.', '9780140183526', 'Penguin Classics', 1907, 'Russian', 'Drama', 1, 7)";
if ($conn->query($query_books) === TRUE) {
    echo "Books added to database<br>";
} else {
    echo "Error in adding books" . $conn->error;
}



// Close the connection
$conn->close();
?>