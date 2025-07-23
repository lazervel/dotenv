<?php

declare(strict_types=1);

namespace Dotenv\Backup;

use Dotenv\Exception\VarNotFoundException;
use Dotenv\Resolver\Resolve;
use Dotenv\Resolver\Reject;
use Dotenv\Parser\Parser;
use Dotenv\Parser\ParserInterface;

final class Backup implements BackupInterface
{
  private $parser;
  private $variables;
  public function __construct(array $variables, ParserInterface $parser)
  {
    $this->variables = $variables;
    $this->parser = $parser;
  }

  private function setEnv(string $name, $value)
  {
    if ($this->isSupport()) {
      \putenv("$name=$value");
    }
    
    $_SERVER[$name] = $_ENV[$name] = $value;
  }

  private function isSupport()
  {
    return \function_exists('putenv') && \function_exists('getenv');
  }

  public static function create()
  {
    return new self([], new Parser());
  }

  public function get(string $name)
  {
    return $this->getOrElse($name)->failMap(static function($error) {
      throw new VarNotFoundException($error);
    })->done()->get();
  }

  public function set(string $name, $value)
  {
    $this->variables[$name] = $value;
    $this->setEnv($name, $value);
    return Resolve::create($this->variables);
  }

  private function getOrElse(string $name)
  {
    return isset($this->variables[$name]) ? Resolve::create($this->variables[$name]) :
      Reject::create('Try to get undefined environment variable [%s].', \sprintf($name));
  }
}
?>