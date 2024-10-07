<?php

declare(strict_types=1);

namespace Dotenv\Loader;

final class Loader implements LoaderInterface
{
  public function load(array $entries)
  {
    foreach($entries as $name => $value)
    {
      $_SERVER[$name] = $_ENV[$name] = $value;
      \putenv("$name=$value");
    }
    return true;
  }
}
?>