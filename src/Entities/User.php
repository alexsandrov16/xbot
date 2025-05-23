<?php

namespace Al3x5\xBot\Entities;

/**
 * User Entity
 * @property int $id;
 * @property bool $is_bot;
 * @property string $first_name;
 * @property string $last_name;
 * @property string $username;
 * @property string $language_code;
 * @property bool $is_premium;
 * @property bool $added_to_attachment_menu;
 * @property bool $can_join_groups;
 * @property bool $can_read_all_group_messages;
 * @property bool $supports_inline_queries;
 * @property bool $can_connect_to_business;
 * @property bool $has_main_web_app;
 */
class User extends EntityBase
{
    protected function getEntities(): array
    {
        return [];
    }
}
