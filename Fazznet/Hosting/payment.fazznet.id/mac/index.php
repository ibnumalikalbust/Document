<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MAC ADDRESS</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <main>

  <form method="post" autocomplete="off">
    <input type="text" name="mac">
    <br><br>
    <button type="submit" name="submit">CEK</button>
    <br><br>
  </form>

  <?php if(isset($_POST["submit"])) {
      echo "MAC: ".$_POST["mac"]."<br>";
      $mac_address = $_POST["mac"];
      $url = "https://api.macvendors.com/" . urlencode($mac_address);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch);
      if($response) {
        echo "Vendor: $response <br>";
        if($response == '{"errors":{"detail":"Not Found"}}') {
          echo "MAC ACAK";
        } else {
          echo "MAC PERANGKAT";
        }
      } else {
        echo "Not Found";
      }
    }
  ?>

  </main>
</body>
</html>