<?php
$con = $rid['sqlConnect'];
if ($f == 'cron-blast') {
    ignore_user_abort(true); 
    set_time_limit(0);
    $count = 0;
    $now = strtotime(date("Y-m-d H:i:s"));
    $chunk = 100;
    $q = mysqli_query($con, "SELECT * FROM pesan WHERE status = 'MENUNGGU JADWAL' ORDER BY id");
    $i = 0;
    while ($data = $q->fetch_assoc()) {
       $jadwal = strtotime($data['jadwal']);
       if ($jadwal < $now) {
    
            $sender = $data['sender'];
            $nomor = $data['nomor'];
            $pesan = urlencode($data['pesan']);
            $media = $data['media'];
            $this_id = $data['id'];
            if ($data['media'] == null) {
                $send = sendMSG($sender, $nomor, $pesan);
                if ($send['Status']['status'] == 200) {
                    $i++;
                    $this_id = $data['id'];
                    $q3 = mysqli_query($con, "UPDATE pesan SET status = 'TERKIRIM' WHERE id='$this_id'");
                    $z = true;
                } else {
                    $s = false;
                    $q3 = mysqli_query($con, "UPDATE pesan SET status = 'GAGAL' WHERE id='$this_id'");
                }
                sleep(5);
            } else {
                $a = explode('/', $media);
                $filename = $a[count($a) - 1];
                $a2 = explode('.', $filename);
                $namefile = $a2[count($a2) - 2];
                $filetype = $a2[count($a2) - 1];
                $this_id = $data['id'];
                $send = sendMedia($sender, $nomor, $media, $filetype, $namefile, $pesan);
                if ($send['Status']['status'] == 200) {
                    $i++;
                    $q3 = mysqli_query($con, "UPDATE pesan SET status = 'TERKIRIM' WHERE id='$this_id'");
                } else {
                    $q3 = mysqli_query($con, "UPDATE pesan SET status = 'GAGAL' WHERE id='$this_id'");
                    $s = false;
                }
                sleep(5);
            }
        }
    }
}