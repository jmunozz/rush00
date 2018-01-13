<div id="modify_product">
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
					echo "<a href=\"/admin_modify_product.php?" . 
						"product_id=". 
						$product['id'] . 
						"\"><div class=\"product\">" .
						$product['name'] . 
						"</div></a>";
				}
			?>
		</div>
	<?php
		}
		else {
	?>
		<form method="POST" action="/admin_modify_product.php">
			<label>Name</label>
			<input name="name" type="text" <?php echo "value=\"" . $product_infos['name'] . "\"" ?>/>
			<label>Description</label>
			<input name="description" type="text" <?php echo "value=\"" . $product_infos['description'] . "\"" ?>/>
			<label>Price</label>
			<input name="price" type="number" <?php echo "value=\"" . $product_infos['price'] . "\"" ?>/>
			<label>Picture</label>
			<input name="file" type="file" />
			<label>Category</label>
			<?php 
				foreach($allTags as $t) {
					$selected = $t['selected'] ? 'checked' : '';

					echo "<input name=\"tag_" . $t['name'] . "\" type=\"checkbox\"" . $selected . ">" . $t['name'] ."</input>";
				}
			?>
			<input type="submit" name="modify" value="modify"/>
			<input type="submit" name="delete" value="delete"/>
			<input type="hidden" name="id" value=<?php echo "\"" . $product_infos['id'] . "\""; ?> />
		</form>
	<?php
		}
	?>
</div>
