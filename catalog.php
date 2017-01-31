<?php
include("includes/data.php");
include("includes/function.php");
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
<div class="section catalog page">
    <div class="wrapper">
        <h1><?php echo $pageTitle ?></h1>
        <ul class="items">
            <?php
            foreach ($catalog as $id => $item)
            {
                echo ft_get_html_by_id($id, $item);
            }
            ?>
        </ul>
    </div>
</div>
<?php include("includes/footer.php"); ?>
