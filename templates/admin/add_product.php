<div id="add_product">
	<form method="POST" action="/admin_add_product.php">
		<label>Name</label>
		<input name="name" type="text" />
		<label>Description</label>
		<input name="description" type="text" />
		<label>Price</label>
		<input name="price" type="number" />
		<label>Picture</label>
		<input name="picture" type="file" />
		<label>Category</label>
		<?php 
			foreach($allTags as $tag) {
				echo "<input name=\"" . "tag_" . $tag['name'] ."\"" . " type=\"checkbox\">" . $tag['name'] ."</input>";
			}
		?>
		<input name="add" type="submit" />
	</form>
</div>