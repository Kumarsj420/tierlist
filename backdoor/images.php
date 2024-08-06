<?php
$title = "All images";
$type = "all images";

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

include("header.php");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if($_GET['search']=="unknown"){
    $title = "Unknown images";
    $type = "unknown images";
}
?>

<main>
    <div class="container">
        <div class="left-container">
            <?php include("parts/sidebar.php") ?>
        </div>

        <div class="right-container">
            <h3>All images</h3>
            <div class="all-nicknames">
                <div class='popup-trigger name-card card-name-title'>
                    <div class='name name-id'>ID</div>
                    <div class='name name-profile'>Image</div>
                    <div class='name name-name'>Name</div>
                    <div class='name name-category'>Category</div>
                    <div class='name name-tags'>Child category</div>
                    <div class='name name-path'>Path</div>
                </div>

                <?php
                if ($_GET['search']=="unknown"){
                    $count_query = "SELECT count(*) as allcount FROM images WHERE name=''";

                }else  if (isset($_GET['search'])){
                    $count_query = "SELECT count(*) as allcount FROM images WHERE name LIKE '%$search%' Or category LIKE '%$search%' OR tags LIKE '%$search%' OR child_category LIKE '%$search%'";

                }else {
                    $count_query = "SELECT count(*) as allcount FROM images";
                }

                $count_result = mysqli_query($conn, $count_query);
                if ($count_result) {
                    $count_fetch = mysqli_fetch_assoc($count_result);
                    $postCount = $count_fetch['allcount'];               
                    $limit = 10; // Number of rows per page
                    $pno = isset($_GET['pno']) ? (int)$_GET['pno'] : 1; // Current page number
                    $start = ($pno - 1) * $limit; // Start index for the SQL query
                
                    $totalPages = ceil($postCount / $limit);
                    $totalPages = ceil($postCount / $limit);
                    $total_page = $totalPages;
                
                    if ($_GET['search']=="unknown"){
                        $query = "SELECT * FROM images WHERE name='' ORDER BY id DESC LIMIT $start, $limit";
                    }else  if (isset($_GET['search'])) {
                        $query = "SELECT * FROM images WHERE name LIKE '%$search%' Or category LIKE '%$search%' OR tags LIKE '%$search%' OR child_category LIKE '%$search%' ORDER BY id DESC LIMIT $start, $limit";
                    } else {
                        $query = "SELECT * FROM images ORDER BY id DESC LIMIT $start, $limit";
                    }
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $filePath = basename($row['path']);

                            echo "
                            <div class='popup-trigger name-card' data-id='{$row['id']}' data-name='{$row['name']}' data-category='{$row['category']}' data-tags='{$row['tags']}' data-path='{$row['path']}' data-child_category='{$row['child_category']}'>
                                <div class='name name-id'>{$row['id']}.</div>
                                <div class='name name-profile'><img class='profile-pic' src='{$row['path']}'></div>
                                <div class='name name-name'>{$row['name']}</div>
                                <div class='name name-category'>{$row['category']}</div>
                                <div class='name name-tags'>{$row['child_category']}</div>
                                <div class='name name-path'>{$filePath}</div>

                            </div>
                            ";
                            $sno++;
                        }
                    } else {
                        echo "Error executing query: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error executing count query: " . mysqli_error($conn);
                }
                ?>
            </div>
            <?php include("pegination.php"); ?>
        </div>
    </div>

    <div class="popup">
        <div class="popup-body">
            <form method="post" enctype="multipart/form-data">
                <label>ID</label>
                <input class="right-inputs" type="text" name="id" id="id" placeholder="1">

                <label>Name</label>
                <input class="right-inputs" type="text" name="name" id="name" placeholder="pubg">

                <label>Category</label>
                <input class="right-inputs" type="text" name="category" id="category" placeholder="">

                <label>Child category</label>
                <input class="right-inputs" type="text" name="child_category" id="child_category" placeholder="12345678">
                
                <label>Path</label>
                <input class="right-inputs" type="text" name="path" id="path" placeholder="12345678">

                <span class="close">X</span>
        </div>
        <div class="popup-footer">
            <button name='update' class='popup-btn update'>update</button>
            <button name='delete' class='popup-btn delete'>delete</button>
            </form>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        // Function to show the popup
        function popup() {
            $('.popup').show();
        }

        // Function to close the popup
        function closePopup() {
            $('.popup').hide();
        }

        // Hide the popup when clicking outside of it or on the close button
        $(document).click(function(event) {
            if (!$(event.target).closest('.popup-trigger, .popup').length) {
                $('.popup').hide();
            }
        });

        // Trigger popup on click
        $('.popup-trigger').click(function() {
            $('#id').val($(this).data('id'));
            $('#name').val($(this).data('name'));
            $('#category').val($(this).data('category'));
            $('#child_category').val($(this).data('child_category'));
            $('#path').val($(this).data('path'));
            popup();
        });

        // Close popup on close button click
        $('.close').click(function() {
            closePopup();
        });
    });
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $itemId = $_POST['id'];
        $sql = "DELETE FROM images WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $itemId);
        if ($stmt->execute() === TRUE) {

            $filePath = $_POST['path']; 

            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    echo "The file $filePath has been deleted successfully.";
                } else {
                    echo "There was an error deleting the file $filePath.";
                }
            } else {
                echo "The file $filePath does not exist.";
            }

            echo "<script>window.location.href=window.location.href;</script>";
        } else {
            echo "Error deleting item: " . $conn->error;
        }
        $stmt->close();
    }

    if (isset($_POST['update'])) {
        $itemId = $_POST['id'];
        $name = $_POST['name'];
        $category = $_POST['category'];
        $child_category = $_POST['child_category'];
    
        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE images SET name = ?, category = ?, child_category = ? WHERE id = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
    
        // Bind the parameters
        $stmt->bind_param("sssi", $name, $category, $child_category, $itemId);
        if ($stmt->execute()) {
            echo "<script>window.location.href=window.location.href;</script>";
        } else {
            echo "Error updating item: " . htmlspecialchars($stmt->error);
        }
    
        // Close the statement
        $stmt->close();
    }
}
?>
