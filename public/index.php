<?php require_once("../resources/config.php"); ?>

<!--HEADER-->
<?php include(TEMPLATE_FRONT.DS."header.php") ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!--SIDE_NAV-->
<?php include(TEMPLATE_FRONT.DS."side_nav.php") ?>

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
            <!--SLIDER-->
<?php include(TEMPLATE_FRONT.DS."slider.php") ?>
                    </div>

                </div>

                <div class="row">

                

                <?php get_products_with_pagination(); ?>
                   
                </div><!--ROW end here-->

            </div>

        </div>

    </div>
    <!-- /.container -->

    <!--FOOTER-->
<?php include(TEMPLATE_FRONT.DS."footer.php") ?>