<?php

namespace Badger;

use Pharse\Parser;
use Pharse\StringParser;
use Pharse\ParserAlternative;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;
use Badger\VCard\VCard;

class VCardParser extends Parser {

  private $listFactory;

  public function __construct($listFactory = null) {
    $this->listFactory = is_null($listFactory) ? new LinkedListFactory() :$listFactory;
  }

  public function parse($input) {
    // create a parser for "BEGIN:VCARD"
    $beginParser = (new StringParser("BEGIN:VCARD"))->flatMap(function($ignore) {
      return CRLFParser::$crlfParser;
    });

    // create a parser for "END:VCARD"
    $endParser = (new StringParser("END:VCARD"))->flatMap(function($ignore) {
      return CRLFParser::$crlfParser;
    });

    // parse the version
    $versionResult = $beginParser->parse($input)->flatMap(function($tuple) {
      $rest = $tuple->second();
      return (new VersionParser())->parse($rest);
    });

    // parse all the properties and create a vcard parse result
    $vcardResult = $versionResult->flatMap(function($tuple) use ($endParser) {
      $version = $tuple->first();
      $rest = $tuple->second();

      // construct a parser to parse all the properties
      $parserAlternative = new ParserAlternative();
      $propertyParser = $parserAlternative->oneOrMore(new PropertyParser());

      // parse the properties
      $propertyResult = $propertyParser->parse($rest);

      // extract the properties and, along with the version, construct a vcard
      $vcardResult = $propertyResult->map(function($tuple) use ($version) {
        $properties = $tuple->first();
        $rest = $tuple->second();
        $vcard = new VCard($version, $properties);

        return new Tuple($vcard, $rest);
      });

      // finally, parse and discard "END:VCARD"
      return $vcardResult->flatMap(function($tuple) use ($endParser) {
        $vcard = $tuple->first();
        $rest = $tuple->second();

        return $endParser->parse($rest)->flatMap(function($tuple) use ($vcard) {
          $rest = $tuple->second();
          if ($rest == "") { // after parsing "END:VCARD", there should be nothing left to parse.
            $result = $this->listFactory->pure(new Tuple($vcard, ""));
          } else {  // if there's anything left to parse, it's an error.
            $result = $this->listFactory->empty();
          }

          return $result;
        });
      });
    });

    return $vcardResult;
  }
}
