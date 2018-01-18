<div id="modify_product" style="text-align: center">
	<?php 
		if (!$has_product_selected) {
	?>
		<span>Type your product id into the search bar or select a product among the list</span>
		<div id="admin_product_search">
			<form id="search">
				<input type="text" />
				<input type="submit" />
			</form>
		</div>
		<div id="admin_product_list">
			<?php
				foreach($product_list as $product) {
					echo "<a href=\"/admin/modify_product.php?" . 
						"product_id=". 
						$product['id'] . 
						"\"><div>" .
						$product['name'] . 
						"</div></a>";
				}
			?>
		</div>
	<?php
		}
		else {
	?>
		<form method="POST" action="/admin/modify_product.php" enctype="multipart/form-data">
			<label>Name</label>
			<input name="name" type="text" <?php echo "value=\"" . $product_infos['name'] . "\"" ?>/>
			<label>Description</label>
			<input name="description" type="text" <?php echo "value=\"" . $product_infos['description'] . "\"" ?>/>
			<label>Price</label>
			<input name="price" type="number" <?php echo "value=\"" . $product_infos['price'] . "\"" ?>/>
			<label>Picture</label>
			<input name="picture" type="file" />
			<input type="hidden" name="MAX_FILE_SIZE" value="1000" />
			<label>Category</label>
			<?php 
				foreach($allTags as $t) {
					$selected = $t['selected'] ? 'checked' : '';

					echo "<input name=\"tag_" . $t['id'] . "\" type=\"checkbox\"" . $selected . ">" . $t['name'] ."</input>";
				}
			?>
			<input type="submit" name="modify" value="Modify"/>
			<input type="submit" name="delete" value="Delete"/>
			<input type="hidden" name="id" value=<?php echo "\"" . $product_infos['id'] . "\""; ?> />
		</form>
	<?php
		}
	?>
</div>
