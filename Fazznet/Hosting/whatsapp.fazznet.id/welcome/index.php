<?php
require('../require/f.php');
if ($_SESSION['rid_username']) {
    $u = $_SESSION['rid_username'];
    $datser = $con->query("SELECT * FROM rid_account WHERE rid_username = '$u'")->fetch_assoc();
}
?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="en"><head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Whatsapp Gateway">
    <meta name="description" content="<?php echo $rid['web_setting']['description'];?>">
    <title><?php echo $rid['web_setting']['title'];?></title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
    <link rel="stylesheet" href="Home.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": "",
		"logo": "images/default-logo.png"
}</script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="WaySender">
    <meta property="og:type" content="website">
  </head>
  <body data-home-page="Home.html" data-home-page-title="Home" class="u-body u-xl-mode" data-lang="en"><header class="u-clearfix u-header u-header" id="sec-00be"><div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <a href="../index.php?link1=welcome" class="u-image u-logo u-image-1">
          <img src="images/default-logo.png" class="u-logo-image u-logo-image-1">
        </a>
        <nav class="u-menu u-menu-one-level u-offcanvas u-menu-1">
          <div class="menu-collapse" style="font-size: 1rem; letter-spacing: 0px;">
            <a class="u-button-style u-custom-left-right-menu-spacing u-custom-padding-bottom u-custom-top-bottom-menu-spacing u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="#">
              <svg class="u-svg-link" viewBox="0 0 24 24"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#menu-hamburger"></use></svg>
              <svg class="u-svg-content" version="1.1" id="menu-hamburger" viewBox="0 0 16 16" x="0px" y="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><g><rect y="1" width="16" height="2"></rect><rect y="7" width="16" height="2"></rect><rect y="13" width="16" height="2"></rect>
</g></svg>
            </a>
          </div>
          <div class="u-custom-menu u-nav-container">
            <ul class="u-nav u-unstyled u-nav-1"><li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="../index.php?link1=welcome" style="padding: 10px 20px;">Home</a>
</li>
<?php if ($_SESSION['rid_username']) { ?>
<li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="../index.php?link1=home" style="padding: 10px 20px;">Open Dashboard</a>
</li>
<?php } else { ?>
<li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="../index.php?link1=login" style="padding: 10px 20px;">Login</a>
</li>
<li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="../index.php?link1=register" style="padding: 10px 20px;">Register</a>
</li>
<?php } ?>
</ul>
          </div>
          <div class="u-custom-menu u-nav-container-collapse">
            <div class="u-black u-container-style u-inner-container-layout u-opacity u-opacity-95 u-sidenav">
              <div class="u-inner-container-layout u-sidenav-overflow">
                <div class="u-menu-close"></div>
                <ul class="u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2"><li class="u-nav-item"><a class="u-button-style u-nav-link" href="../index.php?link1=welcome">Home</a>
</li>
<?php if ($_SESSION['rid_username']) { ?>
<li class="u-nav-item"><a class="u-button-style u-nav-link" href="../index.php?link1=home">Open Dashboard</a>
</li>
<?php } else { ?>
<li class="u-nav-item"><a class="u-button-style u-nav-link" href="../index.php?link1=login">Login</a>
</li>
<li class="u-nav-item"><a class="u-button-style u-nav-link" href="../index.php?link1=register">Register</a>
</li>
<?php } ?>
</ul>
              </div>
            </div>
            <div class="u-black u-menu-overlay u-opacity u-opacity-70"></div>
          </div>
        </nav>
      </div></header>
    <section class="u-align-center u-clearfix u-image u-shading u-section-1" id="carousel_fc68" data-image-width="1920" data-image-height="992">
      <div class="u-clearfix u-sheet u-sheet-1">
        <h1 class="u-text u-text-1">SELAMAT DATANG <?php if ($_SESSION['rid_username']) { echo strtoupper($datser['full_name']); } else { echo $rid['web_setting']['title']; }?></h1>
        <p class="u-text u-text-2">Bikin aplikasi websitemu jadi keren dengan WaySender</p>
        <div class="u-table u-table-responsive u-table-1">
          <table class="u-table-entity u-table-entity-1">
            <colgroup>
              <col width="33.01%">
              <col width="33.01%">
              <col width="33.98%">
            </colgroup>
            <thead class="u-align-center u-grey-10 u-table-header u-table-header-1">
              <tr style="height: 66px;">
                <th class="u-border-2 u-border-palette-1-light-1 u-palette-2-light-1 u-table-cell u-table-cell-1">Paket 1</th>
                <th class="u-border-2 u-border-palette-1-light-1 u-palette-2-base u-table-cell u-table-cell-2">Paket 2</th>
                <th class="u-border-2 u-border-palette-1-light-1 u-palette-1-base u-table-cell u-table-cell-3">Paket 3</th>
              </tr>
            </thead>
            <tbody class="u-align-center u-grey-90 u-table-alt-grey-80 u-table-body u-table-body-1">
              <tr style="height: 52px;">
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-4">Fitur</td>
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-5">Fitur</td>
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-6">Fitur</td>
              </tr>
              <tr style="height: 52px;">
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-7">Fitur 2</td>
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-8">Fitur 2</td>
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-9">Fitur 2</td>
              </tr>
              <tr style="height: 52px;">
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-10">Free Trial</td>
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-11">Free Trial</td>
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-12">Free Trial</td>
              </tr>
              <tr style="height: 52px;">
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-13">harga</td>
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-14">harga</td>
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-15">harga</td>
              </tr>
              <?php if (!$_SESSION['rid_username']) { ?>
              <tr style="height: 60px;">
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-16">
                  <a href="../index.php?link1=login" class="u-btn u-btn-rectangle u-button-style u-palette-2-light-1 u-btn-1">BELI</a>
                </td>
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-17">
                  <a href="../index.php?link1=login" class="u-btn u-btn-rectangle u-button-style u-palette-2-base u-btn-2">BELI</a>
                </td>
                <td class="u-border-2 u-border-grey-75 u-table-cell u-table-cell-18">
                  <a href="../index.php?link1=login" class="u-btn u-btn-rectangle u-button-style u-palette-1-base u-btn-3">BELI</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <p class="u-text u-text-body-alt-color u-text-3">Whatsapp Gateway Termurah seindonesia!!</p>
      </div>
    </section>
    
    
    <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-c301"><div class="u-clearfix u-sheet u-sheet-1">
        <p class="u-small-text u-text u-text-variant u-text-1">Copyright@2022 <?php echo $rid['web_setting']['footer'];?></p>
      </div></footer>
    <section class="u-backlink u-clearfix u-grey-80">
      <span>FROM </span><a class="u-link" href="https://ridped.com" target="_blank">
        <span>RIDPEDIA</span>
      </a>
    </section>
  
</body></html>