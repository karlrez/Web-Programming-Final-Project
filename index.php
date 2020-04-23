<?php include 'header.php'; ?>
<?php include 'menuItem.php'; ?>

<?php
// Instantiate menuItem objects and add into array in while loop
$i = 0;
$menuArray = array();
while ($i < 4) { // stars from lab look ugly 
	//$stars = str_repeat('*',$i+1).($i+1);

	switch ($i % 2) {
		case 0: # for even number
			$name = 'The WP Burger';
			$description = 'Freshly made all-beef patty served up with homefries';
			$price = '$14';
			$arrayItem = new menuItem($name/*.$stars*/, $description, $price);
			array_push($menuArray, $arrayItem);
			break;

		default: # odd numbers
			$name = 'WP Kebobs';
			$description = 'Tender cuts of beef and chicken, served with your choice of side';
			$price = '$17';
			$arrayItem = new menuItem($name/*.$stars*/, $description, $price);
			array_push($menuArray, $arrayItem);
	}
	$i++;
}
?>

<div id="content" class="clearfix">
	<aside>
		<?php
		// date function only returns an index number, so making an array for days of week
		$dayOfWeek = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
		echo "<h2>" . $dayOfWeek[date('w')] . "'s Specials</h2>"; ?>

		<!-- Looping thru the array to print out the menu items -->
		<?php
		for ($i = 0; $i < 4; $i++) {
			echo "<hr>";
			if ($i % 2 == 0) {
				echo '<img src="images/burger_small.jpg" alt="Burger">';
			} else {
				echo '<img src="images/kebobs.jpg" alt="Kebobs" title="WP Kebobs">';
			}
			echo "<h3>" . $menuArray[$i]->getItemName() . "</h3>";
			echo "<p>" . $menuArray[$i]->getDescription() . ' - ' . $menuArray[$i]->getPrice() . "</p>";
		}
		?>
	</aside>
	<div class="main">

		<h1>Welcome</h1>
		<img src="images/dining_room.jpg" alt="Dining Room" title="The WP Eatery Dining Room" class="content_pic">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
		<h2>Book your Christmas Party!</h2>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
		<br>

		<?php
		$now = new \DateTime('now');
		echo "<h1>" . $month = $now->format("F") . " Special</h1>";
		$var = 5;
		if ($now->format("m") > 8) {
			echo "<h2> Chicken Feast - $15 </h2>";
			echo "<img src='images/special1.jpg'><img src='images/fries.jpg' height='194px'><img src='images/coleslaw.jpg' height='194px'>";
			echo "<p>Crispy fried chicken served with fries and coleslaw</p>";
		} else if ($now->format("m") > 4) {
			echo "<h2> Rib Eye Steak - $15 </h2>";
			echo "<img src='images/special2.jpg'><img src='images/fries.jpg' height='194px'><img src='images/coleslaw.jpg' height='194px'>";
			echo "<p>Rib eye steak served with fries and coleslaw</p>";
		} else {
			echo "<h2> Salmon Feast - $15 </h2>";
			echo "<img src='images/special3.jpg'><img src='images/fries.jpg' height='194px'><img src='images/coleslaw.jpg' height='194px'>";
			echo "<p>Fresh salmon served with fries and coleslaw</p>";
		}
		?>

	</div><!-- End Main -->
</div><!-- End Content -->
<!-- to include footer -->
<?php include 'footer.php' ?>