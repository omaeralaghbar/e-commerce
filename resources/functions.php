<?php
$upload_directory = "uploads";

//------------------------------------- 1-HELPER FUNCTIONS ----------------
function display_image($picture) {

global $upload_directory;

return $upload_directory  . DS . $picture;



}//end display_image()


function last_id(){

global $connection;

return mysqli_insert_id($connection);


}//end last_id()

function set_message($msg){
    if(!empty($msg)){
        $_SESSION['message'] = $msg;
    }else{
        $msg = "";
    }
}//end set_message()

function display_message(){
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}//end display_message

function count_all_records($table){
    return mysqli_num_rows(query('SELECT * FROM '.$table));
}


function count_all_products_in_stock(){

    return mysqli_num_rows(query('SELECT * FROM products WHERE product_quantity >= 1'));
}



//header() is helper func to send a new HTTP header before html or txt to browser
function redirect($location){
	header("Location:$location");
}
//helper function to fetch queries
function query($sql){
	global $connection;
	return mysqli_query($connection , $sql);
}
//to make sure the query is working
function confirm($result){
    global $connection;
	if(!$result) {
      die("QUERY FAILED " . mysqli_error($connection));
	}
}

//helper func to prevent injection , is used to escape characters in a string, making it legal to use in an SQL statement
function escape_string($string){
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}
//fetch query
function fetch_array($result){

return mysqli_fetch_array($result);

}

//------------------------------------- 2- FRONT END FUNCTIONS ----------------------------

function get_products_with_pagination($perPage = "6"){
	$query = query("SELECT * FROM products");
	confirm($query);

    $rows = mysqli_num_rows($query);
    if(isset($_GET['page'])){
        //#[^0-9]# regular expression to negate any thing except numbers
        //preg_replace will return empty if anything written after page key except num --> index.php?page=1,2,3.... return num

        $page = preg_replace('#[^0-9]#','',$_GET['page']);
        
    }else{
        $page = 1;
    }
    $prePage = 6;
    $lastPage = ceil($rows/$prePage);//ceil returns round num 0.95 -> 1
    if($page < 1){
        $page = 1;
    }elseif($page > $lastPage){
        $page = $lastPage;
    }
    //middle numbers referance
    $middleNumbers = '';
    $sub1 = $page - 1;
    $sub2 = $page - 2;
    $add1 = $page + 1;
    $add2 = $page + 2;

    if($page == 1){
        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a></li>';
    }elseif ($page == $lastPage) {
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a></li>';
        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
    }elseif ($page > 2 && $page < ($lastPage - 1)) {
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub2 . '">' . $sub2 . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a></li>';
        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add2 . '">' . $add2 . '</a></li>';
    }elseif ($page > 1 && $page < $lastPage) {
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page= ' . $sub1 . '">' . $sub1 . '</a></li>';
        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a></li>';
        //echo "<ul class='pagination'>{$middleNumbers}</ul>";
        }
        //accordint to the data that stored in db it will show the next
        $limit = 'LIMIT ' . ($page - 1) * $perPage . ',' . $perPage;

        $query2 = query(" SELECT * FROM products WHERE product_quantity >= 1 " . $limit);
        confirm($query2);
        $outputPagination = ""; // Initialize the pagination output variable
        /*if($lastPage != 1){
        echo "page $page of $lastPage"
        }*/

        if ($page != 1) {
            $prev = $page - 1;
            $outputPagination .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $prev . '">Back</a></li>';
        }

        $outputPagination .= $middleNumbers;

        if ($page != $lastPage) {
            $next = $page + 1;
            $outputPagination .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $next . '">Next</a></li>';
        }






	while($row = fetch_array($query2)){
		$product_image = display_image($row['product_image']);
	$product = 
    <<<DELIMETER
<div class="col-sm-6 col-lg-6 col-md-6">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"><img class="img-responsive" style="max-height: 200px; min-height: 200px"  src="../resources/{$product_image}" alt=""></a>
        <div class="caption">
            <h4 class="pull-right">&#36;{$row['product_price']}</h4>
            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
            </h4>
            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
             <p class="text-center"><a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
             
        </div>
    </div>
</div>

DELIMETER;

echo $product;
	}

    echo "<div class='text-center' style='clear: both;' ><ul class='pagination' >{$outputPagination}</ul></div>";

}//end get_products()

