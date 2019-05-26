<?php
/**
 * publish 상태인 포스팅만 페이지당 10건 가져오기
 */
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 10
);

// The Query
$query = new WP_Query($args); ?>


<?php
// The Loop
if ($query->have_posts()) : ?>

    <?php while ($query->have_posts()) : $query->the_post(); ?>
        <article class="notice__item">
            <a href="<?php the_permalink(); ?>">
                <?php
                /**
                 * 썸네일 이미지가 존재하는지 판단
                 */
                if (has_post_thumbnail()) : ?>
                    <!-- 썸네일 이미지 출력 -->
                    <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>">
                <?php else : ?>

                    <div class="default_thumbnail">이미지가 없습니다</div>

                <?php endif; ?>

                <!-- 타이틀 출력 -->
                <h2><?php the_title(); ?></h2>
                <span><?php the_date(); ?></span>
                <?php echo get_post_view(); ?>
            </a>
        </article>
    <?php endwhile; ?>

<?php else : ?>
    // no posts found
<?php endif; ?>

<!--  Restore original Post Data -->
<?php wp_reset_postdata(); ?>