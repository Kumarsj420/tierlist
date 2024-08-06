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
                    <label for="category">Category<span class="required">*</span></label>
                    <input type="text" id="category" name="category" placeholder="clash of clans" value="<?php echo $_GET['category']; ?>" required>

                    <label for="category">Child category<span class="required">*</span></label>
                    <input type="text" id="child_category" name="child_category" placeholder="troops,dark troops" required value="<?php echo $_GET['child_category']; ?>">


                    <label for="tags">Tags</label>
                    <input type="text" id="tags" name="tags" placeholder="Brawl stars,supercell">

                    <label for="images">Upload images (square & .webp)</label>
                    <input type="file" id="images" name="images[]" accept="image/*" multiple required>


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
    $category = strtolower($_POST['category']);
    $child_category = strtolower($_POST['child_category']);
    $tags = strtolower($_POST['tags']);
    $image_tags = $_POST['image_tags'];


    $fileArray = $_FILES['images'];
    $uploadDirectory = 'uploads/';

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    for ($i = 0; $i < count($fileArray['name']); $i++) {
        // Convert filename to lowercase
        
        $fileName = str_replace(" ","-",strtolower(basename($fileArray['name'][$i])));
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $baseName = pathinfo($fileName, PATHINFO_FILENAME);
        
        // Create target file path
        $targetFilePath = $uploadDirectory . $fileName;
        $fileIndex = 1;

        // Check for duplicate file names and rename if necessary
        while (file_exists($targetFilePath)) {
            $targetFilePath = $uploadDirectory . $baseName . '-' . $fileIndex . '.' . $fileExtension;
            $fileIndex++;
        }

        $validExtensions = array("jpg", "jpeg", "png", "gif", "webp");
        if (in_array(strtolower($fileExtension), $validExtensions)) {
            if (move_uploaded_file($fileArray['tmp_name'][$i], $targetFilePath)) {
                echo "The file $fileName has been uploaded successfully as $targetFilePath.<br>";

                // Insert image data into the database
                $insertQuery = "INSERT INTO `images` (`category`, `tags`, `path`, `child_category`) 
                VALUES ('$category', '$tags', '$targetFilePath', '$child_category')";
                if ($conn->query($insertQuery) === TRUE) {
                    echo "New record created successfully for $targetFilePath.<br>";
                } else {
                    echo "Error: " . $insertQuery . "<br>" . $conn->error;
                }
            } else {
                echo "Error uploading file $fileName.<br>";
            }
        } else {
            echo "$fileName is not a valid image file.<br>";
        }
    }
}
?>




</form>
        </div>
    </div>
</main> 