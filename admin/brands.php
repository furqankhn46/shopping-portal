<?php
require_once '../core/init.php';
if(!is_logged_in()){
    login_error_redirect();
}
include  'include/head.php';
include 'include/navigation.php';
//get brands from database
$sql="SELECT *FROM brand ORDER BY brand";
$results=$db->query($sql);
$errors=array();

//Edit Brand
if(isset($_GET['edit'])&&!empty($_GET['edit'])){
    $edit_id=(int)$_GET['edit'];
    $edit_id=sanitize($edit_id);
    $sql2="SELECT *FROM brand WHERE id='$edit_id'";
    $edit_result=$db->query($sql2);
    $eBrand=mysqli_fetch_assoc($edit_result);

}
//Delete Brand
if(isset($_GET['delete'])&&($_GET['delete'])){
    $delete_id=(int)$_GET['delete'];
    $delet_id=sanitize($delete_id);
    $sql="DELETE FROM brand WHERE id='$delet_id'";
    $db->query($sql);
    header('Location: brands.php');
}


//if add form is submitted
if(isset($_POST['add_submit'])){
    $brand=sanitize($_POST['brand']);
    //check if brand is blank
    if($_POST['brand']==''){
        $errors[].='you must enter a brand!';
    }
    //check if brands exist in database
    $brand=$_POST['brand'];
    $sql="SELECT *FROM brand WHERE brand='$brand'";
    if(isset($_GET['edit'])){
        $sql="SELECT *FROM brand WHERE brand='$brand' AND id!='$edit_id'";

    }
    $result=$db->Query($sql);
    $count=mysqli_num_rows($result);
    if($count>0){
        $errors[].=$brand.' already exist. Please choose another brand name...';
    }
    //display error
    if(!empty($errors )){
        echo display_errors($errors);
    }else{
        //add brand to database
        $sql="INSERT INTO brand (brand) VALUES('$brand')";
        if(isset($_GET['edit'])){
            $ubrand=trim($brand);
            $sql="UPDATE brand SET brand='$ubrand' WHERE id ='$edit_id'";
        }
        $db->Query($sql);
        header('Location:brands.php');
    }
}
?>
<h2 class="text-center">Brands</h2><hr>
<!--''brand form-->
<div class="text-center">
    <form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id: '');?>" method="post">
        <div class="form-group">
            <?php
            $brand_value= '';
            if(isset($_GET['edit'])){
                $brand_value=$eBrand['brand'];
            } else{
                if(isset($_POST['brand'])){
                    $brand_value=sanitize($_POST['brand']);
                }

            }

            ?>
            <label for="brand"><?=((isset($_GET['edit']))?'Edit ':'Add A ')?>Brand:</label>
            <input type="text" name="brand" id="brand" class="form-control" value="<?=$brand_value;?>">
            <?php if(isset($_GET['edit'])):?>
                <a  href="brands.php" class=" btn btn-default">Cancel</a>

            <?php endif; ?>
            <input type="submit" name="add_submit" id="add_submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ')?> Brand" class="btn btn-success">
        </div>
    </form>
</div><hr>
<div>
    <form class=" form-inline" action="brands.php" method="post">
        <div class="form-group"
    </form>
</div>
<table class="table table-bordered table-striped table-auto table-condensed">
    <thead>
    <th></th><th>Brand</th><th></th>
    </thead>
    <tbody>
    <?php while($brand=mysqli_fetch_assoc($results)): ?>
        <tr>
            <td><a href="brands.php?edit=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a> </td>
            <td><?=$brand['brand'];?></td>
            <td><a href="brands.php?delete=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a> </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php include'include/footer.php';?>
