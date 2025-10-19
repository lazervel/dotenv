<?php

declare(strict_types=1);

namespace Lazervel\Dotenv\Parser;

use Lazervel\Dotenv\Exception\VarNotFoundException;
use Lazervel\Dotenv\Option\Option;
use Lazervel\Dotenv\Util\RegExp;
use Lazervel\Dotenv\Resolver\Reject;
use Lazervel\Dotenv\Resolver\Resolve;

final class Nested
{
  private const NESTED = '/^(?<!\\\\)\\$\\{\\s*([^\\{\\}\\s]+)\\s*\\}$/';

  /**
   * 
   * @param array $entries [required]
   * 
   * @throws \Dotenv\Exception\VarNotFoundException
   * 
   * @return array Nested entries
   */
  public static function resolve(array $entries)
  {
    $entries = Option::fromValue($entries, false);
    return $entries->flatMap(static function(array $entries) {
      return self::process($entries)->failMap(static function(string $error) {
        throw new VarNotFoundException($error);
      })->done();
    })->get();
  }

  /**
   * 
   * @param array $entries [required]
   * 
   * @return \Dotenv\Option\Option<string>
   */
  private static function process(array $entries)
  {
    foreach($entries as $i => $entry) {
      if (($keys = RegExp::match(self::NESTED, $entry, true)->done()->get()) && $keys !== []) {
        $key = $keys[1];
        if (!isset($entries[$key])) {
          return Reject::create(
            \sprintf('Failed to parse undefined environment variable [%s].', $key)
          );
        }
        $entries[$i] = \preg_replace(self::NESTED, $entries[$key], $entry);
      }
    }
    return Resolve::create($entries);
  }
}
?>
