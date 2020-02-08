<?php

namespace Badger;

use Badger\VCard\Version;
use Pharse\Parser;
use Pharse\StringParser;
use PhatCats\LinkedList\LinkedListFactory;

/**
 * The VersionParser parses the VCard version line which has the form "VERSION:X.Y".
 */
class VersionParser extends Parser {

  private $listFactory;

  public function __construct($listFactory = null) {
    $this->listFactory = is_null($listFactory) ? new LinkedListFactory() :$listFactory;
  }

  public function parse($input) {
    $versionParser = (new StringParser("VERSION:"))->flatMap(function($ignore) {
      return NonCRLFParser::instance();
    })->map(function($versionStr) { return new Version($versionStr); });

    return $versionParser->parse($input);
  }
}
