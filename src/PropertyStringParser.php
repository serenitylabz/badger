<?php

namespace Badger;

use Badger\Property\FN;
use Badger\CRLFParser;
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

  public function __construct($propertyName, $listFactory = null) {
    parent::__construct();
    $this->listFactory = is_null($listFactory) ? new LinkedListFactory() :$listFactory;
    $this->propertyName = $propertyName;
  }

  public function parse($input) {
    $propertyPrefix = $this->propertyName . ":";
    $prefixParser = new StringParser($propertyPrefix);

    // Now, sequence the prefixParser with the clrfParser ignoring the parsed
    // prefix.
    $propertyStringParserSansCRLF = $prefixParser->flatMap(function($ignore) {
      return NonCRLFParser::instance();
    });

    // Finally, create a parser that parses the property string, parses the
    // following CRLF and then returns the parsed property string together with
    // the rest of the input.
    return $propertyStringParserSansCRLF->parse($input)->flatMap(function($tuple) {
      $propStr = $tuple->first();
      $rest = $tuple->second();

      $crlfParseResult = CRLFParser::$crlfParser->parse($rest);

      return $crlfParseResult->map(function($tuple) use ($propStr) {
        $rest = $tuple->second();
        return new Tuple($propStr, $rest);
      });
    });
  }
}
