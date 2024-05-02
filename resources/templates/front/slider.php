 <?php if(count_all_records('slides') > 0): ?>


<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">

        <?php get_active_slide(); ?>

        <?php get_slides(); ?>



    </div>
    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>

<?php else: ?>

    <div class="row text-center">
        <h1 >No Slides</h1>
        <p>Go and create some slides <a href="http://localhost:8888/ecom/public/admin/index.php?slides">HERE</a></p>
    </div>


<?php endif; ?>
