<div id="modify_product" style="text-align: center">
	<?php 
		if (!$has_tag_selected) {
	?>
		<span>Type your category id into the search bar or select a category among the list</span>
		<div class="admin_search">
			<form class="search_bar">
				<input type="text" />
				<input type="submit" />
			</form>
		</div>
		<div id="admin_tag_list">
			<?php
				foreach($tag_list as $tag) {
					echo "<a href=\"/admin/modify_category.php?" . 
						"tag_id=". 
						$tag['id'] . 
						"\"><div class=\"tag\">" .
						$tag['name'] . 
						"</div></a>";
				}
			?>
		</div>
	<?php
		}
		else {
	?>
	<form method="POST" action="/admin/modify_category.php">
		<label>Name</label>
		<input name="name" type="text" <?php echo "value=\"" . $tag_infos['name'] . "\"" ?>/>
		<label>Description</label>
		<input name="description" type="text" <?php echo "value=\"" . $tag_infos['description'] . "\"" ?>/>
		<input name="modify" type="submit" value="Modify"/>
		<input name="delete" type="submit" value="Delete"/>
		<input name="id" type="hidden" value=<?php echo "\"" . $tag_infos['id'] . "\""; ?> />
	</form>
	<?php
		}
	?>
</div>
