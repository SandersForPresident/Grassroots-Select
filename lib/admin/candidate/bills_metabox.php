<?php
namespace GrassrootsSelect\Admin\CandidateBillsMetaBox;
use GrassrootsSelect\Service;
use GrassrootsSelect\Models\CandidateModel;

function registerMetaBox() {
  add_meta_box('candidate_bills', 'Bill Voting History', __NAMESPACE__ . '\\renderMetaBox', 'candidate', 'normal', 'high');
}

function renderMetaBox($candidate) {
  $bills = Service::getBills();
  $votingHistory = get_field(CandidateModel::META_KEY_VOTING_HISTORY, $candidate->ID);
  include(__DIR__ . '/bills_metabox_view.php');
}

function save($postId, $post) {

  if (!wp_verify_nonce($_POST['candidate_bill_nonce'], 'candidate_bill_nonce')) {
    return $post->ID;
  }

  if (!current_user_can('edit_post', $post->ID)) {
    return $post->ID;
  }

  $billVotes = $_POST['bill'];
  if (!add_post_meta($post->ID, CandidateModel::META_KEY_VOTING_HISTORY, $billVotes, true)) {
    update_post_meta($post->ID, CandidateModel::META_KEY_VOTING_HISTORY, $billVotes);
  }
}

add_action('save_post', __NAMESPACE__ . '\\save', 10, 2);
