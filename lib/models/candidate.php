<?php
namespace GrassrootsSelect\Models;

class CandidateModel extends AbstractModel {
  use Traits\PoliticalParty;

  public $party;
  public $bioguideID;

  public function __construct($post) {
    parent::__construct($post);

    $partyTerms = wp_get_post_terms($this->post->ID, 'party');
    $this->party = $partyTerms[0];

    $this->bioguideID = get_field('bioguide_id', $this->post->ID);
  }

  public function hasBioguideID () {
    return !empty($this->bioguideID);
  }
}
