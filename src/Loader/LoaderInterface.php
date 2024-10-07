<?php

declare(strict_types=1);

namespace Dotenv\Loader;

interface LoaderInterface
{
  public function load(array $entries);
}
?>