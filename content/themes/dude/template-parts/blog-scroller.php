<?php

if( is_singular( 'service' ) ):
  $cat = get_post_meta( get_the_id(), '_blog_category', true );
  $title = get_post_meta( get_the_id(), '_blog_title', true );
elseif( is_page_template( 'template-dude.php' ) ):
  $cat = get_post_meta( get_the_id(), '_blog_category', true );
  $title = get_post_meta( get_the_id(), '_blog_title', true );
else:
  $cat = null;
  $title = get_post_meta( get_the_id(), '_fp_blog_title', true );
endif; ?>

<div id="blog-scroller" class="slide slide-blogposts">
  <div class="shade"></div>

  <?php if( !empty( $title ) ): ?>
    <h2><?php echo $title ?></h2>
  <?php endif; ?>

  <div class="blogposts slider" data-rest-paged="2" data-rest-cat="<?php echo $cat ?>">

    <?php $the_query = new WP_Query( array(
      'post_type'       => 'post',
      'no_found_rows'   => true,
      'cat'             => $cat,
    ) );

    if ( $the_query->have_posts() ) :

      while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

      <div id="post-<?php echo get_the_id() ?>" class="blogpost" data-background="<?php echo esc_url( wp_get_attachment_image_src( get_post_thumbnail_id(), 'blog-scroller-bg' )[0] ); ?>">
        <a class="link-to-post" href="<?php echo get_the_permalink(); ?>" aria-label="<?php echo esc_html_e('Linkki artikkeliin ', 'dude'); the_title(); ?>"></a>
        <header class="blogpost-featured-image"<?php if ( has_post_thumbnail() ) : ?> style="background-image:url('<?php echo esc_url( wp_get_attachment_image_src( get_post_thumbnail_id(), 'blog-scroller-bg' )[0] ); ?>');"<?php endif; ?>>
          <div class="shade-small"></div>          
          <p class="likes"><?php echo file_get_contents( get_theme_file_path( 'svg/likes.svg' ) ); echo dude_get_post_likes( get_the_id() ); ?></p>
        </header>

        <div class="blogpost-content">
          <h3><?php the_title(); ?></h3>

          <?php $excerpt = get_post_meta( get_the_id(), '_scroller_excerpt', true );
          if( empty( $excerpt ) ) {
            $sentence = preg_match('/^([^.!?]*[\.!?]+){0,1}/', strip_tags( get_the_content() ), $summary);
            $excerpt = strip_shortcodes( $summary[0] );
          }

          echo wpautop( $excerpt ); ?>

          <div class="blogpost-meta">

              <h4 class="time"><time class="entry-time" datetime="<?php get_the_time('c'); ?>"><?php echo ucfirst(get_the_time('j.n.Y')) ?></time></h4>

              <div class="avatar" style="background-image: url('<?php if ( function_exists('get_avatar_url') ) : echo get_avatar_url( get_the_author_meta('email'), '42' ); endif; ?>');"></div>

              <p class="author"><?php echo get_the_author_meta('first_name'); ?> <?php echo get_the_author_meta('last_name'); ?></p>

          </div>
        </div>
      </div>

      <?php endwhile; wp_reset_postdata(); ?>

      <div style="display:none;" v-bind:id="'hiddenpost-' + post.post_id" v-for="(post, index) in posts">
        <div class="blogpost" v-bind:id="'post-' + post.post_id" v-bind:data-background="post.thumb_url">
          <a class="link-to-post" v-bind:href="post.permalink" aria-label="<?php echo esc_html_e('Linkki artikkeliin', 'dude'); ?> {{ post.title }}"></a>
          <header class="blogpost-featured-image" v-bind:style="{ backgroundImage: 'url(' + post.thumb_url + ')' }">
            <div class="shade-small"></div>            
            <p class="likes"><?php echo file_get_contents( get_theme_file_path( 'svg/likes.svg' ) ) ?> {{ post.likes }}</p>
          </header>
          <div class="blogpost-content">
            <h3>{{ post.title }}</h3>
            <p v-if="post.excerpt">{{ post.excerpt }}</p>
          </div>
          <div class="blogpost-meta">
              <h4 class="time"><time class="entry-time" v-bind:datetime="post.datetime">{{ post.time }}</time></h4>
              <div class="avatar" v-bind:style="{ backgroundImage: 'url(' + post.author.avatar + ')' }"></div>
              <p class="author">{{ post.author.name }}</p>
          </div>
        </div>
      </div>

    <?php else : ?>
      <p><?php _e( 'Darm, artikkeleita ei löytynyt', 'dude' ); ?></p>
    <?php endif; ?>

  </div><!-- .blogposts -->

  <div class="last-card-holder" style="display:none;">
    <div class="blogpost last-card">
      <div class="content">
        <?php echo file_get_contents( get_theme_file_path( 'svg/neckbeard.svg' ) ) ?>
        <h3><?php _e( 'Meillä ei ole enää annettavaa', 'dude' ) ?></h3>
        <p><?php _e( 'Selasit puljun historian loppuun, sori :S', 'dude' ) ?></p>
      </div>
    </div>
  </div>

</div><!-- .slide-blogposts -->
