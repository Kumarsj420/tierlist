<?php
session_start();

error_reporting(0);
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

</head>
<body>
<header class="my-header">
    <div class="logo"><a  href='/backdoor/'>Admin Panel</a></div>

    <div class="user-menu">
        <div class="search-bar">
            <span style="width: 100%;display:flex">
                <span class="search-icons"><iconify-icon class="search-iconify" icon="ri:search-line"></iconify-icon></span>
                
                <form id="searchForm">
                    <input class="search" name="search" value="<?php echo $placeholder ?>" type="text" placeholder="Search here...">
                </form>
            </span>
        </div>

        
        <a href='http://localhost/tierchart/add-tier-list.php'><button class="add-btn">Add tier list</button></a>
        
        <a href='' target="_blank"><button class="add-btn">View site</button></a>

    </div>
</header>