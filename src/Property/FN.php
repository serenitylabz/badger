<?php

namespace Badger\Property;

class FN extends Property {

  private $val;

  public function __construct($v) {
    $this->val = $v;
  }
}
