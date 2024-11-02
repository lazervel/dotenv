<?php

declare(strict_types=1);

namespace Dotenv\Validator;

use Dotenv\Exception\ValidationException;
use Dotenv\Backup\BackupInterface;
use Dotenv\Util\RegExp;

final class Validator
{
  private $repository;
  private $variables;

  public function __construct(BackupInterface $repository, array $variables)
  {
    $this->repository = $repository;
    $this->variables = $variables;
  }

  public function required()
  {
    return $this->assert(
      static function(?string $value) {
        return $value !== null;
      },
      'is missing.'
    );
  }

  public function assert(callable $callable, string $message)
  {
    $failure = [];
    foreach($this->variables as $variable) {
      if ($callable($this->repository->get($variable)) === false) {
        $failure[] = \sprintf('%s %s', $variable, $message);
      }
    }

    if (\count($failure) > 0) {
      throw new ValidationException(\sprintf(
        'One or more environment variables failed assertions: %s.',
        \implode(', ', $failing)
      ));
    }
  }
}
?>