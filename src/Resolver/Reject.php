<?php

declare(strict_types=1);

namespace Lazervel\Dotenv\Resolver;

use Lazervel\Dotenv\Option\Some;
use Lazervel\Dotenv\Option\None;

final class Reject extends Result
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
    return self::create($this->value);
  }

  public function fail()
  {
    return Some::create($this->value);
  }

  public function done()
  {
    return None::create();
  }

  public function flatMap(callable $callable)
  {
    return self::create($this->value);
  }

  public function failMap(callable $callable)
  {
    return self::create($callable($this->value));
  }
}
?>