<?php

namespace GrassrootsSelect;
use GrassrootsSelect\Models\DistrictModel;
use GrassrootsSelect\Models\BillModel;

class Service {

  public static function getStats () {
    return get_terms('state', array(
      'orderby' => 'name',
      'order' => 'asc',
      'hide_empty' => false
    ));
  }

  public static function getDistricts ($state) {
    // query posts by taxonomy $state
  }

  public static function getDistrictByCandidate ($candidateID) {
    $districts = get_posts(array(
      'post_type' => 'district',
      'post_status' => 'publish',
      'meta_query' => array(
        array(
          'key' => 'candidates',
          'value' => '"' . $candidateID . '"',
          'compare' => 'LIKE'
        )
      )
    ));
    foreach ($districts as $district) {
      $districtCandidates = get_field('candidates', $district->ID);
      if (empty($districtCandidates)) {
        return null;
      }
      foreach ($districtCandidates as $index=>$post) {
        if ($candidateID == $post->ID) {
          return new DistrictModel($district);
        }
      }
    }
    return null;
  }

  public static function getBills () {
    $bills = array();
    $billPosts = get_posts(array(
      'post_type' => 'bill',
      'post_status' => 'publish'
    ));

    foreach ($billPosts as $billPost) {
      $bills[] = new BillModel($billPost);
    }

    return $bills;
  }
}
