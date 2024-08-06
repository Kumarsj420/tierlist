<<<<<<< HEAD
<div class="pagination">
    <?php 
    $search_ref = "";
    if(isset($_GET['search'])){
        $search_ref = "&search=" . urlencode($_GET['search']);
    }

    $page = isset($pno) ? $pno : 1; 
    $total_page = isset($total_page) ? $total_page : 1; // Ensure total_page is defined

    // Previous Button
    if($page > 1){
        $previous = $page - 1;
        echo "<a href='?pno=$previous$search_ref'><span class='page'>Previous</span></a>";
    } 

    // Pages before the current page
    $start_page = max(1, $page - 5);
    for($i = $start_page; $i < $page; $i++){
        echo "<a href='?pno=$i$search_ref'><span class='page'>$i</span></a>";
    }

    // Current Page
    echo "<a href=''><span style='background: #ff3636;color:white' class='page'>$page</span></a>";

    // Pages after the current page
    $end_page = min($total_page, $page + 5);
    for($i = $page + 1; $i <= $end_page; $i++){
        echo "<a href='?pno=$i$search_ref'><span class='page'>$i</span></a>";
    }

    // Next Button
    if($page < $total_page){
        $next = $page + 1;
        echo "<a href='?pno=$next$search_ref'><span class='page'>Next</span></a>";
    } 
    ?>
</div>

<div class="page-info">Total: (<?php echo $postCount ?>) Page <?php echo $page ?> of <?php echo $total_page ?></div>
=======
<div class="pagination">
    <?php 
    $search_ref = "";
    if(isset($_GET['search'])){
        $search_ref = "&search=" . urlencode($_GET['search']);
    }

    $page = isset($pno) ? $pno : 1; 
    $total_page = isset($total_page) ? $total_page : 1; // Ensure total_page is defined

    // Previous Button
    if($page > 1){
        $previous = $page - 1;
        echo "<a href='?pno=$previous$search_ref'><span class='page'>Previous</span></a>";
    } 

    // Pages before the current page
    $start_page = max(1, $page - 5);
    for($i = $start_page; $i < $page; $i++){
        echo "<a href='?pno=$i$search_ref'><span class='page'>$i</span></a>";
    }

    // Current Page
    echo "<a href=''><span style='background: #ff3636;color:white' class='page'>$page</span></a>";

    // Pages after the current page
    $end_page = min($total_page, $page + 5);
    for($i = $page + 1; $i <= $end_page; $i++){
        echo "<a href='?pno=$i$search_ref'><span class='page'>$i</span></a>";
    }

    // Next Button
    if($page < $total_page){
        $next = $page + 1;
        echo "<a href='?pno=$next$search_ref'><span class='page'>Next</span></a>";
    } 
    ?>
</div>

<div class="page-info">Total: (<?php echo $postCount ?>) Page <?php echo $page ?> of <?php echo $total_page ?></div>
>>>>>>> 6f14c57 (Initial commit)
