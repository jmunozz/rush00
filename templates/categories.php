<div id="categories">
	<?php
		foreach ($tags as $tag) {
			if ($tag['is_active']) {
	?>
				<a href=<?php echo '"/?category=' . $tag['name'] . '"' ?>><div class="category">
					<div class="category_title">
						<?php echo $tag['name'] ?>
					</div>
					<div class="category_description">
						<?php echo $tag['description'] ?>
					</div>
				</div></a>
	<?php 
			}
		}
	?>
</div>