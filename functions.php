<?php

$includes = array(
  'lib/init.php',
  'lib/tables.php',
  'lib/taxonomy_dropdown_metabox.php',
  'lib/models/district.php'
);
foreach ($includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf('Error locating %s for inclusion', $file), E_USER_ERROR);
  }
  require_once($filepath);
}
unset($file, $filepath);
