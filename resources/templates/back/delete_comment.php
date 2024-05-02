<?php require_once("../../resources/config.php");


if(isset($_GET['delete_comment_id'])) {


$query = query("DELETE FROM comments WHERE id = " . escape_string($_GET['delete_comment_id']) . " ");
confirm($query);


set_message("Comment Deleted");
redirect("index.php?comments");


} else {

redirect("index.php?comments");


}






 ?>