<?php

declare(strict_types=1);

namespace Dotenv\Util;

use Dotenv\Resolver\Resolve;
use Dotenv\Resolver\Reject;

final class RegExp
{
  public static function matchAll($pattern, $subject, bool $returnMatches = true)
  {
    return self::pregWithWrap(static function(string $subject) use ($pattern, $returnMatches) {
      $matched = @\preg_match_all($pattern, $subject, $matches);
      return $returnMatches ? $matches : $matched;
    }, $subject);
  }

  public static function pregCallback($pattern, $callable, $subject)
  {
    return self::pregWithWrap(static function(string $subject) use ($pattern, $callable) {
      return @\preg_replace_callback($pattern, $callable, $subject);
    }, $subject);
  }

  public static function split(string $pattern, string $subject)
  {
    return self::pregWithWrap(static function(string $subject) use ($pattern) {
      /** @var string[] */
      return (array) @\preg_split($pattern, $subject);
    }, $subject);
  }

  public static function match(string $pattern, string $subject, bool $returnMatches = false)
  {
    return self::pregWithWrap(static function(string $subject) use ($pattern, $returnMatches) {
      $matched = (int) @\preg_match($pattern, $subject, $matches);
      return $returnMatches ? $matches : $matched;
    }, $subject);
  }

  /**
   * Perform a preg operation, wrapping up the result.
   * 
   * @param callable $operation
   * @param string $subject
   * 
   * @return \Dotenv\Resolver\Result<V,string>
   */
  public static function pregWithWrap(callable $operation, string $subject)
  {
    $result = $operation($subject);

    return \preg_last_error() !== \PREG_NO_ERROR ?
      Reject::create(\preg_last_error_msg()) : Resolve::create($result);
  }
}
?>