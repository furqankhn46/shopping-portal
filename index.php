<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headertfull.php';
include'includes/leftbar.php';
$sel="SELECT * FROM product where featured=1";
$featured=$db->query($sel);
?>
    <!--    main content-->


    <div class="col-md-8">
        <div class="row">
            <h2 class="text-center">Feature Production</h2>
            <?php while($product =mysqli_fetch_assoc($featured)): ?>
                <div class="col-md-3">
                    <h4><?php print $product['title'];?></h4>
                    <img src="<?php print $product['image'];?>" alt="levis jeans" class="img-thumb"/>
                    <p class="list-price text-danger">List Price: <s>$<?php print $product['list_price'];?></s></p>
                    <p class="price"> Our Price:$<?php print $product['price'];?></p>
                    <button type="button" class="btn btn=sm btn-success" onclick="detailsmodal(<?= $product['id'];?>)">Details</button>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php
include 'includes/rightbar.php';
include 'includes/footer.php';
?>