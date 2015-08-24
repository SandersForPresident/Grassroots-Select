<?php
namespace GrassrootsSelect\Models;

class DistrictModel extends AbstractModel {
  public $number;
  public $pvi;
  public $party;
  public $state;
  public $candidates = array();

  public function __construct($post) {
    parent::__construct($post);

    $this->number = get_field('district_number', $this->post->ID);
    $this->pvi = get_field('pvi', $this->post->ID);

    $partyTerms = wp_get_post_terms($this->post->ID, 'party');
    $this->party = $partyTerms[0];

    $stateTerms = wp_get_post_terms($this->post->ID, 'state');
    $this->state = $stateTerms[0];

    $candidates = get_field('candidates', $this->post->ID);
    foreach ($candidates as $candidate) {
      $this->candidates[] = new CandidateModel($candidate);
    }
  }

  public function getPermalink() {
    return get_permalink($this->post->ID);
  }
}
