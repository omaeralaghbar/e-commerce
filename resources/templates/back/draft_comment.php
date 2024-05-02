<?php require_once("../../resources/config.php");


if(isset($_GET['draft_comment_id'])) {


$query = query("UPDATE comments SET status = 'draft' WHERE id = " . escape_string($_GET['draft_comment_id']) . " ");
confirm($query);


set_message("Comment drafted");
redirect("index.php?comments");


} else {

redirect("index.php?comments");


}






 ?>