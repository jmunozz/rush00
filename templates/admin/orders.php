<?php 
	if (!$orders) 
	{
		echo "<div>There is no orders yet...</div>";
	} else {
		echo "<table style='width:100%'><tr><th>User</th><th>Item</th><th>Quantity</th><th>Price</th><th>Hour</th></tr>";
		foreach($orders as $order) {
?>		
		<?php echo "<tr><td>" .$order['user_login']."</td><td>".$order['content']."</td><td>" .$order['quantity']."</td><td>" .$order['price']." $</td><td>" .$order['hour']."</td></tr>";?>
<?php }}?>
</table>

