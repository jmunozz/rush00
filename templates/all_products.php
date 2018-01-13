<div id="products">
<?php 
	foreach ($product_list as $p) {
		if ($p['is_active']) {
?>
		<a href=<?php echo '"/?product_id=' . $p['id'] . '"' ?>><div class="product">
			<div class="product_title">
				<?php echo $p['name'] ?>
			</div>
			<div class="product_picture">
				<?php echo "<img src=\"/pictures/" . $p['picture'] . "\" alt=\"Product Picture\" />";?>
			</div>
			<div class="product_description">
				<?php echo $p['description'] ?>
			</div>
		</div></a>
<?php 
		}
	}
?>
</div>