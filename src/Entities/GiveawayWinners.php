<?php

namespace Al3x5\xBot\Entities;

/**
 * GiveawayWinners Entity
 * @property Chat $chat;
 * @property int $giveaway_message_id;
 * @property int $winners_selection_date;
 * @property int $winner_count;
 * @property \User[] $winners;
 * @property int $additional_chat_count;
 * @property int $prize_star_count;
 * @property int $premium_subscription_month_count;
 * @property int $unclaimed_prize_count;
 * @property bool $only_new_members;
 * @property bool $was_refunded;
 * @property string $prize_description;
 */
class GiveawayWinners extends EntityBase
{
    protected function getEntities(): array
    {
        return [
            'chat' => Chat::class,
        ];
    }
}
