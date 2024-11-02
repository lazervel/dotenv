<?php

declare(strict_types=1);

namespace Dotenv\Option;

final class None extends Option
{
  /** @var None|null $instance */
  private static $instance;

  /**
   * 
   * @throws \Error If try to access get()
   */
  public function get()
  {
    throw new \Error('None has no value access.');
  }

  /**
   * 
   * @return \Dotenv\Option\None
   */
  public function flatMap($callable)
  {
    return $this;
  }

  /**
   * 
   * @param callable $callable [required]
   * @return \Dotenv\Option\None
   */
  public function map($callable)
  {
    return $this;
  }

  /**
   * 
   * @return true
   */
  public function isEmpty()
  {
    return true;
  }

  /**
   * 
   * @return false
   */
  public function isDefined()
  {
    return false;
  }

  /**
   * 
   * @return \Dotenv\Option\None
   */
  public function reject($value)
  {
    return $this;
  }

  /**
   * 
   * @return \Dotenv\Option\None
   */
  public static function create()
  {
    if (null===self::$instance) {
      self::$instance = new self();
    }

    return self::$instance;
  }
}
?>