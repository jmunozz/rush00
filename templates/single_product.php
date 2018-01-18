<div id="products">

	<?php
		if (!$product_infos['is_active']) {
			echo "<h1>This product is no longer at sale !!</h1>";
		} else {
	?>
		<div class="single_product">
			<div class='img_side'>
				<?php echo "<img style='max-width:100%;height:25vw' src=\"/admin/" . IMG_DIRECTORY . "/" . $product_infos['picture'] . "\" alt=\"Product Picture\"/>"; ?>
			</div>
			<div class="description_side">
				<?php echo "<h1>" . $product_infos['name'] . "</h1>"; ?>
				<?php echo "<p>" . $product_infos['description'] . "</p>"; ?>
				<?php echo "<h3>" . $product_infos['price'] . " $</h3>"; ?>
				<form method="POST" action="/">
					<label>Quantity</label>
					<input type="number" min="1" value="1" name="quantity">
					<input type="hidden" name="id" value=<?php echo "\"" . $product_infos['id'] ."\""; ?> />
					<input type="submit" class="cta" name="added" value="Add to Cart!"></input>
				</form>
			</div>
		</div>
	<?php 
			}
	?>

</div>