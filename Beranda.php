<?php
include 'database/db.php'; 

$query = "
    SELECT 
        b.id_book,
        b.title, 
        b.author, 
        ROUND(AVG(br.rating), 1) AS average_rating
    FROM 
        crud_041_book b
    LEFT JOIN 
        crud_041_book_reviews br ON b.id_book = br.book_id
    GROUP BY 
        b.id_book
    ORDER BY 
        average_rating DESC;
";

$result = mysqli_query($conn, $query);

$queryAllBook = "SELECT * FROM crud_041_book";
$resultAllBook = mysqli_query($conn, $queryAllBook);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: rgb(28, 79, 45);
        }
        .book-item {
            border: 1px solid #d3bbbbc6;
            padding: 15px;
            margin: 10px;
            text-align: center;
            border-radius: 8px;
            display: block;
            box-sizing: border-box;
        }
        .book-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .book-item img {
            max-width: 100%;
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 5px;
        }
        footer {
            background-color: #00000000;
            color: rgb(255, 0, 0);
            padding: 15px;
            text-align: center;
            margin-top: 30px;
        }
        .image {
            width: 100px;
            height: auto;
            position: absolute; 
            top: 100; 
            left: 90%; 
            transform: translateX(-50%); 
            border-radius: 10px;
        }
        * {
            color: whitesmoke;
        }
        .navbar {
            background-color: #ffffff;
        }
        .navbar-nav .nav-link {
            color: rgb(33, 80, 40) !important; 
        }
        .navbar-nav .nav-link:hover {
            color: rgb(0, 0, 0) !important; 
        }
        .navbar-nav .nav-link.active {
            color: rgb(28, 97, 37) !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="color: green;">Freshure</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="Beranda.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">Tentang Kami</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Jenis </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#" onclick="clearFilter()"> All </a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterGenre('Sayur')">Sayuran</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterGenre('Buah')">Buah</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterGenre('Bunga')">Bunga</a></li>

                        </ul>
                    </li>
                <li class="nav-item"> 
                    <a class = "nav-link" href = "login2.php" > <img src="images/log.png" alt="Choi Seungcheol"></a>
                </li>
                </ul>
            </div>
        </div>
    </nav>
    

    <div class="container mt-5">
        <h1 align="center" style="color: brown; font-family: Poppins"><b>  Freshure </b> </h1>
        <p> Panen Segar Setiap Hari! Pilih Sayur dan Buah Hidroponik Berkualitas untuk Hidangan Sehatmu!" </p>
        <hr>

        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari tumbuhan " onkeyup="searchBooks()">
        </div>
        <p align="center"> <b> Pilihan terbaik Menurut Rating: Pilihan Teratas dari Pembeli!</b></p>

        <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th> Tumbuhan </th>
                <th>Rating</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    
                    $title = $row['title'];
                    $average_rating = $row['average_rating'];

                    if ($average_rating > 4) {
                        
                        $stars = '';
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $average_rating) {
                                $stars .= '★';
                            } else {
                                $stars .= '☆';
                            }
                        }

                        echo "
                        <tr>
                            <td>$title</td>
                            <td>$stars</td>
                            <td><a href='review.php?id_book=" . urlencode($row['id_book']) . "' class='btn btn-primary btn-sm'>Review</a></td>
                        </tr>
                        ";
                    }
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada barang yang ditemukan.</td></tr>";
            }
            ?>
            

        </tbody>
    </table>

        <p align="center"> Sudah mencoba produk hidroponik kami? Bagikan pengalamanmu dan bantu orang lain menemukan pilihan segar dan sehat! </p>
        <h2 class="text-center" style="color:floralwhite 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif "> <b>Daftar Tumbuhan</b></h2>
        <div class="book-list" id="bookList">
        <?php while($row = mysqli_fetch_assoc($resultAllBook)): ?>
            <div class="book-item <?= htmlspecialchars($row['genre']) ?> col-md-3"
                onclick="window.location.href='informasi.php?id_book=<?= urlencode($row['id_book']) ?>'"
                style="cursor: pointer;">
                <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                <hr>
                <h5><?= htmlspecialchars($row['title']) ?></h5>
                <p> Rp.<?= htmlspecialchars($row['author']) ?></p>
            </div>

        <?php endwhile; ?>
        </div>
        

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function searchBooks() {
            var input, filter, books, bookItem, title, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toUpperCase();
            books = document.getElementById("bookList");
            bookItem = books.getElementsByClassName('book-item');

            for (i = 0; i < bookItem.length; i++) {
                title = bookItem[i].getElementsByTagName("h5")[0];
                txtValue = title.textContent || title.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    bookItem[i].style.display = "";
                } else {
                    bookItem[i].style.display = "none";
                }
            }
        }
        function filterGenre(genre) {
                var bookItems = document.querySelectorAll('.book-item');
                bookItems.forEach(function(book) {
                    if (book.classList.contains(genre)) {
                        book.style.display = 'block';  
                    } else {
                        book.style.display = 'none';  
                    }
                });
            }
            function clearFilter() {
            var bookItems = document.querySelectorAll('.book-item');
            bookItems.forEach(function(book) {
                book.style.display = 'block';  // Show all books
            });
        }

    </script>

    <footer>
        <p>&copy; 2025 Semua Hak Dilindungi</p>
    </footer>
</body>
</html>
