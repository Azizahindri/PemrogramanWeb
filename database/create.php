<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $book_id = $_POST['book_title'];
    $review = $_POST['review'];
    $rating = $_POST['rating'];
    $date = $_POST['date'];
    $user_id = $_POST['user_id'];

    if (!empty($name) && !empty($book_id) && !empty($review) && !empty($rating) && !empty($date) && !empty($user_id)) {
        $sql = "INSERT INTO crud_041_book_reviews (name, book_id, review, rating, date, user_id) 
                VALUES ('$name', '$book_id', '$review', '$rating', '$date', '$user_id')";

        if ($conn->query($sql) === TRUE) {
            header("Location: ../thanks.php");  
            exit(); 
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Semua field harus diisi!";
    }
}

$conn->close();
?>