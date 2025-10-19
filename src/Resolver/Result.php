<?php

declare(strict_types=1);

namespace Lazervel\Dotenv\Resolver;

abstract class Result
{
  abstract public function done();
  abstract public function fail();

  abstract public function flatMap(callable $callable);

  abstract public function map(callable $callable);

  abstract public function failMap(callable $callable);
}
?>