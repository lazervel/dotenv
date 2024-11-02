<?php

declare(strict_types=1);

namespace Dotenv\Reader;

use Dotenv\Exception\InvalidEncodingException;
use Dotenv\Option\Option;
use Dotenv\Util\Convert;

final class Reader
{
  /**
   * 
   * @param array       $filePaths    [required]
   * @param bool        $shortCircuit [required]
   * @param string|null $fileEncoding [required]
   * 
   * @throws \Dotenv\Exception\InvalidEncodingException
   * 
   * @return array<string,string>
   */
  public static function read(array $filePaths, bool $shortCircuit, ?string $fileEncoding) : array
  {
    $output = [];

    foreach($filePaths as $filePath) {
      $content = self::readFromFile($filePath, $fileEncoding);
      if ($content->isDefined()) {
        $output[$filePath] = $content->get();
        if ($shortCircuit) {
          break;
        }
      }
    }

    return $output;
  }

  /**
   * 
   * @param string      $filePath     [required]
   * @param string|null $fileEncoding [required]
   * 
   * @throws \Dotenv\Exception\InvalidEncodingException
   * 
   * @return \Dotenv\Option\Option<string>
   */
  private static function readFromFile(string $filePath, ?string $encoding)
  {
    $content = Option::fromValue(@\file_get_contents($filePath), false);
    return $content->flatMap(static function(string $content) use ($encoding) {
      return Convert::utf8($content, $encoding)->failMap(static function (string $error) {
        throw new InvalidEncodingException($error);
      })->done();
    });
  }
}
?>