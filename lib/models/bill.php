<?php

namespace GrassrootsSelect\Models;

class BillModel extends AbstractModel {
  public $govTrackID;
  public $idealVote;

  public function __construct($post) {
    parent::__construct($post);
    $this->govTrackID = get_field('govtrack_id', $this->post->ID);
    $this->idealVote = get_field('ideal_vote', $this->post->ID);
  }
}
