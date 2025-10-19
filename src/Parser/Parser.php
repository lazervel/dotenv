<?php

declare(strict_types=1);

namespace Lazervel\Dotenv\Parser;

use Lazervel\Dotenv\Exception\InvalidFileException;
use Lazervel\Dotenv\Util\RegExp;
use Lazervel\Dotenv\Resolver\Resolve;
use Lazervel\Dotenv\Resolver\Reject;

final class Parser implements ParserInterface
{
  /**
   * 
   * @param string $content [required]
   * 
   * @return
   */
  public function parse(string $content)
  {
    return RegExp::split("/(\r\n|\n|\r)/", $content)->failMap(function() {
      return 'Could not split into separate lines.';
    })->flatMap(static function(array $lines) {
      return Lines::process($lines);
    })->failMap(static function (string $error) {
      throw new InvalidFileException(\sprintf('Failed to parse dotenv file. %s', $error));
    })->done()->get();
  }
}
?>