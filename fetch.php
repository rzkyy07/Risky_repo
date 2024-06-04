<?php

$url = 'http://localhost/warungkopi/api/api.php';

$data = file_get_contents($url);

if ($data === false) {
    die('Failed fetch api');
}

$result = json_decode($data, true);

if ($result === null) {
    die('Error decoding json data');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fetch api</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body>
    <h2 class="header">Assets<h2>
    <table class="table table-bordered">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">nama</th>
            <th scope="col">harga</th>
            <th scope="col">keterangan</th>
            <th scope="col">kategori</th>
            <th scope="col">image</th>
            <th scope="col">jumlah terjual</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach($result as $dt) : ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $dt['menu_nama']?></td>
            <td><?= $dt['harga'] ?></td>
            <td><?= $dt['keterangan'] ?></td>
            <td><?= $dt['kategori'] ?></td>
            <td><img src="<?= $dt['image'] ?>" alt="Gambar" width="100" height="100"></td>
            <td><?= isset($dt['jumlah_penjualan']) ? $dt['jumlah_penjualan'] : 'Data tidak tersedia' ?></td>

        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>
</body>

</html>
