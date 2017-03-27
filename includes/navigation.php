<!-- top navbar-->
<?php
$sql="select * from categories where parent=0";
$pquery=$db->Query($sql);
?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <a href="index.php " class="navbar-brand">Al-BilalChickenPoint</a>
        <ul class="nav navbar-nav">
            <?php while($parent=mysqli_fetch_assoc($pquery)): ?>
            <?php $parent_id=$parent['id']; ?>
                <?php
                    $sql2="select *from categories where parent='$parent_id'";
                    $cquery=$db->Query($sql2);
                ?>
                <!--menu Item-->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category'];  ?><span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <?php while($child=mysqli_fetch_assoc($cquery)): ?>
                    <li><a href="#"><?php echo $child['category']; ?></a></li>
                    <?php endwhile; ?>
                </ul>
            </li>
            <?php endwhile;?>
        </ul>
    </div>
</nav>