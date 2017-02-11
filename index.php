<?php
include("includes/functions.php");
$pageTitle = "Personal Media Library";
$currentPage = null;
include("includes/header.php");?>
		<div class="section catalog random">

			<div class="wrapper">

				<h2>May we suggest something?</h2>
					<ul class="items">
						<?php
						$random = ft_get_rdm_4items();
						foreach ($random as $item)
						{
							echo ft_get_html_by_id($item);
						}
						?>
					</ul>
			</div>

		</div>

	</div>
<?php include("includes/footer.php"); ?>
