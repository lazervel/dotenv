<?php

declare(strict_types=1);

namespace Dotenv\Resolver;

use Dotenv\Option\Some;
use Dotenv\Option\None;

final class Resolve extends Result
{
  private $value;

  public function __construct($value)
  {
    $this->value = $value;
  }

  public static function create($value)
  {
    return new self($value);
  }

  public function map(callable $callable)
  {
    return self::create($callable($this->value));
  }

  public function fail()
  {
    return None::create();
  }

  public function done()
  {
    return Some::create($this->value);
  }

  public function flatMap(callable $callable)
  {
    return $callable($this->value);
  }

  public function failMap(callable $callable)
  {
    return self::create($this->value);
  }
}
?>