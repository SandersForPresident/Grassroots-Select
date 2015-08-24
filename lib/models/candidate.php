<?php
namespace GrassrootsSelect\Models;

class CandidateModel extends AbstractModel {
  public $party;

  public function __construct($post) {
    parent::__construct($post);

    $partyTerms = wp_get_post_terms($this->post->ID, 'party');
    $this->party = $partyTerms[0];
  }
}
