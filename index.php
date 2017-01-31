<?php
include("includes/data.php");
include("includes/function.php");
$pageTitle = "Personal Media Library";
$currentPage = null;
include("includes/header.php");?>
		<div class="section catalog random">

			<div class="wrapper">

				<h2>May we suggest something?</h2>
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

	</div>
<?php include("includes/footer.php"); ?>
