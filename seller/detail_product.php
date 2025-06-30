<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
<style>
body {
    background-color:rgb(88, 169, 12);
    padding: 20px;
    font-family: Pacifico, cursive;
}

form {
    background-color:rgb(188, 255, 155);
    padding: 20px;
    border-radius: 10px;
    width: 50%;
    margin: auto
}

h1 {
    text-align: center;
    background-color:rgb(168, 235, 129);
    padding: 10px;
    border-radius: 10px;
}

input[type="text"],
input[type="datetime-local"],
input[type="file"] {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="submit"], input[type="reset"] {
    background-color: #28a745;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="reset"] {
    background-color: #dc3545;
}

input[type="submit"]:hover {
    background-color: #218838;
}

input[type="reset"]:hover {
    background-color: #c82333;
}

a {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #012b58;
    font-weight: bold;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
</head>
    
  <h1>Tentang produk</h1> 

  <form name="formbiodata" action="#" method="post">
    <p>Berikut ini adalah deskripsi lengkap dari produk </p>
    <label for="txtfullname" > Nama produk : Bunga Freesia</label>
    <br><br>
    <label for="txtnickname" > Harga : 35.000 </label>
    <br><br>
    <label for="txtnickname" > Stok: 15.000 </label>
    <br><br>
    <label for="txtinstagram" > Deskripsi produk : Freesia hidroponik adalah bunga dengan aroma wangi yang kuat dan kelopak berwarna-warni. Cocok untuk dekorasi ruangan karena bentuknya yang indah dan warnanya yang menarik.  </label>
    <br><br>
    

  </form>

  <div class="form-actions">
            <a href="dashboard_seller.php?page=products" class="btn btn-secondary">Kembali</a>
        </div>

</body>
</html>