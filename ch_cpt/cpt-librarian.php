<?php

// Including all custom element files
$dir = plugin_dir_path(__FILE__) . 'cpts/';
$files = scandir($dir, 1);
foreach ($files as $file) {
	if ('.' !== $file && '..' !== $file) {
		if (is_file(plugin_dir_path(__FILE__) . 'cpts/' . $file)) {
			require_once plugin_dir_path(__FILE__) . 'cpts/' . $file;
		}
	}
}