<?php
function ch_cpt_teammembers() {

	// Register the post type
	$labels = array(
		'name' => __('Team'),
		'singular_name' => __('Team Member'),
		'add_new' => __('Add New Team Member'),
		'add_new_item' => __('Add New Team Member'),
		'edit_item' => __('Edit Team Member'),
		'new_item' => __('New Team Member'),
		'view_item' => __('View Team Member'),
		'search_items' => __('Search Team Member'),
		'not_found' => __('No Team Member found'),
		'not_found_in_trash' => __('No Team Member found in Trash'),
		'parent_item_colon' => __('Parent Team:'),
		'menu_name' => __('Team Members'),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'description' => 'List Team Members',
		'supports' => array('title', 'thumbnail'),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'taxonomies' => array('category_team_members'),
		'show_in_nav_menus' => false,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => array('slug' => 'team-members'),
		'capability_type' => 'post',
		'register_meta_box_cb' => 'team_members_metaboxes'
	);

	register_post_type('team_members', $args);

	// Register the taxonomy
	$clabels = array(
		'name' => __('Staff Categories', "wpoframework"),
		'singular_name' => __('Category', "wpoframework"),
		'search_items' => __('Search Category', "wpoframework"),
		'all_items' => __('All Categories', "wpoframework"),
		'parent_item' => __('Parent Category', "wpoframework"),
		'parent_item_colon' => __('Parent Category:', "wpoframework"),
		'edit_item' => __('Edit Category', "wpoframework"),
		'update_item' => __('Update Category', "wpoframework"),
		'add_new_item' => __('Add New Category', "wpoframework"),
		'new_item_name' => __('New Category Name', "wpoframework"),
		'menu_name' => __('Categories', "wpoframework"),
	);

	$cargs = array(
		'hierarchical' => true,
		'labels' => $clabels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'show_in_nav_menus' => true,
		'rewrite' => array('slug' => 'team-member-category')
	);

	register_taxonomy('category_team_members', array('team_members'), $cargs);

}

add_action('init', 'ch_cpt_teammembers');


// Add metaboxes
function team_members_metaboxes() {
	add_meta_box('ch_tm_talktitle', 'Talk Title', 'ch_tm_talktitle', 'team_members', 'normal', 'default');
	add_meta_box('ch_tm_twitter', 'Twitter Username', 'ch_tm_twitter', 'team_members', 'normal', 'default');
}

// Talk Title metabox

function ch_tm_talktitle() {
	global $post;

	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="teammember_meta_nonce" id="teammember_meta_nonce" value="' .
		wp_create_nonce(plugin_basename(__FILE__)) . '" />';

	// Get the location data if its already been entered
	$talktitle = get_post_meta($post->ID, '_talktitle', true);

	// Echo out the field
	echo '<input type="text" name="_talktitle" value="' . $talktitle . '" style="width:100%;" />';

}

// Twitter Username metabox

function ch_tm_twitter() {
	global $post;

	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="teammember_meta_nonce" id="teammember_meta_nonce" value="' .
		wp_create_nonce(plugin_basename(__FILE__)) . '" />';

	// Get the location data if its already been entered
	$twitteruname = get_post_meta($post->ID, '_twitter', true);

	// Echo out the field
	echo '<input type="text" name="_twitter" value="' . $twitteruname . '" />';

}



// Save the Metabox Data

function ch_save_teacher_meta($post_id, $post) {

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if (!wp_verify_nonce($_POST['teammember_meta_nonce'], plugin_basename(__FILE__))) {
		return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if (!current_user_can('edit_post', $post->ID))
		return $post->ID;


	$tm_meta['_talktitle'] = $_POST['_talktitle'];
	$tm_meta['_twitter'] = $_POST['_twitter'];


	// Add values
	foreach ($tm_meta as $key => $value) {
		if ($post->post_type == 'revision') return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if (get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if (!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}

}

// save the custom fields
add_action('save_post', 'ch_save_teacher_meta', 1, 2);