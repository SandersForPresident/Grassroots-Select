<?php
namespace GrassrootsSelect\Services;
use GrassrootsSelect\Models\GovtrackBillModel;
use GrassrootsSelect\Models\BillModel;
use GovTrack;

class BillService {
  const GOVTRACK_CACHE_GROUP = 'govtrack';
  const GOVTRACK_CACHE_TTL = 604800;

  private $govtrackClient;

  public function __construct() {
    $this->govtrackClient = new GovTrack\Client();
  }

  public function getGovtrackBill($number, $type, $congress) {
    if ($bill = $this->getBillFromCache($number, $type, $congress)) {
      return $bill;
    } else {
      $requestParams = array(
        'number' => $number,
        'bill_type' => $type,
        'congress' => $congress
      );
      $response = $this->govtrackClient->get('bill', $requestParams);
      $bills = $response['objects'];
      if (empty($bills)) {
        return null;
      } else {
        $bill = $bills[0];
        $this->setBillCache($number, $type, $congress, $bill);
        return $bill;
      }
    }
  }

  public function getBills() {
    $bills = array();
    $billPosts = get_posts(array(
      'post_type' => 'bill',
      'post_status' => 'publish'
    ));

    foreach ($billPosts as $billPost) {
      $bill = new BillModel($billPost);
      if ($bill->hasGovtrackFields()) {
        $govtrackBill = $this->getGovtrackBill($bill->number, $bill->type, $bill->congress);
        if (!empty($govtrackBill)) {
          $bill->setGovtrackBill($govtrackBill);
        }
      }
      $bills[] = $bill;
    }

    return $bills;
  }

  private function getBillFromCache($number, $type, $congress) {
    $key = $number . $type . $congres;
    $cache = wp_cache_get($key);
    return $cache;
  }

  private function setBillCache($number, $type, $congress, $bill) {
    $key = $number . $type . $congress;
    wp_cache_add($key, json_encode($bill));
  }
}
