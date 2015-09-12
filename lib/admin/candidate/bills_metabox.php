<?php
namespace GrassrootsSelect\Admin\CandidateBillsMetaBox;
use GrassrootsSelect\Service;

function registerMetaBox () {
  add_meta_box('candidate_bills', 'Bill Voting History', __NAMESPACE__ . '\\renderMetaBox', 'candidate', 'normal', 'high');
}

function renderMetaBox () {
  $bills = Service::getBills();
  include(__DIR__ . '/bills_metabox_view.php');
}