function get_gallery_with_pagination($perPage = "6"){
	$query = query("SELECT * FROM products");
	confirm($query);

    $rows = mysqli_num_rows($query);
    if(isset($_GET['page'])){
        //#[^0-9]# regular expression to negate any thing except numbers
        //preg_replace will return empty if anything written after page key except num --> index.php?page=1,2,3.... return num

        $page = preg_replace('#[^0-9]#','',$_GET['page']);
        
    }else{
        $page = 1;
    }
    $prePage = 6;
    $lastPage = ceil($rows/$prePage);//ceil returns round num 0.95 -> 1
    if($page < 1){
        $page = 1;
    }elseif($page > $lastPage){
        $page = $lastPage;
    }
    //middle numbers referance
    $middleNumbers = '';
    $sub1 = $page - 1;
    $sub2 = $page - 2;
    $add1 = $page + 1;
    $add2 = $page + 2;

    if($page == 1){
        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a></li>';
    }elseif ($page == $lastPage) {
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a></li>';
        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
    }elseif ($page > 2 && $page < ($lastPage - 1)) {
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub2 . '">' . $sub2 . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a></li>';
        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add2 . '">' . $add2 . '</a></li>';
    }elseif ($page > 1 && $page < $lastPage) {
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page= ' . $sub1 . '">' . $sub1 . '</a></li>';
        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a></li>';
        //echo "<ul class='pagination'>{$middleNumbers}</ul>";
        }
        //accordint to the data that stored in db it will show the next
        $limit = 'LIMIT ' . ($page - 1) * $perPage . ',' . $perPage;

        $query2 = query(" SELECT * FROM products WHERE product_quantity >= 1 " . $limit);
        confirm($query2);
        $outputPagination = ""; // Initialize the pagination output variable
        /*if($lastPage != 1){
        echo "page $page of $lastPage"
        }*/

        if ($page != 1) {
            $prev = $page - 1;
            $outputPagination .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $prev . '">Back</a></li>';
        }

        $outputPagination .= $middleNumbers;

        if ($page != $lastPage) {
            $next = $page + 1;
            $outputPagination .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $next . '">Next</a></li>';
        }






	while($row = fetch_array($query2)){
		$product_image = display_image($row['product_image']);
	$product = 
    <<<DELIMETER
<div class="col-sm-4 col-lg-4 col-md-2">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"><img class="img-responsive center" style="max-height: 200px; min-height: 200px"  src="../resources/{$product_image}" alt=""></a>
        <div class="caption">
            <h4 class="pull-right">&#36;{$row['product_price']}</h4>
            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
            </h4>
           
             
        </div>
    </div>
</div>

DELIMETER;

echo $product;
	}

    echo "<div class='text-center' style='clear: both;' ><ul class='pagination' >{$outputPagination}</ul></div>";

}//end get_products()

function get_categories(){
    
                $query = query("SELECT * FROM categories");
                confirm($query);
                while( $row = fetch_array($query) ) {
                    $category_links = 
    <<<DELIMETER

    <a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>

DELIMETER;
echo $category_links;
                }//while           
}//end get_categories()


//$query2 = query(" SELECT * FROM products WHERE product_quantity >= 1 AND product_category_id = " . escape_string($_GET['id']) . " " . $limit);
        



function get_products_in_cat_page() {

$query = query(" SELECT * FROM products WHERE product_category_id = " . escape_string($_GET['id']) . " ");
confirm($query);


while($row = fetch_array($query)) {

$product_image = display_image($row['product_image']);

$product = <<<DELIMETER

 <div class="col-sm-6 col-lg-6 col-md-6">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"><img class="img-responsive" style="max-height: 200px; min-height: 200px"  src="../resources/{$product_image}" alt=""></a>
        <div class="caption">
            <h4 class="pull-right">&#36;{$row['product_price']}</h4>
            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
            </h4>
            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
             <p class="text-center"><a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
             
        </div>
    </div>
</div>           

DELIMETER;

echo $product;


		}
        //echo "<div class='text-center' style='clear: both;' ><ul class='pagination' >{$outputPagination}</ul></div>";


} // end get_products_in_cat_page()

