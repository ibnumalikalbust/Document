<?php include("template/header.php")?>

<?php
$id = get('id');
if (empty($id)) {
    redirect('index.php');
} else {
    $cek = mysqli_query($con, "SELECT * FROM autoreply_button WHERE id = '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $data = mysqli_fetch_assoc($cek);
        $user = $data['username'];
    } else {
        redirect('index.php');
    }
}

if (isset($_POST['keyword'])) {
    $image = post('image');
    $content = post('content');
    $keyword = post('keyword');
    if (!empty($content) && !empty($footer)) {
        $update = mysqli_query($con, "UPDATE autoreply_button SET keyword = '$keyword', response = '$response' WHERE id = '$id'");
        redirect('editautoreply_button.php?id='.$id);
    }
}

if (isset($_GET['delete'])) {
    $make_by = get('delete');
    $delete = mysqli_query($con, "DELETE FROM autoreply_button WHERE username = '$make_by'");
    redirect('data_autoreply_button.php');
}
?>
<!-- Body -->       
    <div class="page-title">        
            <div class="row">       
                <div class="col-12 col-md-6 order-md-1 order-last">     
                    <h3>DETAIL AUTO REPLY BUTTON</h3>      
                    <p class="text-subtitle text-muted">WAY - Admin Panel </p>      
                </div>      
                <div class="col-12 col-md-6 order-md-2 order-first">        
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">        
                    </nav>      
                </div>      
            </div>      
    </div>      
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit auto reply button</h4>
            </div>
            
            <form method="POST">
            <div class="card-body">
                <label class="card-title"><b>Auto reply button information</b></label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="disabledInput">ID</label>
                            <input type="number" class="form-control" id="readonlyInput" readonly="readonly" value="<?php echo $data['id'];?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="disabledInput">image</label>
                            <input type="text" class="form-control" name="image" value="<?php echo $data['image'];?>">
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">Content / <?php echo rid_lang('message');?></label>
                            <textarea name="content" id="content" class="form-control" cols="30" rows="10" style="height: 100px;"><?php echo $data['content'];?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">Footer</label>
                            <input type="text" class="form-control" name="footer" value="<?php echo $data['footer'];?>">
                        </div>
                        <div class="form-group">
                            <label for="disabledInput"><?php echo rid_lang('number');?></label>
                            <input type="number" class="form-control" name="make_by" value="<?php echo $data['make_by'];?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">Keyword</label>
                            <input type="text" class="form-control" name="keyword" value="<?php echo $data['keyword'];?>">
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">text button</label>
                            <input type="text" class="form-control" name="text_button" value="<?php echo $data['text_button'];?>">
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">Keyword auto reply</label>
                            <input type="text" class="form-control" name="keyword_auto_reply" value="<?php echo $data['keyword_auto_reply'];?>">
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">Account</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $data['username'];?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">External Link</label>
                            <input type="text" class="form-control" name="external_link" value="<?php echo $data['external_link'];?>">
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">External Link Name</label>
                            <input type="text" class="form-control" name="external_link_name" value="<?php echo $data['external_link_name'];?>">
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">External Telp</label>
                            <input type="text" class="form-control" name="external_telp" value="<?php echo $data['external_telp'];?>">
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">External Telp Name</label>
                            <input type="text" class="form-control" name="external_telp_name" value="<?php echo $data['external_telp_name'];?>">
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">Keyword auto reply two</label>
                            <input type="text" class="form-control" name="keyword_auto_replytwo" value="<?php echo $data['keyword_auto_replytwo'];?>">
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">Text button two</label>
                            <input type="text" class="form-control" name="text_button_two" value="<?php echo $data['text_button_two'];?>">
                        </div>
                    </div>
                </div>
            </div>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-primary"><i class="iconly-boldEdit-Square"></i> Update</button>
                </div>
                </form>
                <br>
                <br>
                <a href="?id=<?php echo $data['id'];?>&delete=<?php echo $user;?>" class="btn btn-warning" name="delete"><i class="iconly-boldDelete"></i> Delete</a>
        </div>
        
                            
        </div>
    </section>


<?php include("template/footer.php")?> 