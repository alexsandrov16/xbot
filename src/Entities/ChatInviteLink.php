<?php

namespace Al3x5\xBot\Entities;

/**
 * ChatInviteLink Entity
 * @property string $invite_link;
 * @property User $creator;
 * @property bool $creates_join_request;
 * @property bool $is_primary;
 * @property bool $is_revoked;
 * @property string $name;
 * @property int $expire_date;
 * @property int $member_limit;
 * @property int $pending_join_request_count;
 * @property int $subscription_period;
 * @property int $subscription_price;
 */
class ChatInviteLink extends EntityBase
{
    protected function getEntities(): array
    {
        return [
            'creator' => User::class,
        ];
    }
}
