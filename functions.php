<?php

$includes = array(
  'vendor/autoload.php',
  'lib/init.php',
  'lib/tables.php',
  'lib/service.php',
  'lib/taxonomy_dropdown_metabox.php',
  'lib/constants/party.php',
  'lib/models/traits/political_party.php',
  'lib/models/abstract.php',
  'lib/models/district.php',
  'lib/models/candidate.php',
  'lib/models/bill.php',
  'lib/models/govtrack_bill.php',
  'lib/services/bills.php',
  'lib/admin/candidate/bills_metabox.php'
);
foreach ($includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf('Error locating %s for inclusion', $file), E_USER_ERROR);
  }
  require_once($filepath);
}
unset($file, $filepath);
