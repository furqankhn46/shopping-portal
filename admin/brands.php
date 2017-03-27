<?php
require_once '../core/init.php';
include  'include/head.php';
include 'include/navigation.php';
//get brads from database
$sql="SELECT *FROM brand ORDER BY brand";
$result=$db->query($sql);
?>
<h2 class="text-center">Brands</h2>
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
    <?php while($brand=mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><a href="brands.php?edit=1" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a> </td>
            <td><?=$brand['brand'];?></td>
            <td><a href="brands.php?delete=1" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a> </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php include'include/footer.php';?>
