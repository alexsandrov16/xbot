<?php

namespace Al3x5\xBot\Entities;

/**
 * File class
 * 
 * @property string $file_id;
 * @property string $file_unique_id;
 * @property int $file_size;
 * @property string $file_path;
 */
class File extends Base
{
    public function getEntities(): array
    {
        return [];
    }
}