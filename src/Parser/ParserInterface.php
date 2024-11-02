<?php

declare(strict_types=1);

namespace Dotenv\Parser;

interface ParserInterface
{
  public function parse(string $content);
}
?>