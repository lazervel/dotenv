<?php

declare(strict_types=1);
/*
│––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
│ Dotenv v1.0.3
│––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
│
│
│
*/
namespace Dotenv;

use Dotenv\Loader\LoaderInterface;
use Dotenv\Loader\Loader;
use Dotenv\Parser\ParserInterface;
use Dotenv\Parser\Parser;
use Dotenv\Env\EnvInterface;
use Dotenv\Env\Env;
use Dotenv\Env\EnvBuilder;
use Dotenv\Env\ContentStore;
use Dotenv\Validator\Validator;

class Dotenv
{
  /**
   * 
   * @var \Dotenv\Env\EnvInterface        $env
   * @var \Dotenv\Loader\LoaderInterface  $loader
   * @var \Dotenv\Parser\ParserInterface  $parser
   */
  private $env, $loader, $parser;

  public const VERSION = '1.2.0';

  /**
   * Create a new dotenv instance.
   * 
   * @param \Dotenv\Env\EnvInterface        $env     [required]
   * @param \Dotenv\Loader\LoaderInterface  $loader  [required]
   * @param \Dotenv\Parser\ParserInterface  $parser  [required]
   * @return void
   */
  public function __construct(EnvInterface $env, LoaderInterface $loader, ParserInterface $parser)
  {
    $this->loader = $loader;
    $this->parser = $parser;
    $this->env    = $env;
  }

  /**
   * Create a new dotenv instance.
   * 
   * @param string      $path          [required]
   * @param string|null $name          [optional]
   * @param string|null $fileEncoding  [optional]
   * 
   * @return \Dotenv\Dotenv
   */
  public static function doConfig(string $path, ?string $name = null, ?string $fileEncoding = null)
  {
    return self::create($path, $name, $fileEncoding);
  }

  /**
   *
   * @param string|array $variables  [required]
   * @return \Validator\Validator
   */
  public function required($variables)
  {
    return (new Validator((array) $variables))->required();
  }

  /**
   *
   * @param string|array $variables  [required]
   * @return \Validator\Validator
   */
  public function ifPresent($variables)
  {
    return new Validator((array) $variables);
  }

  /**
   * 
   * @param string $content  [required]
   * @return array<string,string|null>
   */
  public function parse(string $content)
  {
    $dotenv = new self(new ContentStore($content), new Loader(), new Parser());
    return $dotenv->load();
  }

  /*
  │––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
  │
  │––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
  │
  │
  │
  */
  public function load()
  {
    return $this->loader->load($this->parser->parse($this->env->read()));
  }

  /*
  │––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
  │
  │––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
  │
  │
  │
  */
  public function safeLoad()
  {
    try { return $this->load(); } catch(\Exception $e) { return []; }
  }

  /**
   * Create a new dotenv instance.
   * 
   * @param string      $path          [required]
   * @param string|null $name          [optional]
   * @param string|null $fileEncoding  [optional]
   * 
   * @return \Dotenv\Dotenv
   */
  public static function create(string $path, ?string $name = null, ?string $fileEncoding = null)
  {
    $EnvBuilder = EnvBuilder::make($path, $name);
    return new self($EnvBuilder::fileEncoding($fileEncoding)->store(), new Loader(), new Parser());
  }
}
?>
