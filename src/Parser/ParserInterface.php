<?php

declare(strict_types=1);

namespace Lazervel\Dotenv\Parser;

interface ParserInterface
{
  public function parse(string $content);
}
?>