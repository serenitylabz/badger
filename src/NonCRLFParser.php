<?php

namespace Badger;

use Badger\Property\FN;
use Pharse\Parser;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class NonCRLFParser extends Parser {

  private $listFactory;

  public function __construct($listFactory = null) {
    $this->listFactory = is_null($listFactory) ? new LinkedListFactory() :$listFactory;
  }

  public function parse($input)  {
    $i = strpos($input, "\r\n");
    if ($i) {
      $value = substr($input, 0, $i);
      $rest = substr($input, $i);
      $tuple = new Tuple($value, $rest);
      $result = $this->listFactory->pure($tuple);
    } else {
      $result = $this->listFactory->empty();
    }

    return $result;
  }
}
