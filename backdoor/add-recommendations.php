<?php
$title = "Add images";
$type = "add images";

include("header.php");
include("function.php");
?>

<main>
    <div class="container">
        <div class="left-container">
            <?php include("parts/sidebar.php") ?>
        </div>

        <div class="right-container">
            <form id="myForm" method="post" enctype="multipart/form-data">

                <div class="left-side">
                    <label for="category">Slug<span class="required">*</span></label>
                    <input type="text" value="<?php echo $_GET['slug']; ?>" id="slug" name="slug" placeholder="clash-of-clans-troops-tier-list" required>

                    <label for="total_rows">Total rows</label>
                    <input type="number" id="total_rows" name="total_rows" placeholder="5">


                    <label for="title">Tier list titles</label>
                    <input type="text" id="title" name="title" placeholder="S,A,B,C,D">

                    <label for="items">Tier list items<span class="required">*</span></label>
                    <textarea name="items" style="height: 150px;" placeholder="valkyrie.png,hogs.png" required></textarea>

                    <div class="btns">
                        <button type="submit" class="save-btn" name="publish">Publish</button>
                    </div>
                </div>


                <div class="right-side">
                </div>


                <?php
if (isset($_POST['publish'])) {
    if (!isset($conn)) {
        die("Database connection not established.");
    }
    $slug = $_POST['slug'];
    $total_rows = $_POST['total_rows'];
    $title = $_POST['title'];
    $items = $_POST['items'];

    if(!$total_rows){
        $total_rows = 5;
    }
    if(!$title){
        $title = "S,A,B,C,D";
    }

    $query = "UPDATE `recommendation` 
    SET `total_rows` = '$total_rows', 
        `tier_names` = '$title', 
        `tier_items` = '$items' 
    WHERE `slug` = '$slug'";

    if ($conn->query($query) === TRUE) {
        echo "Data inserted.<br>";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>




</form>
        </div>
    </div>
</main> 