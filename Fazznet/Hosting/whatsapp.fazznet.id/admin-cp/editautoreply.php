<?php include("template/header.php")?>

<?php
$id = get('id');
if (empty($id)) {
    redirect('index.php');
} else {
    $cek = mysqli_query($con, "SELECT * FROM auto_reply WHERE id = '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $data = mysqli_fetch_assoc($cek);
        $user = $data['make_by'];
    } else {
        redirect('index.php');
    }
}

if (isset($_POST['keyword'])) {
    $keyword = post('keyword');
    $response = post('response');
    if (!empty($keyword) && !empty($response)) {
        $update = mysqli_query($con, "UPDATE auto_reply SET keyword = '$keyword', response = '$response' WHERE id = '$id'");
        redirect('editautoreply.php?id='.$id);
    }
}

if (isset($_GET['delete'])) {
    $make_by = get('delete');
    $delete = mysqli_query($con, "DELETE FROM auto_reply WHERE make_by = '$make_by'");
    redirect('data_autoreply.php');
}
?>
<!-- Body -->       
    <div class="page-title">        
            <div class="row">       
                <div class="col-12 col-md-6 order-md-1 order-last">     
                    <h3>DETAIL AUTO REPLY</h3>      
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
                <h4 class="card-title">Edit auto reply</h4>
            </div>
            
            <form method="POST">
            <div class="card-body">
                <label class="card-title"><b>Auto reply information</b></label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="disabledInput">ID</label>
                            <input type="number" class="form-control" id="readonlyInput" readonly="readonly" value="<?php echo $data['id'];?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="disabledInput">keyword</label>
                            <input type="text" class="form-control" name="keyword" value="<?php echo $data['keyword'];?>">
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">Response</label>
                            <textarea name="response" id="response" class="form-control" cols="30" rows="10" style="height: 100px;"><?php echo $data['response'];?></textarea>
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