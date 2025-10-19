<?php

declare(strict_types=1);

namespace Lazervel\Dotenv\Parser;

use Lazervel\Dotenv\Exception\InvalidFileException;
use Lazervel\Dotenv\Resolver\Resolve;
use Lazervel\Dotenv\Util\RegExp;

final class Entries
{
  private const ENV = '/^[\x20]*(\w+)[\x20]*=[\x20]*(?:(["\'`])((?:[^\r\n]|[\r\n])*?)(\2)|([^#\r\n]*))(?!^#)/m';

  private static function combine(array $entries)
  {
    // Use to index will force for single line env values
    $forceIndex = 3;
    $keys   = $entries[1];
    $values = $entries[5];

    foreach($values as $i => $value) {
      if ($value == null) {
        $values[$i] = $entries[$forceIndex][$i];
      }
    }

    return Nested::resolve(\array_combine($keys, $values));
  }

  public static function store(array $lines)
  {
    return RegExp::matchAll(self::ENV, \implode("\n", $lines))->failMap(function() {
      return 'Cannot store environments variables something went wrong.';
    })->flatMap(static function (array $entries) {
      return Resolve::create(self::combine($entries));
    })->failMap(static function(string $error) {
      throw new InvalidFileException(\sprintf('Failed to parse dotenv file. %s', $error));
    });
  }
}
?>