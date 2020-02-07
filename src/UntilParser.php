<?php

namespace Badger;

use Badger\Property\FN;
use Pharse\Parser;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

/**
 * The UntilParser parses all input that comes before the given string.
 */
class UntilParser extends Parser {

  private $untilStr;
  private $listFactory;

  public function __construct($untilStr, $listFactory = null) {
    $this->untilStr = $untilStr;
    $this->listFactory = is_null($listFactory) ? new LinkedListFactory() :$listFactory;
  }

  public function parse($input)  {
    $i = strpos($input, $this->untilStr);
    if ($i !== FALSE) {
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
