<div class="outer-row">
    <div id="hero-wrapper" class="hero">
        <div class="hero--image">
            <img src="<?php the_field( 'hero_image' ); ?>" alt="Find Your DO">
        </div> <!--  .img-wrapper -->
        <div class="hero--band">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 hero--message">
                        <?php the_field( 'hero_message' ); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 hero--title">
                        FIND YOUR DO
                    </div>
                    <div class="col-md-9 hero--form">
                        <form id="findYourDo" action="">
                            <div class="hero--form--inner">
                                <div class="row">
                                    <div class="col-sm-6 specialty">
                                        <input id="specialty" name="q" type="text" placeholder="Name or Specialty">
                                    </div>
                                    <div class="col-sm-6 location">
                                        <input id="location" name="location" type="text" placeholder="City, State or Zip">
                                    </div>
                                </div>
                            </div> <!-- .hero--form--inner -->
                            <span class="hero--form--button">
                                <button>GO <i class="fa fa-angle-double-right"></i></button>
                            </span>
                        </form>
                    </div>
                </div>
            </div> <!--  .container-fluid -->
        </div> <!--  .band -->
    </div> <!--  .hero -->
</div> <!--  .outer-row -->
