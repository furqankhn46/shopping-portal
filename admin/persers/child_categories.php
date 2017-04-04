<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/shoppingPortal/core/init.php';
$parentID=(int)$_POST['parentID'];
$selected=$_POST['selected'];
$childQuery=$db->query("SELECT * FROM categories WHERE parent= '$parentID' ORDER BY category");
ob_start(); ?>
<option value="">select child</option>
<?php while($child=mysqli_fetch_assoc($childQuery)):?>
<option value="<?=$child['id']?>"<?=(($selected==$child['id']) ? 'selected' : '');?>><?=$child['category']?></option>
    <?PHP endwhile;?>
<?php
echo ob_get_clean();
?>