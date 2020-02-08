<?php

namespace Badger;

use Pharse\Parser;
use Badger\UntilParser;

class NonCRLFParser extends Parser {

  private $nonCrlfParser;
  private static $instance;

  private function __construct() {
    $this->nonCrlfParser = new UntilParser("\r\n");
  }

  function parse($input) {
    return $this->nonCrlfParser->parse($input);
  }

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new NonCRLFParser();
    }

    return self::$instance;
  }
}
