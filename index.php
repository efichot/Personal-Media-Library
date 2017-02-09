<?php
include("includes/functions.php");
$catalog = ft_get_full_catalog();
$pageTitle = "Personal Media Library";
$currentPage = null;
include("includes/header.php");?>
		<div class="section catalog random">

			<div class="wrapper">

				<h2>May we suggest something?</h2>
					<ul class="items">
						<?php
						$random = array_rand($catalog, 4);
						foreach ($random as $id)
						{
							echo ft_get_html_by_id($id, $catalog[$id]);
						}
						?>
					</ul>
			</div>

		</div>

	</div>
<?php include("includes/footer.php"); ?>
