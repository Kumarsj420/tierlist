<<<<<<< HEAD
<?php
$type="home";

include("header.php");

$countQuery = "SELECT COUNT(*) AS total FROM tierlist";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalNicknames = $countRow['total'];

$countQuery = "SELECT COUNT(*) AS total FROM users";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalNames = $countRow['total'];


$countQuery = "SELECT COUNT(*) AS total FROM contact";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalMessages = $countRow['total'];



?>

<main>
    <div class="container">
        <div class="left-container">
            <?php include("parts/sidebar.php") ?>
        </div>

        <div class="right-container home-bar">
<div class="projects"><div class="project-header">
                <span class="project-heading">Site statistics</span>
                

                <a style="color:black" target="_blank" href="https://trends.google.com/trends/explore?date=now%201-d&q=tier%20list,tier%20list%20maker,tier%20list%20for,tier%20list%20of&hl=en-IN"><span class="create-project"><iconify-icon icon="mingcute:google-fill"></iconify-icon> Trends</span></a>
                
            </div>

            <div class="project-cards">

            <div class="project-card">
                    <div class="card-heading">
                        <span class="card-name">Tier lists</span>
                    </div>
                    <div class="numbers"><?php echo $totalNicknames ?></div>
                    <div class="by-you">37 by you</div>
            </div>
            
            <div class="project-card">
                    <div class="card-heading">
                        <span class="card-name">Users</span>
                    </div>
                    <div class="numbers"><?php echo $totalNames ?></div>
                    <div class="by-you">37 by you</div>
            </div>
            
                        <div class="project-card">
                    <div class="card-heading">
                        <span class="card-name">Messages</span>
                    </div>
                    <div class="numbers"><?php echo $totalMessages ?></div>
                    <div class="by-you">37 by you</div>
            </div>
            
            <div class="project-card">
                    <div class="card-heading">
                        <span class="card-name">not set</span>
                    </div>
                    <div class="numbers"><?php echo "00" ?></div>
                    <div class="by-you">000</div>
            </div>

            </div>
        </div>
        
        </div>
    </div>
=======
<?php
$type="home";

include("header.php");

$countQuery = "SELECT COUNT(*) AS total FROM tierlist";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalNicknames = $countRow['total'];

$countQuery = "SELECT COUNT(*) AS total FROM users";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalNames = $countRow['total'];


$countQuery = "SELECT COUNT(*) AS total FROM contact";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalMessages = $countRow['total'];



?>

<main>
    <div class="container">
        <div class="left-container">
            <?php include("parts/sidebar.php") ?>
        </div>

        <div class="right-container home-bar">
<div class="projects"><div class="project-header">
                <span class="project-heading">Site statistics</span>
                

                <a style="color:black" target="_blank" href="https://trends.google.com/trends/explore?date=now%201-d&q=tier%20list,tier%20list%20maker,tier%20list%20for,tier%20list%20of&hl=en-IN"><span class="create-project"><iconify-icon icon="mingcute:google-fill"></iconify-icon> Trends</span></a>
                
            </div>

            <div class="project-cards">

            <div class="project-card">
                    <div class="card-heading">
                        <span class="card-name">Tier lists</span>
                    </div>
                    <div class="numbers"><?php echo $totalNicknames ?></div>
                    <div class="by-you">37 by you</div>
            </div>
            
            <div class="project-card">
                    <div class="card-heading">
                        <span class="card-name">Users</span>
                    </div>
                    <div class="numbers"><?php echo $totalNames ?></div>
                    <div class="by-you">37 by you</div>
            </div>
            
                        <div class="project-card">
                    <div class="card-heading">
                        <span class="card-name">Messages</span>
                    </div>
                    <div class="numbers"><?php echo $totalMessages ?></div>
                    <div class="by-you">37 by you</div>
            </div>
            
            <div class="project-card">
                    <div class="card-heading">
                        <span class="card-name">not set</span>
                    </div>
                    <div class="numbers"><?php echo "00" ?></div>
                    <div class="by-you">000</div>
            </div>

            </div>
        </div>
        
        </div>
    </div>
>>>>>>> 6f14c57 (Initial commit)
</main>