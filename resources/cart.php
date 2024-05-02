<?php require_once("config.php"); ?>

<?php 

if(isset($_GET['add'])){
	$query = query("SELECT * FROM products WHERE product_id =".escape_string($_GET['add'])." ");
	confirm($query);
	while($row = fetch_array($query)){
		if($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]) {
        //increamenting the quantity if quantity in db available
        $_SESSION['product_' . $_GET['add']]+=1;
		
	    
		
		
        redirect("../public/checkout.php");

		
      } else {


        set_message("We only have " . $row['product_quantity'] . " " . "{$row['product_title']}" . " available");
        redirect("../public/checkout.php");



      }
	}
	
	//redirect("index.php");
}

if(isset($_GET['remove'])){
	$_SESSION['product_'.$_GET['remove']]--;
	//decreasing from database
        $query = query("UPDATE products SET product_quantity =  product_quantity + 1 ");
		confirm($query);
		//unset($_SESSION['$item_quantity']);
	if($_SESSION['product_'.$_GET['remove']] < 1){
		unset($_SESSION['item_total']);
	    unset($_SESSION['item_quantity']);
		redirect("../public/checkout.php");
	}else {
	redirect("../public/checkout.php");
}

}
if(isset($_GET['delete'])){
	$_SESSION['product_'.$_GET['delete']] = '0';
	unset($_SESSION['item_total']);
	unset($_SESSION['item_quantity']);
	redirect("../public/checkout.php");
}

function cart(){
$total = 0;
$item_quantity = 0;
$sub = 0;
$item_name = 1;
$item_number =1;//that will help to remove other characters and remains the ID
$amount = 1;
$quantity =1;
//$name taking the key of associative array - $value taking the value of key
//$name take every session --> product_1 if it will be equal 20 so this is the value
foreach($_SESSION as $name => $value){

if($value > 0){

if(substr($name,0,8) == "product_"){
$length = strlen($name);
$id = substr($name,8,$length);
$query = query("SELECT * FROM products WHERE product_id = ".escape_string($id)." ");
confirm($query);

while($row =  fetch_array($query)){
$sub = $row['product_price']*$value;
$item_quantity +=$value;
$product_image = display_image($row['product_image']);
$product = <<<DELIMETER
<tr>
<td>{$row['product_title']}<br>
<img width='100' src='../resources/{$product_image}' >
</td>
<td>{$row['product_price']}</td>
<td>{$value}</td>
<td>{$sub}</td>
<td><a class='btn btn-warning' href="../resources/cart.php?remove={$row['product_id']}"><span class='glyphicon glyphicon-minus'></span></a>   <a class='btn btn-success' href="../resources/cart.php?add={$row['product_id']}"><span class='glyphicon glyphicon-plus'></span></a>
<a class='btn btn-danger' href="../resources/cart.php?delete={$row['product_id']}"><span class='glyphicon glyphicon-remove'></span></a></td>         
</tr>


<input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
<input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
<input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
<input type="hidden" id="item_quantity" name="quantity_{$quantity}" value="{$value}">

DELIMETER;

echo $product;
$item_name++;
$item_number++;
$amount++;
$quantity++;


		}//end while

		$_SESSION['item_total'] = $total += $sub;
		// $_SESSION['item_total'] = $total = $total + $sub
		$_SESSION['item_quantity'] = $item_quantity;

		

	}//end if substr()

	

	}//end if value>0
	
}//end foreach


}//end cart()

function show_paypal() {


if(isset($_SESSION['item_quantity']) && $_SESSION['item_quantity'] >= 1) {


$paypal_button = <<<DELIMETER

    <input type="image" name="upload"
    src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
    alt="PayPal - The safer, easier way to pay online">
  <img alt="" width="1" height="1"
    src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

DELIMETER;

return $paypal_button;

  }


}//end show_paypal()

function process_transaction() {



if(isset($_GET['tx'])) {

$amount = $_GET['amt'];
$currency = $_GET['cc'];
$transaction = $_GET['tx'];
$status = $_GET['st'];
$total = 0;
$item_quantity = 0;

foreach ($_SESSION as $name => $value) {

if($value > 0 ) {

if(substr($name, 0, 8 ) == "product_") {

$length = strlen($name);
$id = substr($name, 8 , $length);


$send_order = query("INSERT INTO orders (order_amount, order_transaction, order_currency, order_status ) VALUES('{$amount}', '{$transaction}','{$currency}','{$status}')");
$last_id =last_id();
confirm($send_order);



$query = query("SELECT * FROM products WHERE product_id = " . escape_string($id). " ");
confirm($query);

while($row = fetch_array($query)) {
$product_price = $row['product_price'];
$product_title = $row['product_title'];
$sub = $row['product_price']*$value;
$item_quantity +=$value;


$insert_report = query("INSERT INTO reports (product_id, order_id, product_title, product_price, product_quantity) VALUES('{$id}','{$last_id}','{$product_title}','{$product_price}','{$value}')");
confirm($insert_report);



}


$total += $sub;
echo $item_quantity;


           }
		   

      }

    }
	if(isset($id)){
    $query = query("UPDATE products SET product_quantity = GREATEST (0 , product_quantity - ".$item_quantity.") WHERE product_id = ".$id." ");
    confirm($query);
		   }

session_destroy();
  } else {


redirect("index.php");


}



}//end process_transaction()




//storing information to be used across multiple pages --> $_SESSION[] 
//Session variables hold information about one single user, and are available to all pages in one application $_SESSION['item_total']
?>



