<?php

namespace Al3x5\xBot\Entities;

/**
 * ChatPermissions Entity
 * @property bool $can_send_messages;
 * @property bool $can_send_audios;
 * @property bool $can_send_documents;
 * @property bool $can_send_photos;
 * @property bool $can_send_videos;
 * @property bool $can_send_video_notes;
 * @property bool $can_send_voice_notes;
 * @property bool $can_send_polls;
 * @property bool $can_send_other_messages;
 * @property bool $can_add_web_page_previews;
 * @property bool $can_change_info;
 * @property bool $can_invite_users;
 * @property bool $can_pin_messages;
 * @property bool $can_manage_topics;
 */
class ChatPermissions extends EntityBase
{
    protected function getEntities(): array
    {
        return [];
    }
}
