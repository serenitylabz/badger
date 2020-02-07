<?php

namespace Badger;

use Badger\Property\FN;
use Pharse\Parser;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class FNParser extends Parser {

  private $listFactory;

  public function __construct($listFactory = null) {
    $this->listFactory = is_null($listFactory) ? new LinkedListFactory() :$listFactory;
  }

  public function parse($input) {
    $prefix = strtolower(substr($input, 0, 3));
    if ($prefix == "fn:") {
      $s = substr($input, 3);
      $i = strpos($s, "\r\n");
      if ($i) {
        $fn = substr($s, 0, $i);
        $rest = substr($s, $i);
        $tuple = new Tuple(new FN($fn), $rest);
        $result = $this->listFactory->pure($tuple);
      } else {
        $result = $this->listFactory->empty();
      }
    } else {
      $result = $this->listFactory->empty();
    }
    return $result;
  }
}
