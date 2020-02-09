<?php

namespace Badger;

use Badger\VCard\Version;
use Pharse\Parser;
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
    $versionParser = (new PropertyStringParser("VERSION"))->map(function($versionStr) {
      return new Version($versionStr);
    });

    return $versionParser->parse($input);
  }
}
