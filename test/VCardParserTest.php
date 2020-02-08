<?php

namespace Pharse\Test;

use PHPUnit\Framework\TestCase;
use Badger\VCardParser;
use Badger\PropertyParser;
use Badger\UntilParser;
use Badger\VCard\Property\FN;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;


class VCardParserTest extends TestCase {

  protected $listFactory;
  protected $propertyParser;

  public function setUp() {
    $this->listFactory = new LinkedListFactory();
    $this->propertyParser = new PropertyParser();
  }

  public function testVCardParser() {
    $this->expectException(\Exception::class);

    $vcardParser = new VCardParser();
    $vcardParser->parse("");
  }

  public function testParseFN() {
    $result = $this->propertyParser->parse("FN:Mr. John Q. Public\, Esq.\r\n");
    $expected = $this->listFactory->pure(
      new Tuple(
        new FN("Mr. John Q. Public\, Esq."),
        "\r\n"
      )
    );

    $this->assertEquals($expected, $result);
  }

  public function testUntilParser1() {
    $parser = new UntilParser("c", $this->listFactory);
    $result = $parser->parse("abc");
    $expected = $this->listFactory->pure(
      new Tuple("ab", "c")
    );

    $this->assertEquals($expected, $result);
  }

  public function testUntilParser2() {
    $parser = new UntilParser("c", $this->listFactory);
    $result = $parser->parse("abd");
    $expected = $this->listFactory->empty();

    $this->assertEquals($expected, $result);
  }

  public function testUntilParser3() {
    $parser = new UntilParser("c", $this->listFactory);
    $result = $parser->parse("cab");
    $expected = $this->listFactory->pure(
      new Tuple("", "cab")
    );

    $this->assertEquals($expected, $result);
  }
}
