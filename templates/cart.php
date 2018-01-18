<div class="limiter">
My Cart
</div>
<div id="cart">
	<?php

			foreach($cart_content as $cart_product) {
				if (!isset($cart_product['name']))
					continue;
	?>
			<div class="cart_product">
				<form method="POST" action="/cart.php">
					<img class="miniature" <?php echo "src=\"/admin/" . IMG_DIRECTORY . "/" . $cart_product['picture'] . "\""; ?>></img>
					<span style="margin:0 10px"> <?php echo $cart_product['name']; ?></span>

					<label>Quantity :</label>
					<input name="quantity" type="number" min="1" value=<?php echo "\"" . $cart_product['quantity'] . "\""; ?> />
					<input name="id" type="hidden" value=<?php echo "\"" . $cart_product['id'] . "\""; ?> />
					<input name="modify" type="submit" value="Modify" />
					<input class="delete" name="delete" type="submit" value="Delete" />
					<span><?php echo $cart_product['price'] . "$"; ?></span>
				</form>
			</div>
	<?php 
			}
	?>
		<div class="cart_confirm">
			<span>
				<?php 
					echo "TOTAL: " . calculateTotalPrice($cart_content) . "$"; 
				?>
			</span>
			<form method="POST" action="/cart.php">
				<input name="content" type="hidden" value=<?php echo "\"" . $string_cart_content . "\""; ?> />
				<input class="cta" name="archive" type="submit" value="Purchase these articles" />
			</form>
		</div>
</div>