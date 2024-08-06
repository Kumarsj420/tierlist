<<<<<<< HEAD
<?php
$title = "All Messages";
$type = "messages";

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
            <h3>All messages</h3>
            <div class="all-nicknames">
                <div class='popup-trigger name-card card-name-title'>
                    <div class='name name-id'>ID</div>
                    <div class='name name-name'>Name</div>
                    <div class='name name-email'>Email</div>
                    <div class='name name-message'>Message</div>
                </div>

                <?php
                if (isset($_GET['search'])) {
                    $count_query = "SELECT count(*) as allcount FROM contact WHERE message LIKE '%$search%' OR name LIKE '%$search%' OR email LIKE '%$search%'";
                }else {
                    $count_query = "SELECT count(*) as allcount FROM contact";
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
                        $query = "SELECT * FROM contact WHERE message LIKE '%$search%' OR name LIKE '%$search%' OR email LIKE '%$search%' ORDER BY id DESC LIMIT $start, $limit";
                    } else {
                        $query = "SELECT * FROM contact ORDER BY id DESC LIMIT $start, $limit";
                    }
                
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $bag = 'white';
                            if ($_SESSION['admin-email'] == $row['email']) {
                                $bag = "#e7fff6";
                            }
                            echo "
                            <div class='popup-trigger name-card' data-id='{$row['id']}' data-name='{$row['name']}' data-email='{$row['email']}' data-message='{$row['message']}'>
                                <div class='name name-id'>{$row['id']}.</div>
                                <div class='name name-name'>{$row['name']}</div>
                                <div class='name name-email'>{$row['email']}</div>
                                <div class='name name-message'>{$row['message']}</div>
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

                <label>Email</label>
                <input class="right-inputs" type="email" name="email" id="email" placeholder="">

                <label>Message</label>
                <textarea name="message" id="message" style="max-height:80px"></textarea>
                <span class="close">X</span>
        </div>
        <div class="popup-footer">
            <button name='delete' class='popup-btn delete'>delete</button>
            <button name='update' class='popup-btn update'>update</button>
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
            $('#email').val($(this).data('email'));
            $('#message').val($(this).data('message'));
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
=======
<?php
$title = "All Messages";
$type = "messages";

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
            <h3>All messages</h3>
            <div class="all-nicknames">
                <div class='popup-trigger name-card card-name-title'>
                    <div class='name name-id'>ID</div>
                    <div class='name name-name'>Name</div>
                    <div class='name name-email'>Email</div>
                    <div class='name name-message'>Message</div>
                </div>

                <?php
                if (isset($_GET['search'])) {
                    $count_query = "SELECT count(*) as allcount FROM contact WHERE message LIKE '%$search%' OR name LIKE '%$search%' OR email LIKE '%$search%'";
                }else {
                    $count_query = "SELECT count(*) as allcount FROM contact";
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
                        $query = "SELECT * FROM contact WHERE message LIKE '%$search%' OR name LIKE '%$search%' OR email LIKE '%$search%' ORDER BY id DESC LIMIT $start, $limit";
                    } else {
                        $query = "SELECT * FROM contact ORDER BY id DESC LIMIT $start, $limit";
                    }
                
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $bag = 'white';
                            if ($_SESSION['admin-email'] == $row['email']) {
                                $bag = "#e7fff6";
                            }
                            echo "
                            <div class='popup-trigger name-card' data-id='{$row['id']}' data-name='{$row['name']}' data-email='{$row['email']}' data-message='{$row['message']}'>
                                <div class='name name-id'>{$row['id']}.</div>
                                <div class='name name-name'>{$row['name']}</div>
                                <div class='name name-email'>{$row['email']}</div>
                                <div class='name name-message'>{$row['message']}</div>
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

                <label>Email</label>
                <input class="right-inputs" type="email" name="email" id="email" placeholder="">

                <label>Message</label>
                <textarea name="message" id="message" style="max-height:80px"></textarea>
                <span class="close">X</span>
        </div>
        <div class="popup-footer">
            <button name='delete' class='popup-btn delete'>delete</button>
            <button name='update' class='popup-btn update'>update</button>
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
            $('#email').val($(this).data('email'));
            $('#message').val($(this).data('message'));
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
>>>>>>> 6f14c57 (Initial commit)
