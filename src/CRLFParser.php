<?php

namespace Badger;

use Pharse\Parser;
use Pharse\StringParser;

class CRLFParser extends Parser {

  public static $crlfParser;

  function parse($input) {
    return CRLFParser::$crlfParser->parse($input);
  }
}

CRLFParser::$crlfParser = new StringParser("\r\n");
