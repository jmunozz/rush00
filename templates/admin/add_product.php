<div id="add_product" style="text-align: center">
	<form method="POST" action="/admin/add_product.php" enctype="multipart/form-data">
		<label>Name</label>
		<input name="name" type="text" />
		<label>Description</label>
		<input name="description" type="text" />
		<label>Price</label>
		<input name="price" type="number" />
		<label>Picture</label>
		<input name="picture" type="file" />
		<input type="hidden" name="MAX_FILE_SIZE" value="1000" />
		<br />
		<label>Category</label>
		<?php 
			foreach($allTags as $tag) {
				echo "<input name=\"" . "tag_" . $tag['id'] ."\"" . " type=\"checkbox\">" . $tag['name'] ."</input>";
			}
		?>
		<input name="add" type="submit" />
	</form>
</div>