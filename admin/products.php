<?php
require_once  $_SERVER['DOCUMENT_ROOT'].'/shoppingPortal/core/init.php';
include 'include/head.php';
include 'include/navigation.php';
if(isset($_GET['add'])|| (isset($_GET['edit']))){
$brandQuery=$db->query("SELECT * FROM brand ORDER BY brand");
$parentQuery=$db->query("SELECT *FROM categories WHERE parent=0 ORDER BY category");
$sizesArray=array();
    $title=((isset($_POST['title']) && $_POST['title']!='')?sanitize($_POST['title']):'');
    $brand=((isset($_POST['brand'])&& !empty($_POST['title']))?sanitize($_POST['brand']):'');
    $parent=((isset($_POST['parent'])&& !empty($_POST['parent']))?sanitize($_POST['parent']):'');
    $category=((isset($_POST['child'])&& !empty($_POST['child']))?sanitize($_POST['child']):'');
    $price=((isset($_POST['price']) && $_POST['price']!='')?sanitize($_POST['price']):'');
    $list_price=((isset($_POST['list_price']) && $_POST['list_price']!='')?sanitize($_POST['list_price']):'');
    $description=((isset($_POST['description']) && $_POST['description']!='')?sanitize($_POST['description']):'');
    $sizes=((isset($_POST['sizes']) && $_POST['sizes']!='')?sanitize($_POST['sizes']):'');
    $sizes=trim($sizes,',');
    if(isset($_GET['edit'])){
        $edit_id=(int)$_GET['edit'];
        $productResult=$db->query("SELECT * FROM product WHERE id='$edit_id'");
        $product=mysqli_fetch_assoc($productResult);
        $category=((isset($_POST['child'])&& $_POST['child']!='')?sanitize($_POST['child']):$product['categories']);
        $title=((isset($_POST['title'])&& $_POST['title']!='')? sanitize($_POST['title']): $product['title']);
        $brand=((isset($_POST['brand'])&& $_POST['brand']!='')? sanitize($_POST['brand']): $product['brand']);
        $parentQ=$db->query("SELECT * FROM categories WHERE id='$category'");
        $parentResult=mysqli_fetch_assoc($parentQ);
        $parent=((isset($_POST['parent']) && $_POST['parent']!='')? sanitize($_POST['parent']): $parentResult['parent']);
        $price=((isset($_POST['price'])&& $_POST['price']!='')? sanitize($_POST['price']): $product['price']);
        $list_price=((isset($_POST['list_price'])&& $_POST['list_price']!='')? sanitize($_POST['plist_rice']): $product['list_price']);
        $description=((isset($_POST['description'])&& $_POST['description']!='')? sanitize($_POST['description']): $product['description']);
        $sizes=((isset($_POST['sizes'])&& $_POST['sizes']!='')? sanitize($_POST['sizes']): $product['sizes']);
        $sizes=trim($sizes,',');
    }
    if(!empty($sizes    )){
        $sizeString=sanitize($sizes);
        $sizeString=rtrim($sizeString,',');
        $sizesArray=explode(',',$sizeString);
        $sArray=array();
        $qArray=array();
        foreach($sizesArray as $ss){
            $s=explode(':',$ss);
            $sArray[]=$s[0];
            $qArray[]=$s[1];
        }
    }else{$sizesArray=array();}
    if($_POST){
        $dbpath='';
        $errors=array();

    $required=array('title','brand','price','parent','child','sizes');
    foreach($required as $field){
        if($_POST[$field]==''){
            $errors[]='All Fields with and Astrisk are required.';
        break;
        }
    }

        if(!empty($_FILES)){
            var_dump($_FILES);
             $photo=$_FILES['photo'];
             $name=$photo['name'];
            $nameArray=explode('.',$name);
            $fileName=$nameArray[0];
            $fileExt=$nameArray[1];
            $mime=explode('/',$photo['type']);
            $mimeType=$mime[0];
            $mimeExt=[1];
            $tmpLoc=$photo['tmp_name'];
            $fileSize= $photo['size'];
            $allowed=array('png','jpg','jpeg','gif');
            $uploadName=md5(microtime()).'.'.$fileExt;
            $uploadPath=BASEURL.'/images/products/'.$uploadName;
            $dbpath='shoppingPortal/images/products/'.$uploadName;
            if($mimeType !='image'){
                $errors[]='The file must be an image.';
            }
            if(!in_array($fileExt,$allowed)){
            $errors[]='The photo file extension must be a png,jpg,jpeg or gif';
            }
            if($fileSize>15000000){
                $errors[]='The files size must be under 15mb.';
            }
            if($fileExt != $mimeExt && ($mimeExt=='jpeg' && $fileExt!='jpg')){
            $errors[]='File extensio does not match the file.';
            }
        }
    if(!empty($errors)){
        echo display_errors($errors);
    }else{
        //uploade file and insert into database
        move_uploaded_file($tmpLoc,$uploadPath);
        $insertSql="INSERT INTO product(`title`,`price`,`list_price`,`brand`,`categories`,`sizes`,`image`, `description`)
        VALUES('$title','$price','$list_price','$brand','$categories','$sizes','$dbpath', '$description')";
        $db->query($insertSql);
        header('Location:products.php');
    }
}
    ?>
<h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add A');?> Product</h2>
    <form action="products.php?<?=((isset($_GET['edit']))?'edit'.$edit_id:'Add=1');?>" method="post" enctype="multipart/form-data">
        <div class="form-group col-md-3">
            <label for="title">Title*:</label>
            <input type="text" class="form-control" name="title" id="title" value="<?=$title;?>">
        </div>

        <div class="form-group col-md-3">
            <label for="Brand">Brand*:</label>
            <select class="form-control" id="brand" name="brand">
                <option value="<?=(($brand =='')?'selected':''); ?>">Select Brand</option>
                <?php while($b=mysqli_fetch_assoc($brandQuery)): ?>
                <option value="<?=$b['id'];?>"<?=(($brand ==$b['id'])?'selected':'');?>><?=$b['brand'];?></option>
        <?php endwhile; ?>
            </select>
             </div>
        <div class="form-group col-md-3">
            <label for="Parent">Parent Category*:</label>
            <select class="form-control" id="parent" name="parent">
                <option value=""<?=(($parent =='')?'selected':'')?>>select category</option>
            <?php while($p=mysqli_fetch_assoc($parentQuery)):?>
            <option value="<?=$p['id']?>" <?=(($parent == $p['id']) ? 'selected' : ''); ?>><?=$p['category'];?></option>
            <?php endwhile; ?>
        <option></option>
            </select>
        </div>
        <div class=" form-group col-md-3">
            <label for="child">Child Category*:</label>
            <select id="child" name="child" class="form-control">
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="price">Price*:</label>
            <input type="text" id="price" class="form-control" name="price" value="<?=$price;?>">
        </div>
        <div class="form-group col-md-3">
            <label for="List_price">List Price:</label>
            <input type="text" id="list_price" class="form-control" name="list_price" value="<?=$list_price;?>">
        </div>
        <div class="form-group col-md-3">
            <label">Quantity & Sizes*:</label>
            <button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & sizes</button>
        </div>
        <div class="form-group col-md-3">
            <label for="sizes">Sizes & Qty Preview</label>
            <input type="text" class="form-control" name="sizes" id="sizes" value="<?=$sizes;?>" readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="photo">Product Photo</label>
            <input type="file" class="form-control" id="photo" name="photo">
        </div>
        <div class="form-group col-md-6">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control" rows="6"><?=$description;?></textarea>
        </div>
        <div class="form-group pull-right">
            <a href="products.php" class="btn btn-default">Cancel</a>
        <input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> product" class=" btn btn-success pull-right ">
        </div><div class="clearfix"></div>
    </form>

    <!-- Modal -->
    <div class="modal fade " id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="sizesModalLabel">Sizes & Quantity</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                    <?php for($i=1;$i<=12;$i++):?>
                        <div class="form-group col-md-4">
                            <label for="size<?=$i;?>">Size:</label>
                            <input type="text" name="size<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="qty<?=$i;?>">Quantity:</label>
                            <input type="number" name="qty<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control">
                        </div>
                    <?php endfor; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
                </div>
            </div>
        </div>
    </div>

<?php } else {

    $sql = "SELECT *FROM product WHERE deleted = '0'";
    $presults = $db->query($sql);
    if (isset($_GET['featured'])) {
        $id = (int)$_GET['id'];
        $featured = (int)$_GET['featured'];
        $featuresql = "UPDATE product SET featured='$featured'  WHERE id='$id'";
        $db->query($featuresql);
        header('Location: products.php');
    }
    ?>
    <h2 class="text-center">Products</h2>
    <a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add product</a> <div class="clearfix"></div>
    <hr>
    <table class="table table-bordered table-condensed  table=striped">
        <thead>
        <th></th>
        <th>Product</th>
        <th>Price</th>
        <th>Category</th>
        <th>Feature</th>
        <th>Sold</th>
        </thead>
        <tbody>
        <?php while ($product = mysqli_fetch_assoc($presults)):
            $childID = $product['categories'];
            $catsql = "SELECT *FROM categories WHERE id='$childID'";
            $result = $db->query($catsql);
            $child = mysqli_fetch_assoc($result);
            $parentID = $child['parent'];
            $psql = "SELECT *FROM categories WHERE id='$parentID'";
            $presult = $db->query($psql);
            $parent = mysqli_fetch_assoc($presult);
            $category = $parent['category'] . '~' . $child['category'];
            ?>
            <tr>
                <td>
                    <a href="products.php?edit=<?= $product['id']; ?>" class="btn bt-xs btn-default"><span
                            class="glyphicon glyphicon-pencil"></span></a>
                    <a href="products.php?delete=<?= $product['id']; ?>" class="btn bt-xs btn-default"><span
                            class="glyphicon glyphicon-remove-sign"></span></a>
                </td>
                <td><?= $product['title']; ?></td>
                <td><?= money($product['price']); ?></td>
                <td><?= $category; ?></td>
                <td>
                    <a href="products.php?featured=<?= (($product['featured'] == 0) ? '1' : '0') ?>&id=<?= $product['id']; ?>"
                       class="btn btn-xs btn-default">
                        <span
                            class="glyphicon  glyphicon-<?= (($product['featured'] == 1) ? 'minus' : 'plus') ?>"></span>
                    </a>&nbsp<?= (($product['featured'] == 1) ? 'feature Products' : '') ?></td>
                <td>0</td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <?php
} include 'include/footer.php';?>
<script>
    jQuery('document').ready(function (){
        get_child_option('<?=$category;?>');
        updateSizes();
    });
</script>

