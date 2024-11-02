<?php

declare(strict_types=1);

namespace Dotenv\Reader;

use Path\Path;

final class StoreBuilder
{
  /**
   * 
   * @var string
   */
  private const DEFAULT_ENV = '.env';

  /**
   * 
   * @var array
   */
  private $paths;

  /**
   * 
   * @var array
   */
  private $names;

  /**
   * 
   * @var bool
   */
  private $shortCircuit;

  /**
   * 
   * @var string|null
   */
  private $fileEncoding;

  /**
   * 
   * @param array  $paths        [optional]
   * @param array  $names        [optional]
   * @param bool   $shortCircuit [optional]
   * @param string $fileEncoding [optional]
   * 
   * @return void
   */
  public function __construct(array $paths = [], array $names = [], bool $shortCircuit = false, ?string $fileEncoding = null)
  {
    $this->paths = $paths;
    $this->names = $names;
    $this->shortCircuit = $shortCircuit;
    $this->fileEncoding = $fileEncoding;
  }

  /**
   * 
   * @param string|string[]|null $values
   * @param string               $target
   * 
   * @return \Dotenv\Reader\StoreBuilder
   */
  private function mergeWith($values, $target)
  {
    foreach((array) $values as $value) {
      $this->$target = \array_merge($this->$target, [$value]);
    }
    return new self($this->paths, $this->names, $this->shortCircuit, $this->fileEncoding);
  }

  /**
   * 
   * @return \Dotenv\Reader\StoreBuilder
   */
  public static function createWithName()
  {
    return new self([], [self::DEFAULT_ENV]);
  }

  /**
   * 
   * @return \Dotenv\Reader\StoreBuilder
   */
  public static function createWithoutName()
  {
    return new self();
  }

  /**
   * 
   * @param string|null $fileEncoding [required]
   * @return \Dotenv\Reader\StoreBuilder
   */
  public function fileEncoding(?string $fileEncoding)
  {
    return new self($this->paths, $this->names, $this->shortCircuit, $fileEncoding);
  }

  /**
   * 
   * @param string|string[] $paths [required]
   * @return \Dotenv\Reader\StoreBuilder
   */
  public function addPath($paths)
  {
    return $this->mergeWith($paths, 'paths');
  }

  /**
   * 
   * @param string|string[]|null $names [optional]
   * @return \Dotenv\Reader\StoreBuilder
   */
  public function addName($names)
  {
    return $this->mergeWith($names, 'names');
  }

  /**
   * 
   * @param bool $shortCircuit [optional]
   * @return \Dotenv\Reader\StoreBuilder
   */
  public function shortCircuit(bool $shortCircuit = false)
  {
    return new self($this->paths, $this->names, $shortCircuit, $this->fileEncoding);
  }

  /**
   * 
   * @return \Dotenv\Reader\ReaderInterface
   */
  public function store()
  {
    return new FileReader(Path::combine($this->paths, $this->names), $this->shortCircuit, $this->fileEncoding);
  }
}
?>