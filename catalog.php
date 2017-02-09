<?php
include("includes/functions.php");
$catalog = ft_get_full_catalog();
if (isset($_GET["cat"]))
{
    if ($_GET["cat"] == "books"){
        $pageTitle = "Books";
        $currentPage = "Books";
    } else if ($_GET["cat"] == "movies") {
        $pageTitle = "Movies";
        $currentPage = "Movies";
    } else if ($_GET["cat"] == "music") {
        $pageTitle = "Music";
        $currentPage = "Music";
    }
}
else {
    $pageTitle = "Catalog";
    $currentPage = null;
}
include("includes/header.php"); ?>
<div class="section catalog page">
    <div class="wrapper">
        <h1><?php
            if ($currentPage != null)
            {
                echo "<a href='catalog.php' id='linkCatalog'>Click here for full catalog </a>&gt; ";
            }
            echo $pageTitle ?>
        </h1>
        <ul class="items">
            <?php
            $catalogByType = ft_catalog_by_type($catalog, $currentPage);
            foreach ($catalogByType as $id)
            {
                echo ft_get_html_by_id($id, $catalog[$id]);
            }
            ?>
        </ul>
    </div>
</div>
<?php include("includes/footer.php"); ?>
