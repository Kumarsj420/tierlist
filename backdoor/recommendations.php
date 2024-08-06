<<<<<<< HEAD
<?php
$title = "All images";
$type = "recommendation";

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    if($_GET['search']=="unknown"){
        $title = "Unknown recommendations";
        $type = "unknown recommendations";
    }
}

include("header.php");

?>

<main>
    <div class="container">
        <div class="left-container">
            <?php include("parts/sidebar.php") ?>
        </div>

        <div class="right-container">
            <h3>All recommendations</h3>
            <div class="all-nicknames">
                <div class='popup-trigger name-card card-name-title'>
                    <div class='name name-id'>ID</div>
                    <div class='name name-name'>Slug</div>
                    <div class='name name-category'>Tiers</div>
                    <div class='name name-tags'>Tier titles</div>
                    <div class='name name-path'>Tier item</div>
                </div>

                <?php
                if ($_GET['search']=="unknown"){
                    $count_query = "SELECT count(*) as allcount FROM recommendation WHERE tier_items=''";

                }else  if (isset($_GET['search'])){
                    $count_query = "SELECT count(*) as allcount FROM recommendation WHERE slug LIKE '%$search%' Or tier_names";

                }else {
                    $count_query = "SELECT count(*) as allcount FROM recommendation";
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
                        $query = "SELECT * FROM recommendation WHERE tier_items='' ORDER BY id DESC LIMIT $start, $limit";
                    }else  if (isset($_GET['search'])) {
                        $query = "SELECT * FROM recommendation WHERE slug LIKE '%$search%' Or tier_names LIKE '%$search%' ORDER BY id DESC LIMIT $start, $limit";
                    } else {
                        $query = "SELECT * FROM recommendation ORDER BY id DESC LIMIT $start, $limit";
                    }
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $filePath = basename($row['path']);

                            echo "
                            <div class='popup-trigger name-card' data-id='{$row['id']}' data-slug='{$row['slug']}' data-total_rows='{$row['total_rows']}' data-tier_names='{$row['tier_names']}' data-tier_items='{$row['tier_items']}'>
                                <div class='name name-id'>{$row['id']}.</div>
                                <div class='name name-name'>{$row['slug']}</div>
                                <div class='name name-category'>{$row['total_rows']}</div>
                                <div class='name name-tags'>{$row['tier_names']}</div>
                                <div class='name name-path'>{$row['tier_items']}</div>

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
                <label class="hide">ID</label>
                <input class="hide right-inputs" type="text" name="id" id="id" placeholder="1">

                <label class="hide">Slug</label>
                <input class="hide right-inputs" type="text" name="slug" id="slug" placeholder="pubg-tier-list">

                <label>Total rows</label>
                <input class="right-inputs" type="number" name="total_rows" id="total_rows" placeholder="5">

                <label>Tier names</label>
                <input class="right-inputs" type="text" name="tier_names" id="tier_names" placeholder="12345678">
                
                <label>Tier items</label>
                <textarea name="tier_items" id="tier_items" style="height: 150px;"></textarea>

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
            // document.body.classList.add("blur");

        }

        // Function to close the popup
        function closePopup() {
            $('.popup').hide();
            // document.body.classList.remove("blur");
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
            $('#slug').val($(this).data('slug'));
            $('#total_rows').val($(this).data('total_rows'));
            $('#tier_names').val($(this).data('tier_names'));
            $('#tier_items').val($(this).data('tier_items'));
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
        $sql = "DELETE FROM recommendation WHERE id = ?";
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
        $total_rows = $_POST['total_rows'];
        $tier_names = $_POST['tier_names'];
        $tier_items = $_POST['tier_items'];
    
        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE recommendation SET total_rows = ?, tier_names = ?, tier_items = ? WHERE id = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
    
        // Bind the parameters
        $stmt->bind_param("issi", $total_rows, $tier_names, $tier_items, $itemId);
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
=======
<?php
$title = "All images";
$type = "recommendation";

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    if($_GET['search']=="unknown"){
        $title = "Unknown recommendations";
        $type = "unknown recommendations";
    }
}

include("header.php");

?>

<main>
    <div class="container">
        <div class="left-container">
            <?php include("parts/sidebar.php") ?>
        </div>

        <div class="right-container">
            <h3>All recommendations</h3>
            <div class="all-nicknames">
                <div class='popup-trigger name-card card-name-title'>
                    <div class='name name-id'>ID</div>
                    <div class='name name-name'>Slug</div>
                    <div class='name name-category'>Tiers</div>
                    <div class='name name-tags'>Tier titles</div>
                    <div class='name name-path'>Tier item</div>
                </div>

                <?php
                if ($_GET['search']=="unknown"){
                    $count_query = "SELECT count(*) as allcount FROM recommendation WHERE tier_items=''";

                }else  if (isset($_GET['search'])){
                    $count_query = "SELECT count(*) as allcount FROM recommendation WHERE slug LIKE '%$search%' Or tier_names";

                }else {
                    $count_query = "SELECT count(*) as allcount FROM recommendation";
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
                        $query = "SELECT * FROM recommendation WHERE tier_items='' ORDER BY id DESC LIMIT $start, $limit";
                    }else  if (isset($_GET['search'])) {
                        $query = "SELECT * FROM recommendation WHERE slug LIKE '%$search%' Or tier_names LIKE '%$search%' ORDER BY id DESC LIMIT $start, $limit";
                    } else {
                        $query = "SELECT * FROM recommendation ORDER BY id DESC LIMIT $start, $limit";
                    }
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $filePath = basename($row['path']);

                            echo "
                            <div class='popup-trigger name-card' data-id='{$row['id']}' data-slug='{$row['slug']}' data-total_rows='{$row['total_rows']}' data-tier_names='{$row['tier_names']}' data-tier_items='{$row['tier_items']}'>
                                <div class='name name-id'>{$row['id']}.</div>
                                <div class='name name-name'>{$row['slug']}</div>
                                <div class='name name-category'>{$row['total_rows']}</div>
                                <div class='name name-tags'>{$row['tier_names']}</div>
                                <div class='name name-path'>{$row['tier_items']}</div>

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
                <label class="hide">ID</label>
                <input class="hide right-inputs" type="text" name="id" id="id" placeholder="1">

                <label class="hide">Slug</label>
                <input class="hide right-inputs" type="text" name="slug" id="slug" placeholder="pubg-tier-list">

                <label>Total rows</label>
                <input class="right-inputs" type="number" name="total_rows" id="total_rows" placeholder="5">

                <label>Tier names</label>
                <input class="right-inputs" type="text" name="tier_names" id="tier_names" placeholder="12345678">
                
                <label>Tier items</label>
                <textarea name="tier_items" id="tier_items" style="height: 150px;"></textarea>

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
            // document.body.classList.add("blur");

        }

        // Function to close the popup
        function closePopup() {
            $('.popup').hide();
            // document.body.classList.remove("blur");
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
            $('#slug').val($(this).data('slug'));
            $('#total_rows').val($(this).data('total_rows'));
            $('#tier_names').val($(this).data('tier_names'));
            $('#tier_items').val($(this).data('tier_items'));
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
        $sql = "DELETE FROM recommendation WHERE id = ?";
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
        $total_rows = $_POST['total_rows'];
        $tier_names = $_POST['tier_names'];
        $tier_items = $_POST['tier_items'];
    
        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE recommendation SET total_rows = ?, tier_names = ?, tier_items = ? WHERE id = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
    
        // Bind the parameters
        $stmt->bind_param("issi", $total_rows, $tier_names, $tier_items, $itemId);
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
>>>>>>> 6f14c57 (Initial commit)