function get_products_in_shop_page() {


$query = query(" SELECT * FROM products ");
confirm($query);

while($row = fetch_array($query)) {

$product_image = display_image($row['product_image']);

$product = <<<DELIMETER


            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img width="200" height="100" src="../resources/{$product_image}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>{$row['short_desc']}</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

DELIMETER;

echo $product;


		}


}//end get_products_in_shop_page()

function login_user(){

if(isset($_POST['submit'])){

$username = escape_string($_POST['username']);
$password = escape_string($_POST['password']);

$query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password }' ");
confirm($query);

if(mysqli_num_rows($query) == 0) {

set_message("Your Password or Username are wrong");
redirect("login.php");


} else {

$_SESSION['username'] = $username;
//set_message("Welcome to admin page {$username}");
redirect("admin");

         }



    }



}// end login_user()

function send_message() {

    if(isset($_POST['submit'])){

        $to          = "omaeralagbar@gmail.com";
        $from_name   =   $_POST['name'];
        $subject     =   $_POST['subject'];
        $email       =   $_POST['email'];
        $message     =   $_POST['message'];


        $headers = "From: {$from_name} {$email}";


        $result = mail($to, $subject, $message,$headers);

        if(!$result) {

            set_message("Sorry we could not send your message");
            redirect("contact.php");
        } else {

            set_message("Your Message has been sent");
            redirect("contact.php");
        }




    }




}//end send_message()






//------------------------------------- 3- BACK END FUNCTIONS ----------------------------

function display_orders(){
    $query = query("SELECT * FROM orders");
confirm($query);


while($row = fetch_array($query)) {


$orders = <<<DELIMETER

<tr>
    <td>{$row['order_id']}</td>
    <td>{$row['order_amount']}</td>
    <td>{$row['order_transaction']}</td>
    <td>{$row['order_currency']}</td>
    <td>{$row['order_status']}</td>
    <td><a class="btn btn-danger" href="index.php?delete_order_id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>




DELIMETER;

echo $orders;



    }
}//end display_orders()

function display_comments(){
    $query = query("SELECT * FROM comments");
confirm($query);


while($row = fetch_array($query)) {


$comments = <<<DELIMETER

<tr>
    <td>{$row['id']}</td>
    <td>{$row['product_id']}</td>
    <td>{$row['author']}</td>
    <td>{$row['email']}</td>
    <td>{$row['title']}</td>
    <td>{$row['comment']}</td>
    <td><a class="btn btn-danger" href="index.php?delete_comment_id={$row['id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
    <td><a class="btn btn-primary" href="index.php?publish_comment_id={$row['id']}">Publish</a></td>
    <td><a class="btn btn-warning" href="index.php?draft_comment_id={$row['id']}">Draft</a></td>
</tr>




DELIMETER;

echo $comments;



    }
}//end display_comments()



//--------------------- Admin products page ----------------



function get_products_in_admin(){
   $query = query(" SELECT * FROM products");
confirm($query);

while($row = fetch_array($query)) {

$category = show_product_category_title($row['product_category_id']);

$product_image = display_image($row['product_image']);

$product = <<<DELIMETER

        <tr>
            <td>{$row['product_id']}</td>
            <td><a href="index.php?edit_product&id={$row['product_id']}">{$row['product_title']}</a><br>
       <img width='100' src="../../resources/{$product_image}" alt="">
            </td>
            <td>{$category}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
             <td><a class="btn btn-danger" href="index.php?delete_product_id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

DELIMETER;

echo $product;


        }
}//end get_products_in_admin

function show_product_category_title($product_category_id){


$category_query = query("SELECT * FROM categories WHERE cat_id = '{$product_category_id}' ");
confirm($category_query);

while($category_row = fetch_array($category_query)) {

return $category_row['cat_title'];

}



}

function get_comments_in_admin(){
    if(isset($_POST['publish'])){}
}

