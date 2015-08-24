<?php
namespace GrassrootsSelect\Models;

class District {
  public $post;
  public $number;
  public $pvi;
  public $party;
  public $state;

  public function __construct($post) {
    if (is_object($post)) {
      $this->post = $post;
    } else {
      $this->post = get_post($post);
    }

    $this->number = get_field('district_number', $this->post->ID);
    $this->pvi = get_field('pvi', $this->post->ID);
    $this->candidates = get_field('candidate', $this->post->ID);

    $partyTerms = wp_get_post_terms($this->post->ID, 'party');
    $this->party = $partyTerms[0];

    $stateTerms = wp_get_post_terms($this->post->ID, 'state');
    $this->state = $stateTerms[0];
  }
}
