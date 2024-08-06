<?php
$title = "Update tier list";
$type = "update tier list";

include("header.php");
include("function.php");

$query = "SELECT * from tierlist where slug='$_GET[slug]'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<main>
    <div class="container">
        <div class="left-container">
            <?php include("parts/sidebar.php") ?>
        </div>

        <div class="right-container">
            <form id="myForm" method="post" enctype="multipart/form-data">

                <div class="left-side">
                    <label for="number_of_rows">Number of rows</label>
                    <input type="num" id="number_of_rows" name="number_of_rows" placeholder="5" value="<?php echo $row['total_rows']; ?>">

                    <label for="row_titles">Row titles</label>
                    <input type="text" id="row_titles" name="row_titles" placeholder="S,A,B,C,D" value="<?php echo $row['row_titles']; ?>">

                    <label for="row_titles">Tier list item text (optional)</label>
                    <input type="text" id="list_text" name="list_text" placeholder="Shelly,Colt,Brock..." value="<?php echo $row['list_text']; ?>">

                    <label for="images">Upload images (square & .webp)</label>
                    <input type="file" id="images" name="images[]" accept="image/*" multiple>


                    <div class="uploaded-images">
                        <?php
                        if($row['image_links']){
                            $images = explode(",",$row['image_links']);

                            foreach($images as $image){
                                echo"<img class='uploaded-image' src='$image'>";
                            }
                        }
                        ?>
                    </div>
                </div>


                <div class="right-side">
                    <label for="title">Title of the post</label>
                    <input type="text" id="title" name="title" placeholder="Brawl stars troops tier list" required value="<?php echo $row['title']; ?>">

                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" placeholder="brawl-stars-troops-tier-list" required value="<?php echo $row['slug']; ?>">

                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" placeholder="games,entertainment" value="<?php echo $row['category']; ?>">

                    <label for="tags">Tags</label>
                    <input type="text" id="tags" name="tags" placeholder="Brawl stars,supercell" value="<?php echo $row['tags']; ?>">

                    <label for="keywords">Keywords of the post</label>
                    <input type="text" id="keywords" name="keywords" placeholder="keyword1, keyword2, keyword3" required value="<?php echo $row['keywords']; ?>">

                    <label for="description">Description of the post</label>
                    <textarea id="description" name="description" style="height: 90px;" placeholder="Post description here..." required><?php echo $row['description']; ?></textarea>

                    <div class="btns">
                        <button type="submit" class="save-btn" name="publish">Update</button>
                    </div>
                </div>


<?php
if (isset($_POST['publish'])) {
    if (!isset($conn)) {
        die("Database connection not established.");
    }

    // Escape all input variables to prevent SQL injection
    $total_rows = $conn->real_escape_string($_POST['number_of_rows'] ?? 5);
    $row_titles = $conn->real_escape_string($_POST['row_titles'] ?? "S,A,B,C,D");
    $list_text = $conn->real_escape_string($_POST['list_text']);
    $title = $conn->real_escape_string($_POST['title']);
    $keywords = $conn->real_escape_string($_POST['keywords']);
    $description = $conn->real_escape_string($_POST['description']);
    $author = "admin";
    $category = $conn->real_escape_string($_POST['category']);
    $tags = $conn->real_escape_string($_POST['tags']);
    $slug = $conn->real_escape_string($_POST['slug']);

    $fileArray = $_FILES['images'];
    $uploadDirectory = 'uploads/';

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $myFilename = $slug;
    $image_links = "";

    if($row['image_links']){
        $existedImages = count(explode(",",$row['image_links']));
        $existedImageLinks = $row['image_links'].",";
    }else{
        $existedImages = 0;
        $existedImageLinks = "";
    }

    for ($i = 0; $i < count($fileArray['name']); $i++) {
        $fileName = basename($fileArray['name'][$i]);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = $myFilename . "-" . ($existedImages + $i + 1) . "." . $fileExtension;
        $targetFilePath = $uploadDirectory . $newFileName;

        if($image_links != ""){
            $image_links = $image_links . "," . $targetFilePath;
        } else {
            $image_links =  $targetFilePath;
        }

        $validExtensions = array("jpg", "jpeg", "png", "gif", "webp");
        if (in_array(strtolower($fileExtension), $validExtensions)) {
            if (move_uploaded_file($fileArray['tmp_name'][$i], $targetFilePath)) {
                echo "The file $newFileName has been uploaded successfully.<br>";
            } else {
                echo "Error uploading file $newFileName.<br>";
            }
        } else {
            echo "$fileName is not a valid image file.<br>";
        }
    }

    $image_links = $existedImageLinks . $image_links;
    $query = "UPDATE `$dbname`.`tierlist` 
              SET `total_rows` = '$total_rows', 
                  `row_titles` = '$row_titles', 
                  `list_text` = '$list_text', 
                  `title` = '$title', 
                  `keywords` = '$keywords', 
                  `description` = '$description', 
                  `author` = '$author', 
                  `image_links` = '$image_links', 
                  `category` = '$category', 
                  `tags` = '$tags' 
              WHERE `slug` = '$slug'";  // Note the single quotes around $slug

    if ($conn->query($query) === TRUE) {
        echo "Record updated successfully. Record updated successfully for $slug";
        echo "<script>window.location.href=window.location.href;</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>





</form>
        </div>
    </div>
</main> 