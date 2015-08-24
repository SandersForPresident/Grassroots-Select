<?php
namespace GrassrootsSelect\Models\Traits;
use GrassrootsSelect\Constants\Party;

trait PoliticalParty {

  public function isDemocrat() {
    return $this->party->slug == Party::DEMOCRAT;
  }

  public function isRepublican() {
    return $this->party->slug == Party::REPUBLICAN;
  }

  public function isIndependent() {
    return $this->party->slug == Party::INDEPENDENT;
  }

  public function isLibertarian() {
    return $this->party->slug == Party::LIBERTARIAN;
  }

  public function isGreenParty() {
    return $this->party->slug == Party::GREENPARTY;
  }
}
