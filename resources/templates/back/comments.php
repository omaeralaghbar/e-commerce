
 <div class="col-md-12">
<div class="row">
<h1 class="page-header">
   All Comments

</h1>

<h4 class= "bg-success"><?php display_message(); ?></h4>
</div>

<div class="row">
<table class="table table-hover">
    <thead>

      <tr>
           <th>id</th>
           <th>Product_Id</th>
           <th>Author</th>
           <th>E-Mail</th>
           <th>Title</th>
           <th>Comment</th>
   
      </tr>
    </thead>
    <tbody>
        <?php display_comments(); ?>

    </tbody>
</table>
</div>