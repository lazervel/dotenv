<?php

declare(strict_types=1);

/**
 * The PHP Dotenv loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automatically.
 * 
 * The (dotenv) Github repository.
 * @see       https://github.com/lazervel/dotenv
 * 
 * @author    Shahzada Modassir <shahzadamodassir@gmail.com>
 * @author    Shahzadi Afsara   <shahzadiafsara@gmail.com>
 * 
 * @copyright (c) Shahzada Modassir
 * @copyright (c) Shahzadi Afsara
 * 
 * @license   MIT License
 * @see       https://github.com/lazervel/dotenv/blob/main/LICENSE
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lazervel\Dotenv;

use Lazervel\Dotenv\Loader\LoaderInterface;
use Lazervel\Dotenv\Loader\Loader;
use Lazervel\Dotenv\Parser\ParserInterface;
use Lazervel\Dotenv\Parser\Parser;
use Lazervel\Dotenv\Backup\BackupInterface;
use Lazervel\Dotenv\Backup\Backup;
use Lazervel\Dotenv\Validator\Validator;
use Lazervel\Dotenv\Reader\StoreBuilder;
use Lazervel\Dotenv\Reader\ReaderInterface;

class Dotenv
{
  private $reader, $loader, $parser, $backup;

  /**
   * 
   * @param \Dotenv\Reader\ReaderInterface $reader [required]
   * @param \Dotenv\Loader\LoaderInterface $loader [required]
   * @param \Dotenv\Parser\ParserInterface $parser [required]
   * @param \Dotenv\Backup\BackupInterface $backup [required]
   * 
   * @return void
   */
  public function __construct(ReaderInterface $reader, LoaderInterface $loader, ParserInterface $parser, BackupInterface $backup)
  {
    $this->reader = $reader;
    $this->loader = $loader;
    $this->parser = $parser;
    $this->backup = $backup;
  }

  /**
   * 
   * @param string|string[]      $paths        [required]
   * @param string|string[]|null $names        [optional]
   * @param bool                 $shortCircuit [optional]
   * @param string|null          $fileEncoding [optional]
   * 
   * @return \Dotenv\Dotenv
   */
  public static function process($paths, $names = null, bool $shortCircuit = true, ?string $fileEncoding = null)
  {
    return self::create(Backup::create(), $paths, $names, $shortCircuit, $fileEncoding);
  }

  /**
   * 
   * @param \Dotenv\Backup\BackupInterface $backup       [required]
   * @param string|string[]                $paths        [required]
   * @param string|string[]|null           $names        [optional]
   * @param bool                           $shortCircuit [optional]
   * @param string|null                    $fileEncoding [optional]
   * 
   * @return \Dotenv\Dotenv
   */
  public static function create(BackupInterface $backup, $paths, $names = null, bool $shortCircuit = true, ?string $fileEncoding = null)
  {
    ($reader = ($names===null ? StoreBuilder::createWithName() : StoreBuilder::createWithoutName())
      ->addPath($paths)
      ->addName($names)
      ->shortCircuit($shortCircuit));
    return new self($reader->fileEncoding($fileEncoding)->store(), new Loader(), new Parser(), $backup);
  }

  /**
   * 
   * @return array
   */
  public function load()
  {
    $entries = $this->parser->parse($this->reader->read());
    $this->loader->load($this->backup, $entries);
    return $entries;
  }

  /**
   * 
   * @param string $content [required]
   * @return array
   */
  public function parse(string $content)
  {
    $entries = $this->parser->parse($content);
    $this->loader->load($this->backup, $entries);
    return $entries;
  }

  /**
   * 
   * @return array
   */
  public function safeLoad()
  {
    try {
      return $this->load();
    } catch (InvalidPathException $e) {
      // suppressing exception
      return [];
    }
  }

  /**
   * 
   * @param string|string[] $variables [required]
   * @return \Dotenv\Validator\Validator
   */
  public function ifPresent($variables)
  {
    return new Validator($this->backup, (array) $variables);
  }

  /**
   * 
   * @param string|string[] $variables [required]
   * 
   * @throws \Dotenv\Exception\ValidationException
   * 
   * @return \Dotenv\Validator\Validator
   */
  public function required($variables)
  {
    return (new Validator($this->backup, (array) $variables))->required();
  }
}
?>