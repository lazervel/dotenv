<?php

declare(strict_types=1);

namespace Lazervel\Dotenv\Parser;

use Lazervel\Dotenv\Resolver\Resolve;
use Lazervel\Dotenv\Resolver\Reject;
use Lazervel\Dotenv\Util\RegExp;

final class Lines
{
  private const value = '/(?:=[\x20]*(?:([\'"`])(?:[\r\n]?(.*)?)+?(?=[\r\n\x20]*\w+=)))/m';
  private const key = '/(?:^\s*(?:(?:[\'"`]+[\w-]+))?(?:[\w-]+[\'"`]+)*\s*=)/m';
  
  private const comment = '/^\s*#.*/';
  
  public static function process(array $lines)
  {
    return self::validateEnv($lines)->flatMap(static function(array $lines) {
      return Resolve::create(Entries::store($lines));
    })->failMap(static function(string $error) {
      throw new \Error(\sprintf('Failed to parse dotenv file. %s', $error));
    })->done()->get();
  }

  private static function filterEnv(array $lines)
  {
    return \array_diff($lines, \preg_grep(self::comment, $lines));
  }

  private static function validateEnv(array $lines)
  {
    $error = null;
    $line = 0;
    
    RegExp::pregCallback([self::key, self::value], function($matches) use (&$error, &$line, $lines) {
      if (!isset($matches[2])) {
        $error = \trim($matches[0]);
        $line = \array_search($error, $lines);
        return;
      }

      $haystack = $matches[2];
      $needle = $matches[1];

      if (!$error && $haystack && $needle && !\str_ends_with(\trim($haystack), $needle)) {
        $error = $haystack;
        $line = \array_search($haystack, $lines);
        return;
      }
    }, \implode("\n", $lines)."\nDEBUG=");

    return $error !== null ?
      Reject::create(\sprintf('Encountered unexpected env syntax [%s] at Index: [%d]', $error, $line + 1)) : Resolve::create(self::filterEnv($lines));
  }
}
?>