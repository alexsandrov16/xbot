<?php

namespace Al3x5\xBot\Entities;

/**
 * Animation Entity
 * @property string $file_id;
 * @property string $file_unique_id;
 * @property int $width;
 * @property int $height;
 * @property int $duration;
 * @property PhotoSize $thumbnail;
 * @property string $file_name;
 * @property string $mime_type;
 * @property int $file_size;
 */
class Animation extends EntityBase
{
    protected function getEntities(): array
    {
        return [
            'thumbnail' => PhotoSize::class,
        ];
    }
}
