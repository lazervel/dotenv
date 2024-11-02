<?php

declare(strict_types=1);

namespace Dotenv\Option;

abstract class Option
{
  /**
   * 
   * @param callable $callable [required]
   */
  abstract public function flatMap($callable);

  /**
   * 
   * 
   */
  abstract public function isDefined();

  /**
   * 
   * 
   */
  abstract public function get();

  /**
   * 
   * 
   */
  abstract public function isEmpty();

  /**
   * 
   */
  abstract public function map($callable);

  /**
   * 
   * @param mixed $value [required]
   */
  abstract public function reject($value);

  /**
   * 
   * @param mixed $value     [required]
   * @param mixed $noneValue [optional]
   * 
   * @return \Dotenv\Option\None|\Dotenv\Option\Some
   */
  public static function fromValue($value, $noneValue = null)
  {
    return $value === $noneValue ? None::create() : new Some($value);
  }
}
?>