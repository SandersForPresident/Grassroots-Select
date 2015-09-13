<?php
namespace GrassrootsSelect\Services;
use GrassrootsSelect\Models\GovtrackBillModel;
use GrassrootsSelect\Models\BillModel;
use GovTrack;

class BillService {

  private $govtrackClient;

  public function __construct() {
    $this->govtrackClient = new GovTrack\Client();
  }

  // @TODO - Cache responses
  public function getGovtrackBill($number, $type, $congress) {
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
      return $bills[0];
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

}
