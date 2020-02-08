<?php

namespace Badger;

use Pharse\Parser;
use Badger\UntilParser;

class NonCRLFParser extends Parser {

  public static $nonCrlfParser;

  function parse($input) {
    return NonCRLFParser::$nonCrlfParser->parse($input);
  }
}

NonCRLFParser::$nonCrlfParser = new UntilParser("\r\n");
