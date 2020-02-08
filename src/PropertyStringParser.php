<?php

namespace Badger;

use Badger\Property\FN;
use Badger\NonCRLFParser;
use Pharse\Parser;
use Pharse\StringParser;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

/**
 * The PropertyStringParser parses the string value of the field with the given
 * name.
 * Note that it returns the string value; you'll have to call 'map' to wrap it
 * in a Property object.
 */
class PropertyStringParser extends Parser {

  private $listFactory;
  private $propertyName;
  public static $nonCrlfParser;

  public function __construct($propertyName, $listFactory = null) {
    $this->listFactory = is_null($listFactory) ? new LinkedListFactory() :$listFactory;
    $this->propertyName = $propertyName;
  }

  public function parse($input) {
    $propertyPrefix = $this->propertyName . ":";
    $prefixParser = new StringParser($propertyPrefix);

    // Now, sequence the prefixParser with the clrfParser ignoring the parsed
    // prefix.
    $parser = $prefixParser->flatMap(function($ignore) {
      return PropertyStringParser::$nonCrlfParser;
    });

    return $parser->parse($input);
  }
}

PropertyStringParser::$nonCrlfParser = new NonCRLFParser();
