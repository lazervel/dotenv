<?php

declare(strict_types=1);

namespace Dotenv\Env;

final class ContentStore implements EnvInterface
{
  private $content;

  /**
   * Create a new ContentStore instance.
   * 
   * @param string $content  [required]
   * @return void
   */
  public function __construct(string $content)
  {
    $this->content = $content;
  }

  /*
  │––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
  │ Method read() Content Reader
  │––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
  │
  │
  │
  */
  public function read()
  {
    return $this->content;
  }
}
?>