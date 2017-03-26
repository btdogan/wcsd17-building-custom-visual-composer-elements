<?php

// Including all custom element files
$dir = plugin_dir_path(__FILE__) . 'elements/';
$files = scandir($dir, 1);
foreach ($files as $file) {
	if ('.' !== $file && '..' !== $file) {
		if (is_file($dir . $file)) {
			require_once $dir . $file;
		}
	}
}