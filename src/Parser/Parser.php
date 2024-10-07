<?php

declare(strict_types=1);

namespace Dotenv\Parser;

use Dotenv\Util\Str;

final class Parser implements ParserInterface
{
  public function parse(string $content)
  {
    $entries = Str::createCleanMatchesPaire(Str::extract($content));
    return Str::varSetup($entries);
  }
}
?>