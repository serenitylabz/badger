<?php

namespace Badger;

use Pharse\Parser;
use Pharse\ParserAlternative;

class VCardEntityParser extends Parser {

  public function parse($input) {
    return (new ParserAlternative())->oneOrMore(new VCardParser())->parse($input);
  }
}
