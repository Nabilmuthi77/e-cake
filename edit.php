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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_POST['submit'])) {
        $nama = $_POST['nama'];
        $noKursi = $_POST['noKursi'];
        $jenisKue = $_POST['package'];
        $tipePesanan = $_POST['tipePesanan'];
        $harga = $_POST['price'];
        $diskon = $_POST['discount'];
        $pembayaran = $_POST['pembayaran'];

        $hargaTotal = getHargaTotal($harga, $diskon);

        $dataOrder[$id]["nama"] = $nama;
        $dataOrder[$id]["nomor_kursi"] = $noKursi;
        $dataOrder[$id]["jenis_kue"] = $jenisKue;
        $dataOrder[$id]["tipe_pesanan"] = $tipePesanan;
        $dataOrder[$id]["harga_kue"] = $harga;
        $dataOrder[$id]["diskon_kue"] = $diskon;
        $dataOrder[$id]["pembayaran"] = $pembayaran;
        $dataOrder[$id]["harga_total"] = $hargaTotal;

        $dataOrderJson = json_encode($dataOrder, JSON_PRETTY_PRINT);
        file_put_contents($file, $dataOrderJson);

        // Redirect kembali ke halaman utama setelah data diubah
        header("Location: index.php");
        exit();
    }

    $nama = $dataOrder[$id]["nama"];
    $noKursi = $dataOrder[$id]["nomor_kursi"];
    $jenisKue = $dataOrder[$id]["jenis_kue"];
    $tipePesanan = $dataOrder[$id]["tipe_pesanan"];
    $harga = $dataOrder[$id]["harga_kue"];
    $diskon = $dataOrder[$id]["diskon_kue"];
    $pembayaran = $dataOrder[$id]["pembayaran"];
    $hargaTotal = $dataOrder[$id]["harga_total"];

} else {
    // Jika tidak ada ID yang diberikan, kembali ke halaman utama
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Cake Edit</title>
    <link rel="icon" type="image/x-icon" href="img/favLogo.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body style="background-color: pink;">

<nav class="fixed-top navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="img/favLogo.png" alt="" width="50" height="50" class="d-inline-block align-text-top"
                    style="border-radius: 50%; margin-left: 20px; margin-right: 5px;">
                <h1 class="d-inline-block align-text-top">e-Cake</h1>
            </a>
        </div>
    </nav>

    <span class="mx-5"><br> <br></span> <!-- Agar Tampilan tidak tertutup oleh Navbar -->

    <div class="container mt-5">
        <div class="card col-lg-6 mx-auto">
            <div class="card-header">
                <h2>Edit Menu of Order Cake's</h2>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <img src="img/cover.jpg" class="img-thumbnail mb-3" alt=""> <br>
                    Masukkan Nama Pemesan <input type="text" name="nama" placeholder="Masukkan Nama" value="<?php echo $nama; ?>"
                        class="form-control" required> <br>
                    Masukkan Nomor Kursi <input type="number" name="noKursi" placeholder="Tersedia 1 - 90  (Input 0 Jika Pesanan Dibungkus)" min="0"
                        max="90" value="<?php echo $noKursi; ?>" class="form-control" required> <br>
                        Pilih Menu Cake <br>
                    <select name="package" id="package" class="form-select" required>
                        <?php  if ($jenisKue == "Banana Cake") { ?>
                        <option disabled>-- Pilih List Menu Cake --</option>
                        <option data-price="10000" data-discount="0" selected>Banana Cake</option>
                        <option data-price="15000" data-discount="30">Strawberry Cake</option>
                        <option data-price="20000" data-discount="5">Vanilla Cake</option>
                        <option data-price="30000" data-discount="10">Special Pudding</option>
                        <?php } elseif ($jenisKue == "Strawberry Cake") { ?>
                        <option disabled>-- Pilih List Menu Cake --</option>
                        <option data-price="10000" data-discount="0">Banana Cake</option>
                        <option data-price="15000" data-discount="30" selected>Strawberry Cake</option>
                        <option data-price="20000" data-discount="5">Vanilla Cake</option>
                        <option data-price="30000" data-discount="10">Special Pudding</option>
                        <?php } elseif ($jenisKue == "Vanilla Cake") { ?>
                        <option disabled>-- Pilih List Menu Cake --</option>
                        <option data-price="10000" data-discount="0">Banana Cake</option>
                        <option data-price="15000" data-discount="30">Strawberry Cake</option>
                        <option data-price="20000" data-discount="5" selected>Vanilla Cake</option>
                        <option data-price="30000" data-discount="10">Special Pudding</option>
                        <?php } else { ?>
                        <option disabled>-- Pilih List Menu Cake --</option>
                        <option data-price="10000" data-discount="0">Banana Cake</option>
                        <option data-price="15000" data-discount="30">Strawberry Cake</option>
                        <option data-price="20000" data-discount="5">Vanilla Cake</option>
                        <option data-price="30000" data-discount="10" selected>Special Pudding</option>
                        <?php } ?>
                    </select> <br>
                    Tipe Pesanan <br>
                    <input type="radio" name="tipePesanan" value="Dibungkus" <?php if ($tipePesanan == "Dibungkus") echo "checked"; ?> class="form-check-input"> Dibungkus
                    <input type="radio" name="tipePesanan" value="Makan Disini" <?php if ($tipePesanan == "Makan Disini") echo "checked"; ?> class="form-check-input"> Makan Disini
                    <br> <br>
                    Harga Cake <input type="number" name="price" placeholder="Kalkulasi Otomatis" value="<?php echo $harga; ?>" class="form-control" 
                        readonly> <br>
                    Diskon Manja <input type="number" name="discount" placeholder="Kalkulasi Otomatis" value="<?php echo $diskon; ?>" class="form-control"
                        readonly> <br>
                        Pembayaran <br>
                    <select name="pembayaran" class="form-select" required>
                        <?php if($pembayaran == "Sudah Bayar") { ?>
                        <option disabled>-- Pilih Metode Pembayaran --</option>
                        <option value="Sudah Bayar" selected>Sudah Bayar</option>
                        <option value="Belum Bayar">Belum Bayar</option>
                        <?php } else { ?>
                        <option disabled>-- Pilih Metode Pembayaran --</option>
                        <option value="Sudah Bayar">Bayar Sekarang (Cash)</option>
                        <option value="Belum Bayar" selected>Bayar Nanti</option>
                        <?php } ?>
                    </select> <br>
                    <input type="submit" value="Simpan Pesanan" name="submit" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    <br>


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
