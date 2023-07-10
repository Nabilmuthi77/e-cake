<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Cake</title>
    <link rel="icon" type="image/x-icon" href="img/favLogo.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
    a {
        text-decoration: none;
        font-weight: bolder;
    }
    </style>
</head>

<body style="background-color: pink;">

    <nav class="fixed-top navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/favLogo.png" alt="" width="50" height="50" class="d-inline-block align-text-top"
                    style="border-radius: 50%; margin-left: 20px; margin-right: 5px;">
                <h1 class="d-inline-block align-text-top">e-Cake</h1>
            </a>
            <a href="#listOrdered" class="text-dark" style="margin-right: 20px; font-size: 20px;">List Ordered</a>
        </div>
    </nav>

    <span class="mx-5"><br> <br></span> <!-- Agar Tampilan tidak tertutup oleh Navbar -->

    <div class="container mt-5">
        <div class="card col-lg-6 mx-auto">
            <div class="card-header">
                <h2>List Menu of Borcelle Cake's</h2>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <img src="img/cover.jpg" class="img-thumbnail mb-3" alt=""> <br>
                    Masukkan Nama Pemesan <input type="text" name="nama" placeholder="Masukkan Nama"
                        class="form-control" required> <br>
                    Masukkan Nomor Kursi <input type="number" name="noKursi" placeholder="Tersedia 1 - 90  (Input 0 Jika Pesanan Dibungkus)" min="0"
                        max="90" class="form-control" required> <br>
                    Pilih Menu Cake <br>
                    <select name="package" id="package" class="form-select" required>
                        <option selected disabled>-- Pilih List Menu Cake --</option>
                        <option data-price="10000" data-discount="0">Banana Cake</option>
                        <option data-price="15000" data-discount="30">Strawberry Cake</option>
                        <option data-price="20000" data-discount="5">Vanilla Cake</option>
                        <option data-price="30000" data-discount="10">Special Pudding</option>
                    </select> <br>
                    Tipe Pesanan <br>
                    <input type="radio" name="tipePesanan" value="Dibungkus" class="form-check-input"> Dibungkus
                    <input type="radio" name="tipePesanan" value="Makan Disini" class="form-check-input"> Makan Disini
                    <br> <br>
                    Harga Cake <input type="number" name="price" placeholder="Kalkulasi Otomatis" class="form-control"
                        readonly> <br>
                    Diskon Manja <input type="number" name="discount" placeholder="Kalkulasi Otomatis"
                        class="form-control" readonly> <br>
                    Pembayaran <br>
                    <select name="pembayaran" class="form-select" required>
                        <option selected disabled>-- Pilih Metode Pembayaran --</option>
                        <option value="Sudah Bayar">Bayar Sekarang (Cash)</option>
                        <option value="Belum Bayar">Bayar Nanti</option>
                    </select> <br>
                    <input type="submit" value="Buat Pesanan" name="submit" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    <br>

    <?php
$file = "data.json";
$dataOrder = array();
$dataJson = file_get_contents($file);
$dataOrder = json_decode($dataJson, true);

function getHargaTotal($h, $d)
{
    $hTotal =$h - $d;
    return $hTotal;
}


if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $noKursi = $_POST['noKursi'];
    $jenisKue = $_POST['package'];
    $tipePesanan = $_POST['tipePesanan'];
    $harga = $_POST['price'];
    $diskon = $_POST['discount'];
    $pembayaran = $_POST['pembayaran'];

    $hargaTotal = getHargaTotal($harga, $diskon);

    $dataBaru = array(
        "nama" => $nama,
        "nomor_kursi" => $noKursi,
        "jenis_kue" => $jenisKue,
        "tipe_pesanan" => $tipePesanan,
        "harga_kue" => $harga,
        "diskon_kue" => $diskon,
        "harga_total" => $hargaTotal,
        "pembayaran" => $pembayaran,
    );

    array_push($dataOrder, $dataBaru);

    $dataOrderJson = json_encode($dataOrder, JSON_PRETTY_PRINT);
    file_put_contents($file, $dataOrderJson);
}
?>

    <?php

if (isset($_GET['delete'])) {
    $deleteIndex = $_GET['delete'];

    // Hapus data order berdasarkan index yang diberikan
    if (isset($dataOrder[$deleteIndex])) {
        unset($dataOrder[$deleteIndex]);

        // Menyusun ulang indeks array setelah menghapus data
        $dataOrder = array_values($dataOrder);

        $dataOrderJson = json_encode($dataOrder, JSON_PRETTY_PRINT);
        file_put_contents($file, $dataOrderJson);

        // Redirect kembali ke halaman utama setelah data dihapus
        header("Location: index.php");
        exit();
    }
}
?>
    <?php if ($dataOrder) { ?>
    <div class="container-fluid table-responsive">
        <table border="1" class="table table-bordered table-striped bg-light text-center" id="listOrdered">
            <tr class="card-header">
                <th>NO</th>
                <th>NAMA PEMESAN</th>
                <th>NO KURSI</th>
                <th>CAKE ORDER</th>
                <th>TIPE PESANAN</th>
                <th>HARGA CAKE </th>
                <th>DISKON MANJA</th>
                <th>TOTAL HARGA</th>
                <th>STATUS PEMBAYARAN</th>
                <th>AKSI</th>
            </tr>

    <?php
        for ($i = 0; $i < sizeof($dataOrder); $i++) {
            $nama = $dataOrder[$i]["nama"];
            $noKursi = $dataOrder[$i]["nomor_kursi"];
            $jenisKue = $dataOrder[$i]["jenis_kue"];
            $tipePesanan = $dataOrder[$i]["tipe_pesanan"];
            $harga = $dataOrder[$i]["harga_kue"];
            $diskon = $dataOrder[$i]["diskon_kue"];
            $hargaTotal = $dataOrder[$i]["harga_total"];
            $pembayaran = $dataOrder[$i]["pembayaran"];
    ?>

            <tr>
                <td><?=$i + 1;?></td>
                <td><?=$nama;?></td>
                <td><?=$noKursi;?></td>
                <td><?=$jenisKue;?></td>

                <td><?=$tipePesanan;?></td>
                <td>Rp. <?=$harga;?></td>
                <td>Rp. <?=$diskon;?></td>
                <td>Rp. <?=$hargaTotal;?></td>
                <td><?=$pembayaran;?></td>
                <td>
                    <a href="edit.php?id=<?=$i;?>" class="text-white badge bg-warning">Edit</a>
                    <a href="index.php?delete=<?=$i;?>"
                        onclick='return confirm("Apakah Anda yakin ingin menghapus data ini?")'
                        class="text-white badge bg-danger">Delete</a>
                </td>
            </tr>

            <?php }?>
        </table>
        <?php }?>
    </div>

    <footer>
        <div class="container-fluid bg-light">
            <div class="container text-center">
                <h4 class="mx-auto my-auto py-4">@copyright Web e-Cake 2023</h4>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>

</html>