<?php include("template/header.php")?>  

<?php
$datdefp = mysqli_query($con, "SELECT * FROM def_permission");
$datadefp = mysqli_fetch_assoc($datdefp);
if (isset($_POST['send_msg'])) {
$title = post('title');
$footer = post('footer');
$nd = post('nd');
$send_msg = post('send_msg');
$datanumber = post('datanumber');
$auto_reply = post('auto_reply');
$autoreply_button = post('autoreply_button');
$send_bulk = post('send_bulk');
$def_msg = post('def_msg');
$rest_api = post('rest_api');
$desc = post('desc');
$register = post('register');
$send_button = post('send_button');
$limit_device = post('limit_device');
$rid_key = post('rid_key');
$no_wa = post('no_wa');
$msg_verification = post('msg_verification');
$change_template = post('change_template');
$update = mysqli_query($con, "
UPDATE web_setting SET title = '$title',
footer = '$footer',
nd_default = '$nd',
send_msg = '$send_msg',
datanumber = '$datanumber',
auto_reply = '$auto_reply',
autoreply_button = '$autoreply_button',
send_bulk = '$send_bulk',
def_msg = '$def_msg',
rest_api = '$rest_api',
description = '$desc',
register = '$register',
send_button = '$send_button',
limit_device = '$limit_device',
rid_key = '$rid_key',
no_wa = '$no_wa',
msg_verification = '$msg_verification',
themes = '$change_template'");

$can_sendmsg = post('can_sendmsg');
$can_sendbutton = post('can_sendbutton');
$can_datanumber = post('can_datanumber');
$can_def_msg = post('can_def_msg');
$can_restapi = post('can_restapi');
$trialofday = post('trialofday');
$updatepermision = mysqli_query($con, "
UPDATE def_permission SET send_msg = '$can_sendmsg',
send_button = '$can_sendbutton',
datanumber = '$can_datanumber',
def_msg = '$can_def_msg',
rest_api = '$can_restapi',
day_x = '$trialofday'");
echo '<p style="color: black;">updated</p>';
redirect('settingweb.php');
}
?>
<!-- Body -->       
    <div class="page-title">        
            <div class="row">       
                <div class="col-12 col-md-6 order-md-1 order-last">     
                    <h3><?php echo rid_lang('setting');?> </h3>      
                    <p class="text-subtitle text-muted"><?php echo $rid['web_setting']['title'];?> - Admin Panel </p>      
                </div>      
                <div class="col-12 col-md-6 order-md-2 order-first">        
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">        
                    </nav>      
                </div>      
            </div>      
    </div>      

<section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo rid_lang('setting');?> Website</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" action="">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">Title</label>
                                            <input type="text" class="form-control"
                                                name="title" value="<?php echo $rid['web_setting']['title'];?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Description</label>
                                        <textarea class="form-control" name="desc" rows="3"><?php echo $rid['web_setting']['description'];?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Message OTP verification</label>
                                        <textarea class="form-control" name="msg_verification" rows="3"><?php echo $rid['web_setting']['msg_verification'];?></textarea>
                                        <small>*[OTP] < This is the OTP code that will be sent to the user. Don't you delete it or replace it!</small>
                                    </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="city-column">Footer</label>
                                            <input type="text" class="form-control" 
                                                name="footer" value="<?php echo $rid['web_setting']['footer'];?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="city-column">Bot Whatsapp Number (for send notif to user)</label>
                                            <input type="text" class="form-control" 
                                                name="no_wa" value="<?php echo $rid['web_setting']['no_wa'];?>">
                                        </div>
                                    </div>
                    <fieldset class="form-group">
                        <label for="disabledInput">Change template</label>
                        <select class="form-select" name="change_template">
                            <option value="<?php echo $rid['web_setting']['themes'];?>" selected><?php echo $rid['web_setting']['themes'];?> (current)</option>
                            <option value="sb_admin">SB Admin 2</option>
                            <option value="azures_mobile_version">Azures</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Mode default | night/day</label>
                        <select class="form-select" name="nd">
                            <option value="<?php echo $rid['web_setting']['nd_default'];?>" selected><?php if ($rid['web_setting']['nd_default'] == '1') { echo 'Night (current)'; } else { echo 'Day (current)'; }?></option>
                            <option value="1">As Mode night</option>
                            <option value="2">As Mode day</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">page <?php echo rid_lang('test_send');?></label>
                        <select class="form-select" name="send_msg">
                            <option value="<?php echo $rid['web_setting']['send_msg'];?>" selected><?php if ($rid['web_setting']['send_msg'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Page <?php echo rid_lang('dat_number');?></label>
                        <select class="form-select" name="datanumber">
                            <option value="<?php echo $rid['web_setting']['datanumber'];?>" selected><?php if ($rid['web_setting']['datanumber'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Page <?php echo rid_lang('auto_reply');?></label>
                        <select class="form-select" name="auto_reply">
                            <option value="<?php echo $rid['web_setting']['auto_reply'];?>" selected><?php if ($rid['web_setting']['auto_reply'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Page <?php echo rid_lang('auto_reply_btn');?></label>
                        <select class="form-select" name="autoreply_button">
                            <option value="<?php echo $rid['web_setting']['autoreply_button'];?>" selected><?php if ($rid['web_setting']['autoreply_button'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Page <?php echo rid_lang('send_bulk_schedule');?></label>
                        <select class="form-select" name="send_bulk">
                            <option value="<?php echo $rid['web_setting']['send_bulk'];?>" selected><?php if ($rid['web_setting']['send_bulk'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Page <?php echo rid_lang('def_message');?></label>
                        <select class="form-select" name="def_msg">
                            <option value="<?php echo $rid['web_setting']['def_msg'];?>" selected><?php if ($rid['web_setting']['def_msg'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Page REST API and feature all api</label>
                        <select class="form-select" name="rest_api">
                            <option value="<?php echo $rid['web_setting']['rest_api'];?>" selected><?php if ($rid['web_setting']['rest_api'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput"><?php echo rid_lang('register');?></label>
                        <select class="form-select" name="register">
                            <option value="<?php echo $rid['web_setting']['register'];?>" selected><?php if ($rid['web_setting']['register'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Page <?php echo rid_lang('button_message');?></label>
                        <select class="form-select" name="send_button">
                            <option value="<?php echo $rid['web_setting']['send_button'];?>" selected><?php if ($rid['web_setting']['send_button'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="first-name-column">Rid Key</label>
                                <input type="text" class="form-control" name="rid_key" value="Enter here your key">
                        </div>
                        <small>*Need to update every day.</small>
                    </div>
                    
                    <div class="card-header">
                        <h4 class="card-title">Default Permission (for new user register)</h4>
                    </div>
                    <fieldset class="form-group">
                        <label for="disabledInput">Can user send message?</label>
                        <select class="form-select" name="can_sendmsg">
                            <option value="<?php echo $datadefp['send_msg'];?>" selected><?php if ($datadefp['send_msg'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Can user send button?</label>
                        <select class="form-select" name="can_sendbutton">
                            <option value="<?php echo $datadefp['send_button'];?>" selected><?php if ($datadefp['send_button'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Can user add data number?</label>
                        <select class="form-select" name="can_datanumber">
                            <option value="<?php echo $datadefp['datanumber'];?>" selected><?php if ($datadefp['datanumber'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Can user add default message?</label>
                        <select class="form-select" name="can_def_msg">
                            <option value="<?php echo $datadefp['def_msg'];?>" selected><?php if ($datadefp['def_msg'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset> 
                    <fieldset class="form-group">
                        <label for="disabledInput">Can user use REST API?</label>
                        <select class="form-select" name="can_restapi">
                            <option value="<?php echo $datadefp['rest_api'];?>" selected><?php if ($datadefp['rest_api'] == '1') { echo 'Active (current)'; } else { echo 'Off (current)'; }?></option>
                            <option value="1">As Active</option>
                            <option value="2">As Off</option>
                            </select>
                    </fieldset>
                    
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">Limit Device</label>
                                            <input type="text" class="form-control"
                                                name="limit_device" value="<?php echo $rid['web_setting']['limit_device'];?>">
                                        </div>
                                        <small>*Set to unlimited for unlimted</small>
                                    </div>
                                    
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">Trial of day</label>
                                            <input type="number" class="form-control"
                                                name="trialofday" value="<?php echo $datadefp['day_x'];?>">
                                        </div>
                                        <small>*Count in days, for example a user who just signed up is given a 7 day trial, then enter 7 in the input.</small>
                                    </div>
                                    
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1"><?php echo rid_lang('save');?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include("template/footer.php") ?>
