<?php
namespace GrassrootsSelect\Models;

class GovtrackBillModel {
  public function __construct($data) {
    foreach ($data as $key=>$value) {
      $this[$key] = $value;
    }
  }
}
