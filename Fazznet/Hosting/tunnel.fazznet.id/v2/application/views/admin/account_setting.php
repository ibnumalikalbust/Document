<?php
$data = $this->model->gd("user","*","id = '".$this->id_user."'","row");
if(empty($data->id)){
    redirect("auth/logout");
}
?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?=$nzm?></h1>
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-gradient-primary user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25"> <img src="<?= base_url("assets/img/profile/default.jpg") ?>" class="img-profile rounded-circle" width="100" alt="User-Profile-Image"> </div>
                                <h6 class="f-w-600"><?= $data->name; ?></h6> <small><?= $data->email; ?></small>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600"> <i class="far fa-envelope" aria-hidden="true"></i> Email</p>
                                        <h6 class="text-muted f-w-400"><?= $data->email; ?></h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600"><i class="fas fa-coins fa-sm" aria-hidden="true"></i> Tunnel Coin</p>
                                        <h6 class="text-muted f-w-400">Rp <?= number_format($data->saldo,0,"","."); ?></h6>
                                    </div>
                                </div>
                                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">More Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600"><i class="fas fa-user-plus" aria-hidden="true"></i> Registered Date</p>
                                        <h6 class="text-muted f-w-400"><?= date("d M Y H:i:s",$data->date_created); ?></h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> Last Login</p>
                                        <h6 class="text-muted f-w-400"><?= date("d M Y H:i:s",strtotime($data->last_login)); ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8 order-xl-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-fw fa-user-cog" style="font-size:13px;" aria-hidden="true"></i> Edit Account </h6>
                </div>
                <div class="collapse show" id="account">
                    <div class="card-body">
                        <form id="UpdateAccount" action="<?= base_url("editing_account") ?>" method="post">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0"> <label for="email"><i class="fas fa-user fa-fw" style="font-size:13px;" aria-hidden="true"></i> Name :</label> <input type="text" id="subject" placeholder="name" class="form-control" name="name" value="<?= $data->name ?>" required=""> </div>
                            </div>
                            <div class="form-group"> <label for="email"><i class="fas fa-envelope fa-fw" style="font-size:13px;" aria-hidden="true"></i> Email :</label> <input type="text" id="subject" placeholder="Email" class="form-control" name="email" value="<?= $data->email; ?>" readonly> </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0"> <label for="email"><i class="fas fa-lock fa-fw" style="font-size:13px;" aria-hidden="true"></i> New Password :</label> <input type="password" id="subject" class="form-control" name="password" placeholder="********"> </div>
                                <div class="col-sm-6 "> <label for="email"><i class="fas fa-sync fa-fw" style="font-size:13px;" aria-hidden="true"></i> Confirm New Password :</label> <input type="password" id="subject" class="form-control" name="conf_password" placeholder="********"> </div>
                            </div>
                            <?php
                            if($this->role_id == "1"){
                                ?>
                                <div class="form-group"> <label for="id_telegram"><i class="fab fa-telegram fa-fw" style="font-size:13px;" aria-hidden="true"></i> ID Telegram :</label> <input type="number" id="id_telegram" placeholder="ID Telegram, Contoh : 123456789" class="form-control" name="id_telegram" value="<?= $data->id_telegram; ?>" required=""> </div>

                                <div class="form-group"> <label for="user_remote"><i class="fas fa-house-laptop fa-fw" style="font-size:13px;" aria-hidden="true"></i> User Remote :</label> <input type="text" id="user_remote" placeholder="User Remote, Contoh : TEXA.net" class="form-control" name="user_remote" value="<?= $data->user_remote; ?>" required=""> </div>

                                <div class="form-group"> <label for="server"><i class="fas fa-server fa-fw" style="font-size:13px;" aria-hidden="true"></i> ID Server :</label> <input type="text" id="server" placeholder="Server, Contoh : Texa.my.id" class="form-control" name="server" value="<?= $data->server; ?>" required=""> </div>
                                <?php
                            }
                            ?>
                            <div class="col-xl-12 col-sm-12 col-md-6 mb-4" id="result" role="alert"></div>
                            <div class="col-md-6"></div> <input type="hidden" name="form_submission" value="edit_user"> <input type="hidden" name="username" value="malik16"> <input type="hidden" name="usertoedit" value="malik16"> <input type="hidden" id="edit-user" name="edit-user" value="9a11f471531e8ff754927541b3c837a0"> <br>
                            <div class="modal-footer"> <button type="reset" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fas fa-undo" style="font-size:13px" aria-hidden="true"></i> Reset</button> <button class="btn btn-sm btn-primary" id="action"><i class="fas fa-paper-plane" style="font-size:13px" aria-hidden="true"></i> Save</button> </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 order-xl-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-fw fa-exclamation-circle" style="font-size:13px;" aria-hidden="true"></i> Informasi </h6>
                </div>
                <div class="collapse show" id="informasivpn">
                    <div class="card-body"> <small><i class="fas fa-dot-circle fa-fw" style="font-size:10px;" aria-hidden="true"></i> <b>Untuk mengubah informasi akun tanpa mengubah password, silahkan kosongkan password nya. </b> </small><br> <small><i class="fas fa-dot-circle fa-fw" style="font-size:10px;" aria-hidden="true"></i> <b>Harap hati hati dalam mengubah password !</b></small><br> </div>
                </div>
            </div>
        </div>
    </div>
</div>