<?php
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
else
    $pageTitle = "Catalog";
include("includes/header.php"); ?>
<div class="section page">
        <h1><?php echo $pageTitle ?></h1>
</div>
<?php include("includes/footer.php"); ?>
