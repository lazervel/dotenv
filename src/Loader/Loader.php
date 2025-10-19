<?php

declare(strict_types=1);

namespace Lazervel\Dotenv\Loader;

use Lazervel\Dotenv\Backup\BackupInterface;

final class Loader implements LoaderInterface
{
  /**
   * 
   * @param \Dotenv\Backup\BackupInterface $backup  [required]
   * @param array                          $entries [required]
   */
  public function load(BackupInterface $backup, array $entries)
  {
    foreach($entries as $key => $entry) {
      $backup->set($key, $entry);
    }
    return $entries;
  }
}
?>