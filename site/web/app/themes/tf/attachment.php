<div class="row">
  <div class="col-sm-8">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h2><?php the_title(); ?></h2>
        <?php if ( wp_attachment_is_image() ) :
            $attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
            foreach ( $attachments as $k => $attachment ) {
                if ( $attachment->ID == $post->ID )
                    break;
            }
            $k++;
            // If there is more than 1 image attachment in a gallery
            if ( count( $attachments ) > 1 ) {
                if ( isset( $attachments[ $k ] ) )
                    // get the URL of the next image attachment
                    $next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
                else
                    // or get the URL of the first image attachment
                    $next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
            } else {
                // or, if there's only 1 image attachment, get the URL of the image
                $next_attachment_url = wp_get_attachment_url();
            }
        ?>
        <p class="attachment"><a href="<?php echo $next_attachment_url; ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php
            $attachment_width  = apply_filters( 'twentyten_attachment_size', 900 );
            $attachment_height = apply_filters( 'twentyten_attachment_height', 900 );
            echo wp_get_attachment_image( $post->ID, array( $attachment_width, $attachment_height ) ); // filterable image width with, essentially, no limit for image height.
        ?></a></p>

        <div id="nav-below" class="navigation">
            <div class="nav-previous"><?php previous_image_link( false ); ?></div>
            <div class="nav-next"><?php next_image_link( false ); ?></div>
        </div><!-- #nav-below -->
        <?php else : ?>
            <a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( sprintf( __( 'Return to %s', 'twentyten' ), strip_tags( get_the_title( $post->post_parent ) ) ) ); ?>" rel="gallery" class="button"><span>Download File</span></a>
        <?php endif; ?>
        <?php endwhile;
    endif; ?>
  </div>
  <div class="col-sm-4 right-sidebar">
    <div class="inner">
    <?php
      get_sidebar('blog');
    ?>
    </div>
  </div>
</div>
