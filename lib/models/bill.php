<?php

namespace GrassrootsSelect\Models;

class BillModel extends AbstractModel {
  public $govTrackID;
  public $idealVote;
  public $issue;

  public function __construct($post) {
    parent::__construct($post);
    $this->govTrackID = get_field('govtrack_id', $this->post->ID);
    $this->idealVote = get_field('ideal_vote', $this->post->ID);

    $issues = wp_get_post_terms($this->post->ID, 'issue');
    $this->issue = $issues[0];
  }

  public function getIssueTitle() {
    if (empty($this->issue)) {
      return null;
    } else {
      return $this->issue->name;
    }
  }
}
