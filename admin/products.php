<?php
require_once  $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
include 'include/head.php';
include 'include/navigation.php';
$sql="SELECT *FROM product WHERE deleted = '0'";
$presults=$db->query($sql);
if(isset($_GET['featured'])){
    $id=(int) $_GET['id'];
    $featured=(int) $_GET['featured'];
    $featuresql="UPDATE product SET featured='$featured'  WHERE id='$id'";
    $db->query($featuresql);
    header('Location: products.php');
}
?>
<h2 class="text-center">Products</h2>
<table class="table table-bordered table-condensed  table=striped">
<thead><th></th><th>Product</th><th>Price</th><th>Category</th><th>Feature</th><th>Sold</th></thead>
<tbody>
    <?php while($product=mysqli_fetch_assoc($presults)):
        $childID=$product['categories'];
        $catsql="SELECT *FROM categories WHERE id='$childID'";
        $result=$db->query($catsql);
        $child=mysqli_fetch_assoc($result);
        $parentID=$child['parent'];
        $psql="SELECT *FROM categories WHERE id='$parentID'";
        $presults1=$db->query($psql);
        $parent=mysqli_fetch_assoc($presults1);
        $category=$parent['category'].'~'.$child['category'];
        ?>
        <tr>
            <td>
                <a href="products.php?edit=<?=$product['id'];?>" class="btn bt-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                <a href="products.php?delete=<?=$product['id'];?>" class="btn bt-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
            </td>
            <td><?=$product['title'];?></td>
            <td><?=money($product['price']);?></td>
            <td><?=$category;?></td>
            <td><a href="products.php?featured=<?=(($product['featured']==0)?'1':'0')?>&id=<?=$product['id'];?>" class="btn btn-xs btn-default">
                    <span  class="glyphicon  glyphicon-<?=(($product['featured']==1)?'minus':'plus')?>"></span>
                </a>&nbsp<?=(($product['featured']==1)?'feature Products':'')?></td>
            <td>0</td>
        </tr>
    <?php endwhile; ?>
</tbody>
</table>
<?php
include 'include/footer.php';
?>
