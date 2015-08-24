<?php
namespace GrassrootsSelect\Models;

class DistrictModel extends AbstractModel {
  public $post;
  public $number;
  public $pvi;
  public $party;
  public $state;
  public $candidates;

  public function __construct($post) {
    parent::__construct($post);

    $this->number = get_field('district_number', $this->post->ID);
    $this->pvi = get_field('pvi', $this->post->ID);
    $this->candidates = get_field('candidates', $this->post->ID);

    $partyTerms = wp_get_post_terms($this->post->ID, 'party');
    $this->party = $partyTerms[0];

    $stateTerms = wp_get_post_terms($this->post->ID, 'state');
    $this->state = $stateTerms[0];
  }

  public function getPermalink() {
    return get_permalink($this->post->ID);
  }
}
