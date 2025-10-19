<?php

declare(strict_types=1);

namespace Lazervel\Dotenv\Reader;

use Lazervel\Dotenv\Exception\InvalidPathException;

final class FileReader implements ReaderInterface
{
  /**
   * 
   * @var array
   */
  private $filePaths;

  /**
   * 
   * @var bool
   */
  private $shortCircuit;

  /**
   * 
   * @var string|null
   */
  private $fileEncoding;

  /**
   * 
   * @param array       $filePaths    [required]
   * @param bool        $shortCircuit [required]
   * @param string|null $fileEncoding [required]
   * 
   * @return void
   */
  public function __construct(array $filePaths, bool $shortCircuit, ?string $fileEncoding)
  {
    $this->filePaths = $filePaths;
    $this->shortCircuit = $shortCircuit;
    $this->fileEncoding = $fileEncoding;
  }

  /**
   * 
   * @throws \Dotenv\Exception\InvalidPathException|\Dotenv\Exception\InvalidEncodingException
   * @return string
   */
  public function read()
  {
    if ($this->filePaths === []) {
      throw new InvalidPathException('Faild Loading At least one environment file path must be provided.');
    }

    $contents = Reader::read($this->filePaths, $this->shortCircuit, $this->fileEncoding);

    if (\count($contents) > 0) {
      return \implode("\n", $contents);
    }

    throw new InvalidPathException(
      \sprintf('Unable to read any of the environment file(s) at [%s].', \implode(', ', $this->filePaths))
    );
  }
}
?>