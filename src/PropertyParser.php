<?php

namespace Badger;

use Badger\Property\FN;
use Badger\PropertyStringParser;
use Pharse\Parser;
use Pharse\StringParser;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

/**
 * The PropertyParser parses a single property returning an instance of a
 * sub-class of Badger\Property\Property.
 */
class PropertyParser extends Parser {

  private $listFactory;

  public function __construct($listFactory = null) {
    $this->listFactory = is_null($listFactory) ? new LinkedListFactory() :$listFactory;
  }

  public function parse($input) {
    $fnParser = (new PropertyStringParser("FN"))->map(function($s) { return new FN($s); });

    return $fnParser->parse($input);
  }
}
