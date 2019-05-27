<?php
/**
 * publish 상태인 포스팅만 페이지당 10건 가져오기
 */
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 6
);

// The Query
$query = new WP_Query($args); ?>


<?php
// The Loop
if ($query->have_posts()) : ?>

    <?php while ($query->have_posts()) : $query->the_post(); ?>
        <article class="notice__item">
            <a href="<?php the_permalink(); ?>">
                <div class="thumbnail__wrapper">
                <?php
                /**
                 * 썸네일 이미지가 존재하는지 판단
                 */
                if (has_post_thumbnail()) : ?>
                    <!-- 썸네일 이미지 출력 -->
                    <img class="thumbnail" src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>">
                <?php else : ?>

                    <img class="thumbnail" src="<?php echo get_template_directory_uri(); ?>/assets/img/default_thumbnail.png"/>

                <?php endif; ?>
                </div>
                <div class="post__desc">
                <!-- 타이틀 출력 -->
                <h2 class="post__desc-title"><?php the_title(); ?></h2>
                <span class="post__desc-date"><?php the_date(); ?></span>
                <span class="post__desc-view"><?php echo get_post_view(); ?></span>
                </div>
            </a>
        </article>
    <?php endwhile; ?>

<?php else : ?>
    // no posts found
<?php endif; ?>

<!--  Restore original Post Data -->
<?php wp_reset_postdata(); ?>