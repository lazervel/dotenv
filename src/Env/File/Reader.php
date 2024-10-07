<?php

declare(strict_types=1);

namespace Dotenv\Env\File;

use Dotenv\Util\Str;

final class Reader
{
  /**
   * 
   * @param string $repository    [required]
   * @param string $fileEncoding  [required]
   * 
   * @return string $content
   */
  public static function read(string $repository, string $fileEncoding)
  {
    return Str::encode(@\file_get_contents($repository), $fileEncoding);
  }
}
?>