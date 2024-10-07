<?php

declare(strict_types=1);

namespace Dotenv\Env;

use Dotenv\Env\File\Reader;

final class EnvReader implements EnvInterface
{
  private $respository, $fileEncoding;

  /**
   * 
   * @param string $repository    [required]
   * @param string $fileEncoding  [required]
   * 
   * @return void
   */
  public function __construct(string $respository, string $fileEncoding)
  {
    $this->respository  = $respository;
    $this->fileEncoding = $fileEncoding;
  }

  /**
   * 
   * 
   * @return array<string,string|null> $content
   */
  public function read()
  {
    $content = Reader::read($this->respository, $this->fileEncoding);

    if (!$content) throw new \Exception(
      \sprintf('Unable to read any of the environment file(s) at [%s].', $this->respository)
    );

    return $content;
  }
}
?>