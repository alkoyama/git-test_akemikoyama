<?php
// **Connect to your Database Here**
// Replace with your connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "git_test";

// Check connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve comments from database
$sql = "SELECT * FROM comments WHERE DATE(CreatedAt) = CURDATE() ORDER BY CreatedAt DESC";
$result = mysqli_query($conn, $sql);

$comments_html = ''; // Initialize an empty string to hold HTML for comments
while ($row = $result->fetch_assoc()) { // Loop through each comment row
    $username = htmlspecialchars($row['username']); // Escape special characters to prevent XSS attacks
    $subject = htmlspecialchars($row['subject']); // Escape special characters to prevent XSS attacks
    $email = htmlspecialchars($row['email']); // Escape special characters to prevent XSS attacks
    $comment = htmlspecialchars($row['comment']); // Escape special characters to prevent XSS attacks
    $CreatedAt = htmlspecialchars($row['CreatedAt']); // Escape special characters to prevent XSS attacks

    $comments_html .= '<div class="message-container">'; // Create a container for each comment
    $comments_html .= '<div class="message">'; // Create a container for the actual comment
    $comments_html .= '<h3>' . $username . '</h3>'; // Display username
    if ($subject) {
        $comments_html .= '<p>' . $subject . 'へ</p>';
    }
    if ($email) { // Add email if available
        $comments_html .= '<p>Email: ' . $email . '</p>';
    }
    $comments_html .= '<p>' . $comment . '</p>'; // Display comment
    $comments_html .= '<p>' . $CreatedAt . '</p>'; // Display comment
    $comments_html .= '</div>'; // Close the message container
    $comments_html .= '</div>'; // Close the message-container
}


// Close connection
mysqli_close($conn);

// Output the comments HTML
echo json_encode(array('comments' => $comments_html));
?>
