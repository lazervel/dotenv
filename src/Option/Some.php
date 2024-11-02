<?php

declare(strict_types=1);

namespace Dotenv\Option;

final class Some extends Option
{
  /** @var mixed $value */
  private $value;

  /**
   * 
   * @param mixed $value [required]
   * @return void
   */
  public function __construct($value)
  {
    $this->value = $value;
  }

  /**
   * 
   * @param mixed $value [required]
   * @return \Dotenv\Option\None|\Dotenv\Option\Some
   */
  public function reject($value)
  {
    return $this->value === $value ? None::create() : $this;
  }

  /**
   * 
   * @return mixed
   */
  public function get()
  {
    return $this->value;
  }

  /**
   * 
   * @param mixed $value [required]
   * @return \Dotenv\Option\Some
   */
  public static function create($value)
  {
    return new self($value);
  }

  /**
   * 
   * @param callable $callable [required]
   * @return \Dotenv\Option\Some
   */
  public function map($callable)
  {
    return new self($callable($this->value));
  }

  /**
   * 
   * @return false
   */
  public function isEmpty()
  {
    return false;
  }

  /**
   * 
   * @return true
   */
  public function isDefined()
  {
    return true;
  }

  /**
   * 
   * @param callable $callable [required]
   * @return 
   */
  public function flatMap($callable)
  {
    /** @var mixed */
    $rs = $callable($this->value);
    if (!$rs instanceof Option) {
      throw new \Error('Callables passed to flatMap() must return an Option. Maybe you should use map() instead?');
    }
    return $rs;
  }
}
?>