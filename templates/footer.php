<footer class="content-info" role="contentinfo">
  <div class="container">
    <div class="row" data-animated="fadeInUp"><!-- ROW -->

        <div class="col-lg-7 col-md-8 col-sm-8">

            <!-- FOOTER MENU -->
            <?php
              if (has_nav_menu('footer_navigation')) :
                wp_nav_menu(array('theme_location' => 'footer_navigation', 'menu_class' => 'foot_menu'));
              endif;
            ?>

            <hr>

            <!-- FOOTER INFO -->
            <ul class="foot_info">
              <?php
                $address = get_theme_mod( 'map' );
                $phone = get_theme_mod( 'phone' );
                $email = get_theme_mod( 'email' );
                if ( $address ) { echo '<li><i class="icon ff-map-pin"></i> '.$address.'</li>'; };
                if ( $phone ) { echo '<li><i class="icon ff-phone"></i> '.$phone.'</li>'; };
                if ( $email ) { echo '<li><i class="icon ff-envelope"></i> '.$email.'</li>'; };
              ?>
            </ul><!-- FOOTER INFO -->
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 pull-right foot_social_block">
          <span><?php echo get_theme_mod( 'lang' ); ?>:</span> <a href="http://designderena.com">LT</a> | <a href="http://designderena.com/ru">RU</a> | <a href="http://designderena.com/en">EN</a>
            <hr>
            <div class="social">
              <?php
                $facebook = get_theme_mod( 'facebook' );
                $twitter = get_theme_mod( 'twitter' );
                $googleplus = get_theme_mod( 'googleplus' );
                if ( $facebook ) { echo '<a href="'.$facebook.'"><i class="icon ff-facebook"></i></a>'; };
                if ( $twitter ) { echo '<a href="'.$twitter.'"><i class="icon ff-twitter"></i></a>'; };
                if ( $googleplus ) { echo '<a href="'.$googleplus.'"><i class="icon ff-googleplus"></i></a>'; };
              ?>
            </div>
        </div>
    </div><!-- //ROW -->
  </div><!-- //CONTAINER -->

  <div class="copyright clearfix"><!-- COPYRIGHT -->
    <div class="container">
      <?php
        $copy = get_theme_mod( 'copy' );
        $blog_title = get_bloginfo('name');
        $blog_url = get_bloginfo('url');
        echo '<a class="copyright_logo" href="'.$blog_url.'" alt="'.$blog_title.'">'.$blog_title.'</a> <span> '.copyright().' '.$copy.'</span>';
      ?>
    </div><!-- //CONTAINER -->
  </div> <!-- //COPYRIGHT -->
</footer>

