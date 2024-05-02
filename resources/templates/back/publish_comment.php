<?php require_once("../../resources/config.php");


if(isset($_GET['publish_comment_id'])) {


$query = query("UPDATE comments SET status = 'published' WHERE id = " . escape_string($_GET['publish_comment_id']) . " ");
confirm($query);


set_message("Comment Published");
redirect("index.php?comments");


} else {

redirect("index.php?comments");


}






 ?>