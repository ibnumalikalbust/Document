<?php
if(empty($this->id_user)){
    redirect("auth/logout");
}
?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url("admin") ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-code"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?= strtoupper(str_replace("@","",$this->user_remote)) ?> TUNNEL</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Remote VPN
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php if($this->p1 == "admin"){ echo "active"; } ?>">
        <a class="nav-link" href="<?= base_url("admin") ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        User
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?php if($this->p1 == "list_vpn" || $this->p1 == "list_order_vpn" || $this->p1 == "order_vpn"){ echo "active"; } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-laptop-house" aria-hidden="true"></i>
            <span>VPN REMOTE</span>
        </a>
        <div id="collapseTwo" class="collapse <?php if($this->p1 == "list_vpn" || $this->p1 == "list_order_vpn" || $this->p1 == "order_vpn"){ echo "show"; } ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">silahkan di pilih</h6>
                <?php
                if($this->role_id == "1"){
                    ?>
                    <a class="collapse-item <?php if($this->p1 == "list_vpn"){ echo "active"; } ?>" href="<?= base_url("list_vpn") ?>"><i class="fas fa-bars mr-2"></i>List VPN</a>
                    <?php
                }
                ?>
                <a class="collapse-item <?php if($this->p1 == "order_vpn"){ echo "active"; } ?>" href="<?= base_url("order_vpn") ?>"><i class="fa-solid fa-plus mr-2"></i>Order VPN</a>
                <a class="collapse-item <?php if($this->p1 == "list_order_vpn"){ echo "active"; } ?>" href="<?= base_url("list_order_vpn") ?>"><i class="fa-solid fa-list mr-2"></i>List Order VPN</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Akun
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?php if($this->p1 == "account" || $this->p1 == "saldo"){ echo "active"; } ?>">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-user-tie"></i>
            <span>My account</span>
        </a>
        <div id="collapsePages" class="collapse <?php if($this->p1 == "account" || $this->p1 == "saldo"){ echo "show"; } ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Informasi Akun:</h6>
                <a class="collapse-item <?php if($this->p1 == "account"){ echo "active"; } ?>" href="<?= base_url("account") ?>"><i class="fas fa-user mr-2"></i> Akun</a>
                <a class="collapse-item <?php if($this->p2 == "isi_saldo"){ echo "active"; } ?>" href="<?= base_url("saldo/isi_saldo") ?>"><i class="fas fa-wallet mr-2"></i> Isi saldo</a>
                <?php
                if($this->role_id == "1"){
                    ?>
                    <a class="collapse-item <?php if($this->p2 == "pending"){ echo "active"; } ?>" href="<?= base_url("saldo/pending") ?>"><i class="fas fa-stopwatch mr-2"></i> Pending saldo</a>
                    <a class="collapse-item <?php if($this->p2 == "success"){ echo "active"; } ?>" href="<?= base_url("saldo/success") ?>"><i class="fas fa-check-circle mr-2"></i> Success saldo</a>
                    <a class="collapse-item <?php if($this->p2 == "cancel"){ echo "active"; } ?>" href="<?= base_url("saldo/cancel") ?>"><i class="fas fa-times-circle mr-2"></i> Cancel saldo</a>
                    <?php
                }
                ?>
            </div>
        </div>
    </li>
    <?php
    if($this->role_id == "1"){
        ?>
        <li class="nav-item <?php if($this->p1 == "user"){ echo "active"; } ?>">
            <a class="nav-link" href="<?= base_url('user/list'); ?>">
                <i class="fas fa-fw fa-users"></i>
                <span>Data User</span></a>
        </li>
        <li class="nav-item <?php if($this->p1 == "routeros"){ echo "active"; } ?>">
            <a class="nav-link" href="<?= base_url('routeros/list'); ?>">
                <i class="fas fa-fw fa-cog"></i>
                <span>Mikrotik Account</span></a>
        </li>
        <li class="nav-item <?php if($this->p1 == "list_payment"){ echo "active"; } ?>">
            <a class="nav-link" href="<?= base_url('list_payment'); ?>">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <span>Payment Method</span></a>
        </li>
        <?php
    }
    ?>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Keluar</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->