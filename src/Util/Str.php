<?php

declare(strict_types=1);

namespace Dotenv\Util;

use RegExp\RegExp;

final class Str
{
  public static function doArrange(array $matches, array $compare)
  {
    if (\count($compare) <= 0) return $matches;

    $matched = \array_pop($compare);

    foreach($matches as $i => $value)
    {
      if (($val = self::force($value, $matched[$i])))
      {
        $matches[$i] = $val;
      }
    }

    return self::doArrange($matches, $compare);
  }

  public static function createCleanMatchesPaire(array $entries)
  {
    $keys    = $entries[1];
    $matches = $entries[5];
    $values  = @\array_slice($entries, 2, -1);
    return \array_combine($keys, self::doArrange($matches, $values));
  }

  public static function varSetup(array $entries)
  {
    $pattern = (string) new RegExp('(?<!\\\\)\\$\\{([^\\{\\}]+)\\}');
    foreach($entries as $i => $value)
    {
      $entries[$i] = \preg_replace_callback($pattern, function($matched) use ($entries) {
        return $entries[$matched[1]];
      }, $value);
    }
    return $entries;
  }

  /**
   * 
   * @param mixed $target
   * @param mixed $forced
   * 
   * @return mixed value
   */
  public static function force($target, $forced="")
  {
    return !!$target ? $target : $forced;
  }

  public static function encode($content, $fileEncoding)
  {
    return \mb_convert_encoding(self::force($content), $fileEncoding);
  }

  /**
   * 
   * @param string $content  [required]
   * @param array<string,string|null>
   */
  public static function extract(string $content)
  {
    @\preg_match_all(
      (string) new RegExp(
        '^%1(\w+)%1=%1(?:"(%2)"|\'(%2)\'|`(%2)`|([^#\r\n]*))(?!^#)', 'm', '[\x20]*', '(?:[^\r\n]|[\r\n])*?'
      ), $content, $matches
    );
    return $matches;
  }
}
?>