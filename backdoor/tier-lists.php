<?php
$title = "All tier lists";
$type = "tier lists";

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

include("header.php");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>

<main>
    <div class="container">
        <div class="left-container">
            <?php include("parts/sidebar.php") ?>
        </div>

        <div class="right-container">
            <h3>All tier lists</h3>
            <div class="all-nicknames">
                <div class='popup-trigger name-card card-name-title'>
                    <div class='name name-id'>ID</div>
                    <div class='name name-title'>Title</div>
                    <div class='name name-category'>Category</div>
                    <div class='name name-category'>Child category</div>
                    <div class='name name-author'>Author</div>
                    <div class='name name-views'>Views</div>
                    <div class='name name-actions'>Actions</div>
                </div>

                <?php
                if (isset($_GET['search'])) {
                    $count_query = "SELECT count(*) as allcount FROM tierlist WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR description LIKE '%$search%'";
                }else {
                    $count_query = "SELECT count(*) as allcount FROM tierlist";
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
                
                    if (isset($_GET['search'])) {
                        $search = mysqli_real_escape_string($conn, $_GET['search']);
                        $query = "SELECT * FROM tierlist WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR description LIKE '%$search%' ORDER BY id DESC LIMIT $start, $limit";
                    } else {
                        $query = "SELECT * FROM tierlist ORDER BY id DESC LIMIT $start, $limit";
                    }
                
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $bag = 'white';
                            if ($_SESSION['admin-email'] == $row['email']) {
                                $bag = "#e7fff6";
                            }
                            echo "
                            <div class='name-card tierlist-card' data-id='{$row['id']}' data-name='{$row['name']}' data-email='{$row['email']}' data-message='{$row['message']}'>
                                <div class='name name-id'>{$row['id']}.</div>
                                <div class='name name-title'><a href='/'>{$row['title']}</a></div>
                                <div class='name name-category'>{$row['category']}</div>
                                <div class='name name-category'>{$row['child_category']}</div>
                                <div class='name name-author'>{$row['author']}</div>
                                <div class='name name-views'>{$row['views']}</div>
                                <div class='name name-actions'><a href='/'><iconify-icon icon='mynaui:edit-one'></iconify-icon></a></div>
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
</main>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $itemId = $_POST['id'];
        $sql = "DELETE FROM contact WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $itemId); // Changed to integer type
        if ($stmt->execute() === TRUE) {
            echo "<script>window.location.href=window.location.href;</script>";
        } else {
            echo "Error deleting item: " . $conn->error;
        }
        $stmt->close();
    }

    if (isset($_POST['update'])) {
        $itemId = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
    
        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE contact SET name = ?, email = ?, message = ? WHERE id = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
    
        // Bind the parameters
        $stmt->bind_param("sssi", $name, $email, $message, $itemId);
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
