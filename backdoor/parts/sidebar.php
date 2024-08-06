<<<<<<< HEAD
<?php 
// include("check-login.php");


$query1 = "SELECT * FROM contact WHERE seen = '0'";
$data1 = mysqli_query($conn, $query1);
if ($data1) {
    $message_count = mysqli_num_rows($data1);
} else {
    $message_count = 0;
}

$query1 = "SELECT * FROM images WHERE name = ''";
$data1 = mysqli_query($conn, $query1);
if ($data1) {
    $unknown_images_count = mysqli_num_rows($data1);
} else {
    $unknown_images_count = 0; 
}

$query1 = "SELECT * FROM recommendation WHERE tier_items = ''";
$data1 = mysqli_query($conn, $query1);
if ($data1) {
    $empty_recommendation = mysqli_num_rows($data1);
} else {
    $empty_recommendation = 0; 
}
?>





<section class="d-sidebar">
    <ul>
        <a href='http://localhost/tierchart/'><li <?php if($type=="home"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="iconoir:home-alt"></iconify-icon> Home</li></a>

        <a href='http://localhost/tierchart/tier-lists.php'><li <?php if($type=="tier lists"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="grommet-icons:list"></iconify-icon> Tier lists</li></a>

        <a href='http://localhost/tierchart/users.php'><li <?php if($type=="users"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="solar:users-group-rounded-line-duotone"></iconify-icon> Users</li></a>

        <hr class="grey">

        <a target="_blank" href='http://localhost/tierchart/add-images.php'><li <?php if($type=="add images"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="mage:image-upload"></iconify-icon> Add images</li></a>

        <a href='http://localhost/tierchart/images.php'><li <?php if($type=="all images"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="ion:images-outline"></iconify-icon> All images</li></a>

        <a href='http://localhost/tierchart/images.php?search=unknown'><li <?php if($type=="unknown images"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="fluent:image-edit-24-regular"></iconify-icon> Unknown images<div class="count <?php if($unknown_images_count<=0){echo "display-none";}; ?>"><?php echo $unknown_images_count; ?></div></li></a>

        <hr class="grey">
        
        <a href='http://localhost/tierchart/add-recommendations.php'><li <?php if($type=="add recommendation"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="fluent:shield-add-24-regular"></iconify-icon> Add Recomm</li></a>
        
        <a href='http://localhost/tierchart/recommendations.php'><li <?php if($type=="recommendation"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="codicon:workspace-trusted"></iconify-icon> Recommendation</li></a>
        
        <a href='http://localhost/tierchart/recommendations.php?search=unknown'><li <?php if($type=="unknown recommendations"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="octicon:shield-24"></iconify-icon> Unknown reco<div class="count <?php if($empty_recommendation<=0){echo "display-none";}; ?>"><?php echo $empty_recommendation; ?></div></li></a>

        <hr class="grey">

        <a href='http://localhost/tierchart/messages.php'><li  <?php if($type=="messages"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="hugeicons:message-01"></iconify-icon> Messages<div class="count <?php if($message_count<=0){echo "display-none";}; ?>"><?php echo $message_count; ?></div></li></a>
    </ul>

</section>


=======
<?php 
// include("check-login.php");


$query1 = "SELECT * FROM contact WHERE seen = '0'";
$data1 = mysqli_query($conn, $query1);
if ($data1) {
    $message_count = mysqli_num_rows($data1);
} else {
    $message_count = 0;
}

$query1 = "SELECT * FROM images WHERE name = ''";
$data1 = mysqli_query($conn, $query1);
if ($data1) {
    $unknown_images_count = mysqli_num_rows($data1);
} else {
    $unknown_images_count = 0; 
}

$query1 = "SELECT * FROM recommendation WHERE tier_items = ''";
$data1 = mysqli_query($conn, $query1);
if ($data1) {
    $empty_recommendation = mysqli_num_rows($data1);
} else {
    $empty_recommendation = 0; 
}
?>





<section class="d-sidebar">
    <ul>
        <a href='http://localhost/tierchart/'><li <?php if($type=="home"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="iconoir:home-alt"></iconify-icon> Home</li></a>

        <a href='http://localhost/tierchart/tier-lists.php'><li <?php if($type=="tier lists"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="grommet-icons:list"></iconify-icon> Tier lists</li></a>

        <a href='http://localhost/tierchart/users.php'><li <?php if($type=="users"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="solar:users-group-rounded-line-duotone"></iconify-icon> Users</li></a>

        <hr class="grey">

        <a target="_blank" href='http://localhost/tierchart/add-images.php'><li <?php if($type=="add images"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="mage:image-upload"></iconify-icon> Add images</li></a>

        <a href='http://localhost/tierchart/images.php'><li <?php if($type=="all images"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="ion:images-outline"></iconify-icon> All images</li></a>

        <a href='http://localhost/tierchart/images.php?search=unknown'><li <?php if($type=="unknown images"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="fluent:image-edit-24-regular"></iconify-icon> Unknown images<div class="count <?php if($unknown_images_count<=0){echo "display-none";}; ?>"><?php echo $unknown_images_count; ?></div></li></a>

        <hr class="grey">
        
        <a href='http://localhost/tierchart/add-recommendations.php'><li <?php if($type=="add recommendation"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="fluent:shield-add-24-regular"></iconify-icon> Add Recomm</li></a>
        
        <a href='http://localhost/tierchart/recommendations.php'><li <?php if($type=="recommendation"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="codicon:workspace-trusted"></iconify-icon> Recommendation</li></a>
        
        <a href='http://localhost/tierchart/recommendations.php?search=unknown'><li <?php if($type=="unknown recommendations"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="octicon:shield-24"></iconify-icon> Unknown reco<div class="count <?php if($empty_recommendation<=0){echo "display-none";}; ?>"><?php echo $empty_recommendation; ?></div></li></a>

        <hr class="grey">

        <a href='http://localhost/tierchart/messages.php'><li  <?php if($type=="messages"){echo"class='d-active-sidebar'";} ?>><iconify-icon icon="hugeicons:message-01"></iconify-icon> Messages<div class="count <?php if($message_count<=0){echo "display-none";}; ?>"><?php echo $message_count; ?></div></li></a>
    </ul>

</section>


>>>>>>> 6f14c57 (Initial commit)
<script></script>