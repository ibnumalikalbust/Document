<?php
if (!isset($_SESSION["mikhmon"])) {
    header("Location:../admin.php?id=login");
  } else {
        $_SESSION["v"] = "3.20 06-30-2021<br>
Jangan Pernah Menginfokan Link Mikhmon Online Anda Kepada Orang Lain<br>
Silahkan Ubah Username & Password Mikhmon Demi Keamanan Mikrotik Anda<br>
Terima Kasih Banyak Telah Menggunakan Layanan Mikhmon Online Fazznet<br>


<br>";
    
    }