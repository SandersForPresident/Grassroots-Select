<?php
namespace GrassrootsSelect\Admin\CandidateBillsMetaBox;

function registerMetaBox () {
  add_meta_box('candidate_bills', 'Candidate Bill Voting History', __NAMESPACE__ . '\\renderMetaBox', 'candidate', 'normal');
}

function renderMetaBox () {
  echo 'yoo';
}
