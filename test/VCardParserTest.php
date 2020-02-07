<?php

namespace Pharse\Test;

use PHPUnit\Framework\TestCase;
use Badger\VCardParser;
use Badger\FNParser;
use Badger\Property\FN;
use PhatCats\LinkedList\LinkedListFactory;

class VCardParserTest extends TestCase {

  protected $listFactory;

  public function setUp() {
    $this->listFactory = new LinkedListFactory();
  }

  public function testVCardParser() {
    $this->expectException(\Exception::class);

    $vcardParser = new VCardParser();
    $vcardParser->parse("");
  }

  public function testFNParser() {
    $fnParser = new FNParser();
    $result = $fnParser->parse("FN:Mr. John Q. Public\, Esq.");
    $expected = $this->listFactory->pure(new FN("Mr. John Q. Public\, Esq."));

    $this->assertEqual($expected, $result);
  }
}
