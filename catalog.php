<?php
include("includes/functions.php");
$itemPerPage = 8;
if (isset($_GET["cat"]))
{
    if ($_GET["cat"] == "books"){
        $pageTitle = "Books";
        $category = "Books";
    } else if ($_GET["cat"] == "movies") {
        $pageTitle = "Movies";
        $category = "Movies";
    } else if ($_GET["cat"] == "music") {
        $pageTitle = "Music";
        $category = "Music";
    }
}
else {
    $pageTitle = "Catalog";
    $category = null;
}
if (isset($_GET["s"])) {
    $search = filer_imput(INPUT_GET, "s", FILTER_SANITIZE_STRING);
}
if (isset($_GET["pg"])) {
        $currentPage = $_GET["pg"];//filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
}
if (empty($currentPage)) {
    $currentPage = 1;
}
$totalItemCategory = ft_count_item_in_category($category, $search);
$totalPage = ceil($totalItemCategory / $itemPerPage);
$redirect = "";
if ($search) {
    $redirect = "s=" . $search . "&";
}
if ($category) {
    $redirect = "cat=" . $category . "&";
}
//redirect if $category too low
if ($currentPage < 1) {
    header("location:catalog.php?" . $redirect . "pg=1");
}
//redirect if $category > $totalPage
if ($currentPage > $totalPage) {
    header("location:catalog.php? . $redirect .pg=" . $totalPage);
}
//offset
$offset = ($currentPage - 1) * $itemPerPage;
if (isset($search)) {
    $catalog = ft_get_items_search($search, $itemPerPage, $offset);
    if (empty($catalog)) {
        header("location:catalog.php");
    }
} else if (isset($category)) {
    $catalog = ft_get_items_category(strtolower($category, $itemPerPage, $offset));
} else {
    $catalog = ft_get_full_catalog($itemPerPage, $offset);
}
include("includes/header.php"); ?>
<div class="section catalog page">
    <div class="wrapper">
        <h1><?php
            if ($search) {
                echo "Search";
            }
            if ($category != null) {
                echo "<a href='catalog.php' id='linkCatalog'>Click here for full catalog </a>&gt; ";
            }
            echo $pageTitle ?>
        </h1>
        <?php
        if ($search && empty($catalog)) {
            echo "<p>No items were found matching that search term.</p>";
            echo "Search again or <a href=\"catalog.php\">Browse the full catalog.</a>";
        } else {
        ?>
        <ul class="items">
            <?php
            foreach ($catalog as $item)
            {
                echo ft_get_html_by_id($item);
            }
            ?>
        </ul>
        <div class="pagination" style="text-align:right">
            Pages:
            <?php
            for ($i = 1; $i <= $totalPage; $i++) {
                if ($i == $currentPage) {
                    echo "<span>$i</span>";
                } else {
                    echo "<a href=\"catalog.php?";
                    if ($search) {
                        echo "s=$search" . "&";
                    }
                    if ($category) {
                        echo "cat=$category" . "&";
                    }
                    echo "pg=$i\" style=\"font-weight:bold;text-decoration:none\"> $i </a>";
                }
            }
        }?>
        </div>
    </div>
</div>
<?php include("includes/footer.php"); ?>
