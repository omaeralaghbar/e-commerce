<?php require_once("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

    <!-- Page Content -->
    <div class="container">

    <?php include(TEMPLATE_FRONT . DS . "side_nav.php") ?>

        <!-- Jumbotron Header -->
        <header>
            <h1>Gallery :</h1>
        </header>

        <hr>

        <!-- /.row -->
        <div class="col-md-8">
        <!-- Page Features -->
        <div class="row text-center">

         
         <?php get_gallery_with_pagination(); ?>

        </div>
        <!-- /.row -->

      

    </div>
    <!-- /.container -->
    </div>


<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
