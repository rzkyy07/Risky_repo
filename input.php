<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'cafe';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

if (isset($_POST['nama'], $_POST['harga'], $_POST['keterangan'], $_POST['kategori'], $_FILES['image'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $keterangan = $_POST['keterangan'];
    $kategori = $_POST['kategori'];

    $targetDir = 'uploads/';
    $targetFile = $targetDir . basename($_FILES['image']['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check !== false) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            echo '';
        } else {
            echo 'Maaf, terjadi kesalahan saat mengunggah file Anda.';
        }
    } else {
        echo 'File bukan gambar.';
    }

    $sql = "INSERT INTO menu (menu_nama, harga, keterangan, image, kategori) VALUES ('$nama', '$harga', '$keterangan', '$targetFile', '$kategori')";

    if ($conn->query($sql) === true) {
        echo 'Catatan baru berhasil dibuat';

        $newMenuId = $conn->insert_id;

        $insertBestSellerSql = "INSERT INTO best_seller (menu_id, jumlah_penjualan) VALUES ('$newMenuId', 0)";
        if ($conn->query($insertBestSellerSql) === true) {
            echo ' dan tabel best_seller diperbarui dengan sukses.';
        } else {
            echo ' tetapi terjadi kesalahan saat memperbarui tabel best_seller: ' . $conn->error;
        }
    } else {
        echo 'Kesalahan: ' . $sql . '<br>' . $conn->error;
    }
} else {
    echo 'Kolom formulir tidak diatur.';
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="file"] {
            margin-bottom: 16px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #4CAF50;
        }

        input[type="file"] {
            padding: 8px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border-radius: 8px;
            padding: 14px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .container {
            width: 500px;
            height: 400px;
        }

        select {
            border: none;
            border-radius: 8px;
            padding: 14px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="./input.php" method="post" enctype="multipart/form-data">
            <input type="text" name="nama" placeholder="Input nama" required>
            <input type="text" name="harga" placeholder="Input harga" required>
            <input type="text" name="keterangan" placeholder="Input keterangan" required>
            <select name="kategori"  required>
                <option value="">--Pilih Kategori--</option>
                <option value="minuman">Minuman</option>
                <option value="makanan">Makanan</option>
            </select>
            <input type="file" name="image" accept="image/*" required>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>
