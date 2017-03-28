<?php
require_once '../core/init.php';
include  'include/head.php';
include 'include/navigation.php';
//get brads from database
$sql="SELECT *FROM brand ORDER BY brand";
$results=$db->query($sql);
$errors=array();
//if add form is submitted
if(isset($_POST['add_submit'])){
    //check if brand is blank
    if($_POST['brand']==''){
        $brand=$_POST['brand'];
        $errors[].='you must enter a brand!';
    }
    print_r($_POST['brand']); die;
    //check if brands exist in database
    $sql="SELECT *FROM brand WHERE brand='$brand'";
    $result=$db->Query($sql);
    $brandi=mysqli_fetch_assoc($result);
    print_r($brandi); die;
    $count=mysqli_num_rows($result);
    echo $count;
    //display error
    if(!empty($errors )){
        echo display_errors($errors);
    }else{
        //add brand to database

    }
}
?>
<h2 class="text-center">Brands</h2><hr>
<!--''brand form-->
<div class="text-center">
    <form class="form-inline" action="brands.php" method="post">
        <div class="form-group">
            <label for="brand">Add A Brand:</label>
            <input type="text" name="brand" id="brand" class="form-control" value="<?=((isset($_POST['brand']))?$_POST['brand']:'');?>">
            <input type="submit" name="add_submit" id="add_submit" value="Add Brand" class="btn btn-success">
        </div>
    </form>
</div><hr>
<div>
    <form class=" form-inline" action="brands.php" method="post">
        <div class="form-group"
    </form>
</div>
<table class="table table-bordered table-striped table-auto">
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