function get_comments_in_item(){
    if(isset($_POST['submit'])){
        $product_id = escape_string($_GET['id']);
        $author   = escape_string($_POST['author']);
        $email    = escape_string($_POST['email']);
        $title    = escape_string($_POST['title']);
        $comment  = escape_string($_POST['comment']);

        $query = query("INSERT INTO comments(product_id, author, email, title, comment)
        VALUES('{$product_id}', '{$author}', '{$email}', '{$title}', '{$comment}')");
        
        confirm($query);
        
    }
}






/***************************Add Products in admin********************/


function add_product() {


if(isset($_POST['publish'])) {


$product_title          = escape_string($_POST['product_title']);
$product_category_id    = escape_string($_POST['product_category_id']);
$product_price          = escape_string($_POST['product_price']);
$product_description    = escape_string($_POST['product_description']);
$short_desc             = escape_string($_POST['short_desc']);
$product_quantity       = $_POST['product_quantity'];
$product_image          = $_FILES['file']['name'];
$image_temp_location    = $_FILES['file']['tmp_name'];

$twoZerosPrice = number_format($product_price, 2, '','00');


move_uploaded_file($image_temp_location  , UPLOAD_DIRECTORY . DS . $product_image);


$query = query("INSERT INTO products(product_title, product_category_id, product_price, product_description, short_desc, product_quantity, product_image) VALUES('{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_description}', '{$short_desc}', '{$product_quantity}', '{$product_image}')");
$last_id = last_id();
confirm($query);


    



set_message("New Product with id {$last_id} was Added");
redirect("index.php?products");


        }

}

function show_categories_add_product_page(){


$query = query("SELECT * FROM categories");
confirm($query);

while($row = fetch_array($query)) {


$categories_options = <<<DELIMETER

 <option value="{$row['cat_id']}">{$row['cat_title']}</option>


DELIMETER;

echo $categories_options;

     }



}



/***************************updating product code ***********************/

function update_product() {


if(isset($_POST['update'])) {


$product_title          = escape_string($_POST['product_title']);
$product_category_id    = escape_string($_POST['product_category_id']);
$product_price          = escape_string($_POST['product_price']);
$product_description    = escape_string($_POST['product_description']);
$short_desc             = escape_string($_POST['short_desc']);
$product_quantity       = escape_string($_POST['product_quantity']);
$product_image          = escape_string($_FILES['file']['name']);
$image_temp_location    = escape_string($_FILES['file']['tmp_name']);


if(empty($product_image)) {

$get_pic = query("SELECT product_image FROM products WHERE product_id =" .escape_string($_GET['id']). " ");
confirm($get_pic);

while($pic = fetch_array($get_pic)) {

$product_image = $pic['product_image'];

    }

}



move_uploaded_file($image_temp_location  , UPLOAD_DIRECTORY . DS . $product_image);


$query = "UPDATE products SET ";
$query .= "product_title            = '{$product_title}'        , ";
$query .= "product_category_id      = '{$product_category_id}'  , ";
$query .= "product_price            = '{$product_price}'        , ";
$query .= "product_description      = '{$product_description}'  , ";
$query .= "short_desc               = '{$short_desc}'           , ";
$query .= "product_quantity         = '{$product_quantity}'     , ";
$query .= "product_image            = '{$product_image}'          ";
$query .= "WHERE product_id=" . escape_string($_GET['id']);





$send_update_query = query($query);
confirm($send_update_query);
set_message("Product has been updated");
redirect("index.php?products");


        }


}

/*************************Categories in admin ********************/


function show_categories_in_admin() {


$category_query = query("SELECT * FROM categories");
confirm($category_query);


while($row = fetch_array($category_query)) {

$cat_id = $row['cat_id'];
$cat_title = $row['cat_title'];


$category = <<<DELIMETER


<tr>
    <td>{$cat_id}</td>
    <td>{$cat_title}</td>
    <td><a class="btn btn-danger" href="./index.php?delete_category_id={$row['cat_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>



DELIMETER;

echo $category;



    }



}


function add_category() {

if(isset($_POST['add_category'])) {
$cat_title = escape_string($_POST['cat_title']);

if(empty($cat_title) || $cat_title == " ") {

echo "<p class='bg-danger'>THIS CANNOT BE EMPTY</p>";


} else {


$insert_cat = query("INSERT INTO categories(cat_title) VALUES('{$cat_title}') ");
confirm($insert_cat);
set_message("Category Created");



    }


    }//ends add_category()




}

 /************************admin users***********************/



function display_users() {


$category_query = query("SELECT * FROM users");
confirm($category_query);


while($row = fetch_array($category_query)) {

$user_id = $row['user_id'];
$username = $row['username'];
$email = $row['email'];
$password = $row['password'];

$user = <<<DELIMETER


<tr>
    <td>{$user_id}</td>
    <td>{$username}</td>
     <td>{$email}</td>
    <td><a class="btn btn-danger" href="index.php?delete_user_id={$row['user_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>



DELIMETER;

echo $user;



    }



}


function add_user() {


if(isset($_POST['add_user'])) {


$username   = escape_string($_POST['username']);
$email      = escape_string($_POST['email']);
$password   = escape_string($_POST['password']);
// $user_photo = escape_string($_FILES['file']['name']);
// $photo_temp = escape_string($_FILES['file']['tmp_name']);


// move_uploaded_file($photo_temp, UPLOAD_DIRECTORY . DS . $user_photo);


$query = query("INSERT INTO users(username,email,password) VALUES('{$username}','{$email}','{$password}')");
confirm($query);

set_message("USER CREATED");

redirect("index.php?users");



}



}





function get_reports(){


$query = query(" SELECT * FROM reports");
confirm($query);

while($row = fetch_array($query)) {

    

            $report = <<<DELIMETER
 
        <tr>
           <td>{$row['report_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['report_id']}</td>
            <td>{$row['order_id']}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_title']}</td>
            <td>{$row['product_quantity']}</td>
            
            <td><a id="delete-report-button" class="btn btn-danger" href="./index.php?delete_report_id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

DELIMETER;

echo $report;
}//end while

            
}//end get_report()


//////// SLIDES ////////

function add_slides(){

    if(isset($_POST['add_slide'])) {


        $slide_title        = escape_string($_POST['slide_title']);
        $slide_image        = $_FILES['file']['name'];
        $slide_image_loc    = $_FILES['file']['tmp_name'];


        if(empty($slide_title) || empty($slide_image)) {

            echo "<p class='bg-danger'>This field cannot be empty</p>";


        } else {



            move_uploaded_file($slide_image_loc, UPLOAD_DIRECTORY . DS . $slide_image);

            $query = query("INSERT INTO slides(slide_title, slide_image) VALUES('{$slide_title}', '{$slide_image}')");
            confirm($query);
            set_message("Slide Added");
            redirect("index.php?slides");





        }


    }

}
function get_current_slide(){


}

function get_current_slide_in_admin(){

    $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    confirm($query);

    while($row = fetch_array($query)) {

        $slide_image = display_image($row['slide_image']);

        $slide_active_admin = <<<DELIMETER



    <img width='200' height='150' class="img-responsive" src="../../resources/{$slide_image}" alt="">



DELIMETER;

        echo $slide_active_admin;


    }



}


function get_active_slide(){
    $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    confirm($query);



    while($row = fetch_array($query)) {

        $slide_image = display_image($row['slide_image']);

$slide_active = <<<DELIMETER


 <div class="item active">
    <img style="height:450px" class="slide-image" src="../resources/{$slide_image}" alt="{$slide_image}">
</div>


DELIMETER;

        echo $slide_active;


    }
}

function get_slides(){

    $query = query("SELECT * FROM slides");
    confirm($query);

    while($row = fetch_array($query)) {

        $slide_image = display_image($row['slide_image']);

$slides = <<<DELIMETER
 <div class="item">
    <img style="height:450px" class="slide-image" src="../resources/{$slide_image}" alt="{$slide_image}">
</div>
DELIMETER;

        echo $slides;


    }


}
function get_slide_thumbnails(){

    $query = query("SELECT * FROM slides ORDER BY slide_id ASC ");
    confirm($query);

    while($row = fetch_array($query)) {

        $slide_image = display_image($row['slide_image']);

        $slide_thumb_admin = <<<DELIMETER


<div class="col-xs-6 col-md-3 image_container">
    
    <a href="index.php?delete_slide_id={$row['slide_id']}">
        
         <img width='200' class="img-responsive slide_image" src="../../resources/{$slide_image}" alt="{$slide_image}">

    </a>

    <div class="caption">
       <p>{$row['slide_title']}</p>
    </div>


</div>


    



DELIMETER;

        echo $slide_thumb_admin;


    }



}



?>
