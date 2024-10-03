<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Form Pembelian</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pembeli</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="barang" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="barang" name="barang" required>
            </div>
            <div class="mb-3">
                <label for="member" class="form-label">Status Member</label>
                <select class="form-select" id="member" name="member" required>
                    <option value="yes">Member</option> <!-- Membuat pilihan apakah pembeli merupakan member atau bukan -->
                    <option value="no">Non-Member</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga Barang (per item)</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah Barang</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
            </div>
            <button type="submit" class="btn btn-primary">Hitung Total</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Mengambil data dari form html
            $nama = $_POST['nama'];
            $barang = $_POST['barang'];
            $member = $_POST['member'];
            $harga = $_POST['harga'];
            $jumlah = $_POST['jumlah'];

            // Menghitung total harga awal (sebelum dikurangi diskon)
            $totalHarga = $harga * $jumlah;

            // Menghitung diskon
            $diskon = 0; // Memberikan nilai awal diskon
            if ($member == "yes") {
                // Diskon untuk member
                $member = "Member";
                $diskon = 10; // Diskon 10% untuk member
                if ($totalHarga >= 500000) {
                    $diskon += 10; // Tambahan diskon 10% jika total belanja >= 500000
                } elseif ($totalHarga >= 300000) {
                    $diskon += 5; // Tambahan diskon 5% jika total belanja >= 300000
                }
            } else {
                $member = "Non-Member";
                // Diskon untuk non-member
                if ($totalHarga >= 500000) {
                    $diskon = 10; // Diskon 10% jika total belanja >= 500000
                }
            }

            // Hitung total setelah diskon
            $potongan = ($diskon / 100) * $totalHarga;
            $totalSetelahDiskon = $totalHarga - $potongan;

            
            // Tampilkan hasil
            echo "<div class='alert alert-info mt-4'>";
            echo "<h4>Rincian Pembelian</h4>";
            echo "<p>Nama Pembeli : $nama <font color='success' size='2px'>($member)</font> </p>" ;
            echo "<p>Barang : $barang</p>";
            echo "<p>Jumlah Barang : $jumlah</p>";
            echo "<p>Total Harga : Rp " . number_format($totalHarga, 0, ',', '.') . "</p>";

            // Percabangan jika pembeli tidak mendapatkan diskon, maka nilai diskon tidak muncul
            if ($potongan > 0) {
                echo "<p>Diskon : Rp " . number_format($potongan, 0, ',', '.') ."<font size='2px'> ($diskon%) </font></p>";
            } else {
                echo "<p>Diskon : - </p>";
            }
            
            echo "<p>Total Pembelian : Rp " . number_format($totalSetelahDiskon, 0, ',', '.') . "</p>"; // Harga akhir yang harus dibayar oleh pembeli
            echo "</div>";
        }
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
