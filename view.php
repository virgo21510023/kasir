<?php

require 'ceklogin.php';

if (isset($_GET['idp'])) {
    $idp = $_GET['idp'];

    $ambilnamapelanggan = mysqli_query($connection,"SELECT * FROM pesanan p, pelanggan pl WHERE p.id_pelanggan=pl.id_pelanggan AND p.id_pesanan='$idp'");
    $np = mysqli_fetch_array($ambilnamapelanggan);
    $namapel = $np["nama_pelanggan"];
} else {
    header("location:index.php");
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Aplikasi Kasir</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                                Pesanan
                            </a>
                            <a class="nav-link" href="stok.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cubes"></i></div>
                                Stok Buku
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-plus-square"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4 ">Kelola Pesanan : <?= $idp;?></h1>
                        <h4>Nama Pelanggan : <?= $namapel;?></h4>
                        <div class="row">
                            <div class="col-xl-3 col-md-6 mb-2">
                                <div>   
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                        Tambah Pesanan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Buku</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Sub-total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Buku</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Sub-total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            $get = mysqli_query($connection, "SELECT * FROM detail_pesanan dp, buku bk WHERE dp.id_buku=bk.id_buku AND id_pesanan='$idp'");
                                            $i=1;
                                            while ($p=mysqli_fetch_array($get)) {
                                                $qty = $p["qty"];
                                                $harga = $p["harga"];
                                                $judul_buku  = $p["judul_buku"];
                                                $subtotal = $qty * $harga;
                                        ?>
                                        <tr>
                                            <td><?= $i++;?></td>
                                            <td><?= $judul_buku ?></td>
                                            <td>Rp. <?= number_format($harga) ?>,-</td>
                                            <td><?= number_format($qty) ?></td>
                                            <td>Rp. <?= number_format($subtotal) ?>,-</td>
                                            <td> <a href="view.php?idp=<?=$id_pesanan;?>" class="btn btn-primary" target="blank"> Edit </a> | Delete </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

    <!-- The Modal -->
    <div class="modal" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Tambahkan Pesanan</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <form method="POST" action="" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="">
                <div class="">Pilih Buku</div>
                <select name="id_buku" class="form-control mt-2">
                <?php
                    $getbuku = mysqli_query($connection, "SELECT * FROM buku WHERE id_buku NOT IN (SELECT id_buku FROM detail_pesanan WHERE id_pesanan = '$idp')");

                    while ($bku = mysqli_fetch_array($getbuku)) {
                        $id_buku = $bku["id_buku"];
                        $judul_buku = $bku["judul_buku"];
                        $penulis = $bku["penulis"];
                        $stok = $bku["stok"];
                    ?>
                    <option value="<?= $id_buku ;?>"> <?= $judul_buku; ?> - <?= $penulis; ?> (Stok  : <?= $stok;?>)
                        
                    </option>
                    <?php
                    }
                    ?>
                    <input type="number" name="qty" class="form-control mt-2" placeholder="Jumlah" min="1" required>
                    <input type="hidden" name="idp" value="<?= $idp; ?>">
                </select>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="tambahbuku2">Tambah</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
          </div>
          </form>

        </div>
      </div>
    </div>
</html>
