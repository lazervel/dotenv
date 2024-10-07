<?php

declare(strict_types=1);

namespace Dotenv\Env;

use Dotenv\Util\Str;

final class EnvBuilder
{

  private static $path, $name, $fileEncoding;

  public function __construct(string $path, ?string $name = null, ?string $fileEncoding = null)
  {
    self::$fileEncoding = Str::force($fileEncoding, 'utf-8');
    self::$name = Str::force($name, '.env');
    self::$path = $path;
  }

  public static function fileEncoding(?string $fileEncoding = null)
  {
    return new self(self::$path, self::$name, $fileEncoding);
  }

  public static function make(string $path, ?string $name = null)
  {
    return new self($path, $name, self::$fileEncoding);
  }

  public function store()
  {
    return new EnvReader(\Path\Path::resolve(self::$path, self::$name), self::$fileEncoding);
  }
}
?>