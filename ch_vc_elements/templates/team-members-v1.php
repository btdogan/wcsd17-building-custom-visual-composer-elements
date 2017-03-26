<?php
wp_enqueue_style('ch_team_members_v1', plugin_dir_url(__DIR__) . 'assets/css/team-members-v1.css');

$args = array(
	'post_type' => 'team_members',
	'posts_per_page' => -1,
	'order' => 'DSC'
);

$query = new WP_Query($args);
?>
<div class="widget tab-theme" id="team-members">
    <div class="widget-content">
        <div class="section-title">
            <h2><?php echo $title; ?></h2>
        </div>
		<?php if ($query->have_posts()) : ?>
        <div class="row">
            <div class="team-members">
				<?php
				while ($query->have_posts()) :
					$query->the_post();
					$item_classes = '';
					$item_cats = get_the_terms($post->ID, 'category_team_members');
					foreach ((array)$item_cats as $item_cat) {
						if (count($item_cat) > 0) {
							$item_classes .= $item_cat->slug . ' ';
						}
					}
					?>
                    <div class="team-member col-sm-4 <?php echo esc_attr($item_classes); ?>all">
                        <div class="team-member-picture">
                            <a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail('full'); ?>
                            </a>
                        </div>
                        <div class="team-member-metabox">
                            <h3 class="team-member-name">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <ul class="team-member-meta">
                                <li class="talktitle"><?php echo get_post_meta(get_the_ID(), '_talktitle')[0]; ?></li>
                                <li class="twitteru"><?php echo get_post_meta(get_the_ID(), '_twitter')[0]; ?></li>
                            </ul>
                        </div>
                    </div>
				<?php endwhile;
				endif;
				?>
            </div>
        </div>
		<?php wp_reset_postdata(); ?>
    </div>
</div>
