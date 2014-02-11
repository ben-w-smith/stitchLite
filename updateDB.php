<?php

include "pullShopify.php";
include "pullVend.php";
include_once "Product.php";

// run shopify's pull
$shopifyProds = getShopifyProducts();
echo "<pre>" . print_r($shopifyProds, true) . "</pre>";

// run vendhq's pull
$vendProds = getVendProducts();
echo "<pre>" . print_r($vendProds, true) . "</pre>";

// connect to database
$host = "localhost";
$username = "kungfu_stitch";
$password = "stitchlite";
$dbname = "kungfu_stitchLite";

$con = mysqli_connect($host, $username, $password, $dbname);

if( mysqli_connect_errno() ) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// make query example
$sql = "SELECT * FROM  `products`";

$result = $con->query($sql);

// query read out
$dbProds = array();
while($row = mysqli_fetch_array($result) ) {
	$product = new Product();

	$product->id = $row['id'];
	$product->name = $row['name'];
	$product->sku = $row['sku'];
	$product->price = $row['price'];
	$product->quantity = $row['quantity'];
	$product->shopifyId = $row['shopify'];
	$product->vendId = $row['vendhq'];

	array_push($dbProds, $product);
}

echo "<pre>" . print_r($dbProds, true) . "</pre>";

// look for new sku's and add them
	// if a new sku is found add it to the db with insert

// insert sql
//$insertNewSkuProd = "INSERT INTO `stitchLite`.`products` 
//(`id`, `name`, `sku`, `quantity`, `price`, `shopify`, `vendhq`) VALUES
//(NULL, '', '', '', '', '', '');";

// delete product from that array
//$length = 1;
//array_splice($array, $index, $length);

// update existing items
// first do inventory then update everything else

// calculate by multiplying current db inventory by vendors it is present in
// get difference from sum of vendor's inventories, then take db inventory and
// subtract it by that previous difference


// close sql connection
mysqli_close($con);
?>
