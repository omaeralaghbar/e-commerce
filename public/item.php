<?php require_once("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<?php get_comments_in_item(); ?>
    <!-- Page Content -->
<div class="container">

       <!-- Side Navigation -->

              <?php include(TEMPLATE_FRONT . DS . "side_nav.php") ?>

<?php 


$query = query(" SELECT * FROM products WHERE product_id = " . escape_string($_GET['id']) . " ");
confirm($query);

while($row = fetch_array($query)):


 ?>


<div class="col-md-9">

<!--Row For Image and Short Description-->

<div class="row">

    <div class="col-md-7">


       <img class="img-responsive" src="../resources/<?php  echo display_image($row['product_image']); ?>" alt="">


    </div>

    <div class="col-md-5">

        <div class="thumbnail">
         

    <div class="caption-full">
        <h4><a href="#"><?php echo $row['product_title']; ?></a> </h4>
        <hr>
        <h4 class=""><?php echo "&#36;" . $row['product_price']; ?></h4>

    
          
        <p><?php echo $row['short_desc']; ?></p>

   
    <form action="">
        <div class="form-group">
           <a href="../resources/cart.php?add=<?php echo $row['product_id']; ?>" class="btn btn-primary">ADD</a>
        </div>
    </form>

    </div>
 
</div>

</div>


</div><!--Row For Image and Short Description-->


        <hr>


<!--Row for Tab Panel-->

<div class="row">

<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Reviews</a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">

<p></p>

<p><?php echo $row['product_description']; ?></p>
<?php endwhile; ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">

  <div class="col-md-6">

       <h3>Reviews From </h3>

        <hr>

        <?php
            

            /*SELECT products.product_id , comments.comment , comments.author , comments.date 
            , comments.title FROM products INNER JOIN comments ON products.product_id = comments.product_id;*/
            
            /*$query = query(" SELECT products.product_id , products.product_description , comments.comment 
            , comments.author , comments.date , comments.status , 
            comments.title FROM products INNER JOIN comments ON products.product_id = comments.product_id  ");*/
            $query = query("SELECT * FROM comments WHERE product_id = " . escape_string($_GET['id']) . " ");
            confirm($query);
            //while($row = fetch_array($query)){
            while($row = fetch_array($query)):
            if($row['status'] !== 'draft'){
                $com = <<<DELIMETER
               <div class="row">
            <div class="col-md-12">
                
                <span class="pull-right">{$row['date']}</span>

                <p>{$row['comment']}</p>
            </div>
        </div> 
           
DELIMETER;
echo $com;
            }

           
        ?>

        <?php endwhile; ?>

        <hr>

       

        

    </div>


    <div class="col-md-6">
        <h3>Add A review</h3>

     <form action="" class="form-inline"  method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="">Name</label>
            <input name="author" type="text" class="form-control" required>
        </div>
        <hr>
        <div class="form-group">
            <label for="">Email</label>
            <input name="email" type="text" class="form-control"  required>
        </div>

        <hr>
        <div class="form-group">
            <label for="">title</label>
            <input name="title" type="text" class="form-control"  required>
        </div>

        <hr>

            <br>
            
             <div class="form-group">
             <textarea name="comment" id="" cols="60" rows="10" class="form-control"></textarea>
            </div>

             <br>
              <br>
            <div class="form-group">
                <input name="submit" type="submit" class="btn btn-primary" value="submit">
            </div>
        </form>

    </div>

 </div>

 </div>

</div>


</div><!--Row for Tab Panel-->




</div><!-- col-md-9 ends here -->




</div>
    <!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>