<?php

function chvce_team_members() {
	vc_map(
		array(
			'base' => 'chvce_team_members',
			'name' => __('Team Members', 'chvce'),
			'description' => __('Display team members from team members cpt', 'chvce'),
			'category' => __('CreaHive', 'chvce'),
			'icon' => plugin_dir_url(__DIR__) . 'assets/img/team-members.png',
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Title', 'chvce'),
					'param_name' => 'title',
					'value' => __(''),
					'description' => __('Team Members section title', 'chvce'),
				),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Style', 'chvce'),
					'param_name' => 'style',
					'value' => array(
						__('version 1', 'chvce') => 'version 1',
						__('version 2', 'chvce') => 'version 2'
					),
					'std' => 'version 1',
					'description' => __('Team Members section style', 'chvce'),
				)
			)
		)
	);
}
add_action('vc_before_init', 'chvce_team_members');

function chvce_team_members_template($atts) {
	extract(
		shortcode_atts(
			array(
				'title' => '',
				'style' => 'version 1'
			),
			$atts
		)
	);

	switch ($style) {
		case 'version 1':
			require_once plugin_dir_path(__DIR__) . 'templates/team-members-v1.php';
			break;
		case 'version 2':
			require_once plugin_dir_path(__DIR__) . 'templates/team-members-v2.php';
			break;
	}
}
add_shortcode('chvce_team_members', 'chvce_team_members_template');