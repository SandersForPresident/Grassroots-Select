<?php
namespace GrassrootsSelect\Models;

class CandidateModel extends AbstractModel {
  use Traits\PoliticalParty;

  const META_KEY_VOTING_HISTORY = 'voting_history';
  const META_KEY_BIOGUIDE_ID = 'bioguide_id';

  public $party;
  public $bioguideID;

  public function __construct($post) {
    parent::__construct($post);
    $this->votingHistory = get_field(self::META_KEY_VOTING_HISTORY, $this->post->ID);
    $this->bioguideID = get_field(self::META_KEY_BIOGUIDE_ID, $this->post->ID);
    $partyTerms = wp_get_post_terms($this->post->ID, 'party');
    $this->party = $partyTerms[0];
  }

  public function hasBioguideID () {
    return !empty($this->bioguideID);
  }
}
