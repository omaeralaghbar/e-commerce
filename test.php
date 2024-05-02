//decreasing from database
        $query = query("UPDATE products SET product_quantity = GREATEST (0 , product_quantity - ".$_SESSION['product_' . $_GET['add']].") WHERE product_id = ".$_GET['add']." ");
		confirm($query);

		