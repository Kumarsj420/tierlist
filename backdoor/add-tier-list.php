<?php
$title = "Add tier list";
$type = "add tier list";

include("header.php");
include("function.php");
?>

<main>
    <div class="container">
        <div class="left-container">
            <?php include("parts/sidebar.php") ?>
        </div>

        <div class="right-container">
            <form id="myForm" class="sticky-left" method="post" enctype="multipart/form-data">

                <div class="left-side">
                <label for="title">Title of the post <span class="required">*</span></label>
                    <input type="text" id="title" name="title" placeholder="Brawl stars troops tier list" required>

                    <label for="slug">Slug <span class="required">*</span></label>
                    <input type="text" id="slug" name="slug" placeholder="brawl-stars-troops-tier-list" required>

                    <label for="category">Category <span class="required">*</span></label>
                    <input type="text" id="category" name="category" placeholder="clash of clans" required>

                    <label for="category">Child category <span class="required">*</span></label>
                    <input type="text" id="child_category" name="child_category" placeholder="troops,defense" required>

                    <!-- <label for="tags">Tags</label>
                    <input type="text" id="tags" name="tags" placeholder="Brawl stars,supercell">

                    <label for="keywords">Keywords of the post</label>
                    <input type="text" id="keywords" name="keywords" placeholder="keyword1, keyword2, keyword3">

                    <label for="description">Description of the post</label>
                    <textarea id="description" name="description" style="height: 90px;" placeholder="Post description here..."></textarea> -->

                    <hr>


                    <label for="number_of_rows">Number of rows</label>
                    <input type="num" id="number_of_rows" name="number_of_rows" placeholder="5">

                    <label for="row_titles">Row titles</label>
                    <input type="text" id="row_titles" name="row_titles" placeholder="S,A,B,C,D">

                    <!-- <label for="row_titles">Tier list item text (optional)</label>
                    <input type="text" id="list_text" name="list_text" placeholder="Shelly,Colt,Brock...">

                    <label for="image_tags">Image tags <span class="required">*</span></label>
                    <textarea id="image_tags" name="image_tags" style="height: 90px;" placeholder="shelly,colt,brock"></textarea>

                    <label for="images">Upload images (square & .webp)</label>
                    <input type="file" id="images" name="images[]" accept="image/*" multiple> -->

                    <div class="btns">
                        <button type="submit" class="save-btn" name="publish">Publish</button>
                    </div>
                </div>


                <div class="right-side sticky-right">

                    <label for="import_image">Import images</label>
                    <input class="search" name="import_image" placeholder="Search images..." type="text">
                </div>


<?php
if (isset($_POST['publish'])) {
    if (!isset($conn)) {
        die("Database connection not established.");
    }
    $total_rows = ($_POST['number_of_rows'])?($_POST['number_of_rows']):5;
    $row_titles = ($_POST['row_titles'])?($_POST['row_titles']):"S,A,B,C,D";
    $list_text = $_POST['list_text'];
    $title = $_POST['title'];
    $author = "admin";
    $category = $_POST['category'];;
    $child_category = $_POST['child_category'];;
    $slug = $_POST['slug'];


    $countQuery = "SELECT COUNT(*) AS total FROM tierlist WHERE slug = '$slug'";
    $countResult = mysqli_query($conn, $countQuery);
    $countRow = mysqli_fetch_assoc($countResult);
    $totalRows = $countRow['total'];

    if($totalRows>0){
        $newIndex = $totalRows + 1;
        $slug = $slug."-".$newIndex;
        echo "i tried to upload and i just found one row there. I found one row";
    }else{
        echo "No dublictae row found while uploafin inot the tierlist";

    }

    $insertNickname = "INSERT INTO `$dbname`.`tierlist` (`total_rows`, `row_titles`, `list_text`, `title`,  `author`, `image_links`, `slug`, `category`,`child_category`) 
    VALUES ('$total_rows', '$row_titles', '$list_text', '$title', '$author', '$image_links', '$slug', '$category','$child_category')";
    $conn->query($insertNickname);

    $query = "INSERT INTO `$dbname`.`recommendation` (`slug`) 
    VALUES ('$slug')";

    if ($conn->query($query) === TRUE) {
        echo "<script>window.location.href='http://localhost/tierchart/add-images.php?category=$category&child_category=$child_category';</script>";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>

</form>
        </div>
    </div>
</main> 
<script>
document.getElementById("title").addEventListener("keyup", function() {
    var text = document.getElementById("title").value;
    text = text.toLowerCase();
    text = text.replace(/ /g, "-");
    document.getElementById("slug").value = text;
});

</script>