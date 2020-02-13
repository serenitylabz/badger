<?php

namespace Badger\VCard;

class VCard {

  private $version;
  private $properties;

  /**
   * @param $version An instance of Badger\VCard\Version.
   * @param $properties An instance of PhatCats\LinkedList\LinkedList containing
   * instances of Badger\VCard\Property\Property.
   */
  public function __construct($version, $properties) {
    $this->version = $version;
    $this->properties = $properties;
  }

  public function getVersion() {
    return $this->version;
  }

  public function getProperties() {
    return $this->properties;
  }
}
