<?php

declare(strict_types=1);

namespace Lazervel\Dotenv\Util;

use Lazervel\Dotenv\Resolver\Resolve;
use Lazervel\Dotenv\Resolver\Reject;

final class Convert
{
  /**
   * 
   * @param string      $input    [required]
   * @param string|null $encoding [required]
   * 
   * @return \Dotenv\Handler\Reject|\Dotenv\Handler\Resolve
   */
  public static function utf8(string $input, ?string $encoding = null)
  {
    if ($encoding !== null && !\in_array($encoding, \mb_list_encodings(), true)) {
      return Reject::create(\sprintf('Illegal character encoding [%s] specified.', $encoding));
    }

    $converted = $encoding === null ? @\mb_convert_encoding($input, 'UTF-8') :
      @\mb_convert_encoding($input, 'UTF-8', $encoding);

    if (\substr($converted, 0, 3) == "\xEF\xBB\xBF") ($converted = \substr($converted, 3));
    return Resolve::create($converted);
  }
}
?>