<?php
namespace GrassrootsSelect\Models;

class BillModel extends AbstractModel {
  const META_KEY_GOVTRACK_ID = 'govtrack_id';
  const META_KEY_BILL_NUMBER = 'bill_number';
  const META_KEY_BILL_TYPE = 'bill_type';
  const META_KEY_CONGRESS_NUMBER = 'congress';
  const META_KEY_IDEAL_VOTE = 'ideal_vote';

  public $govTrackID;
  public $idealVote;
  public $number;
  public $type;
  public $congress;
  public $issue;
  public $govtrackBill;

  public function __construct($post) {
    parent::__construct($post);
    $this->govTrackID = get_field(self::META_KEY_GOVTRACK_ID, $this->post->ID);
    $this->idealVote = get_field(self::META_KEY_IDEAL_VOTE, $this->post->ID);
    $this->number = get_field(self::META_KEY_BILL_NUMBER, $this->post->ID);
    $this->type = get_field(self::META_KEY_BILL_TYPE, $this->post->ID);
    $this->congress = get_field(self::META_KEY_CONGRESS_NUMBER, $this->post->ID);

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

  public function hasGovtrackFields() {
    return !empty($this->number) && !empty($this->type) && !empty($this->congress);
  }

  public function setGovtrackBill($govtrackBill) {
    $this->govtrackBill = $govtrackBill;
  }

  public function hasGovtrackModel() {
    return !empty($this->govtrackBill);
  }
}
