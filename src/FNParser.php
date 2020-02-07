<?php

namespace Badger;

use Badger\Property\FN;
use Pharse\Parser;
use Pharse\StringParser;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class FNParser extends Parser {

  private $listFactory;

  public function __construct($listFactory = null) {
    $this->listFactory = is_null($listFactory) ? new LinkedListFactory() :$listFactory;
  }

  public function parse($input) {
    $fnPrefixParser = new StringParser("FN:");
    $fnParser = (new NonCRLFParser())->map(function($s) {
      return new FN($s);
    });

    // Now, sequence the two parsers ignoring the value of the first one ("FN:")
    $parser = $fnPrefixParser->flatMap(function($ignore) use ($fnParser) {
      return $fnParser;
    });

    return $parser->parse($input);
  }
}
