<?php

namespace Al3x5\xBot\Entities;

/**
 * Message Entity
 * @property int $message_id;
 * @property int $message_thread_id;
 * @property User $from;
 * @property Chat $sender_chat;
 * @property int $sender_boost_count;
 * @property User $sender_business_bot;
 * @property int $date;
 * @property string $business_connection_id;
 * @property Chat $chat;
 * @property MessageOrigin $forward_origin;
 * @property bool $is_topic_message;
 * @property bool $is_automatic_forward;
 * @property Message $reply_to_message;
 * @property ExternalReplyInfo $external_reply;
 * @property TextQuote $quote;
 * @property Story $reply_to_story;
 * @property User $via_bot;
 * @property int $edit_date;
 * @property bool $has_protected_content;
 * @property bool $is_from_offline;
 * @property string $media_group_id;
 * @property string $author_signature;
 * @property int $paid_star_count;
 * @property string $text;
 * @property \MessageEntity[] $entities;
 * @property LinkPreviewOptions $link_preview_options;
 * @property string $effect_id;
 * @property Animation $animation;
 * @property Audio $audio;
 * @property Document $document;
 * @property PaidMediaInfo $paid_media;
 * @property \PhotoSize[] $photo;
 * @property Sticker $sticker;
 * @property Story $story;
 * @property Video $video;
 * @property VideoNote $video_note;
 * @property Voice $voice;
 * @property string $caption;
 * @property \MessageEntity[] $caption_entities;
 * @property bool $show_caption_above_media;
 * @property bool $has_media_spoiler;
 * @property Contact $contact;
 * @property Dice $dice;
 * @property Game $game;
 * @property Poll $poll;
 * @property Venue $venue;
 * @property Location $location;
 * @property \User[] $new_chat_members;
 * @property User $left_chat_member;
 * @property string $new_chat_title;
 * @property \PhotoSize[] $new_chat_photo;
 * @property bool $delete_chat_photo;
 * @property bool $group_chat_created;
 * @property bool $supergroup_chat_created;
 * @property bool $channel_chat_created;
 * @property MessageAutoDeleteTimerChanged $message_auto_delete_timer_changed;
 * @property int $migrate_to_chat_id;
 * @property int $migrate_from_chat_id;
 * @property MaybeInaccessibleMessage $pinned_message;
 * @property Invoice $invoice;
 * @property SuccessfulPayment $successful_payment;
 * @property RefundedPayment $refunded_payment;
 * @property UsersShared $users_shared;
 * @property ChatShared $chat_shared;
 * @property GiftInfo $gift;
 * @property UniqueGiftInfo $unique_gift;
 * @property string $connected_website;
 * @property WriteAccessAllowed $write_access_allowed;
 * @property PassportData $passport_data;
 * @property ProximityAlertTriggered $proximity_alert_triggered;
 * @property ChatBoostAdded $boost_added;
 * @property ChatBackground $chat_background_set;
 * @property ForumTopicCreated $forum_topic_created;
 * @property ForumTopicEdited $forum_topic_edited;
 * @property ForumTopicClosed $forum_topic_closed;
 * @property ForumTopicReopened $forum_topic_reopened;
 * @property GeneralForumTopicHidden $general_forum_topic_hidden;
 * @property GeneralForumTopicUnhidden $general_forum_topic_unhidden;
 * @property GiveawayCreated $giveaway_created;
 * @property Giveaway $giveaway;
 * @property GiveawayWinners $giveaway_winners;
 * @property GiveawayCompleted $giveaway_completed;
 * @property PaidMessagePriceChanged $paid_message_price_changed;
 * @property VideoChatScheduled $video_chat_scheduled;
 * @property VideoChatStarted $video_chat_started;
 * @property VideoChatEnded $video_chat_ended;
 * @property VideoChatParticipantsInvited $video_chat_participants_invited;
 * @property WebAppData $web_app_data;
 * @property InlineKeyboardMarkup $reply_markup;
 */
class Message extends EntityBase
{
    protected function getEntities(): array
    {
        return [
            'from' => User::class,
            'sender_chat' => Chat::class,
            'sender_business_bot' => User::class,
            'chat' => Chat::class,
            'forward_origin' => MessageOrigin::class,
            'reply_to_message' => Message::class,
            'external_reply' => ExternalReplyInfo::class,
            'quote' => TextQuote::class,
            'reply_to_story' => Story::class,
            'via_bot' => User::class,
            'link_preview_options' => LinkPreviewOptions::class,
            'animation' => Animation::class,
            'audio' => Audio::class,
            'document' => Document::class,
            'paid_media' => PaidMediaInfo::class,
            'sticker' => Sticker::class,
            'story' => Story::class,
            'video' => Video::class,
            'video_note' => VideoNote::class,
            'voice' => Voice::class,
            'contact' => Contact::class,
            'dice' => Dice::class,
            'game' => Game::class,
            'poll' => Poll::class,
            'venue' => Venue::class,
            'location' => Location::class,
            'left_chat_member' => User::class,
            'message_auto_delete_timer_changed' => MessageAutoDeleteTimerChanged::class,
            'pinned_message' => MaybeInaccessibleMessage::class,
            'invoice' => Invoice::class,
            'successful_payment' => SuccessfulPayment::class,
            'refunded_payment' => RefundedPayment::class,
            'users_shared' => UsersShared::class,
            'chat_shared' => ChatShared::class,
            'gift' => GiftInfo::class,
            'unique_gift' => UniqueGiftInfo::class,
            'write_access_allowed' => WriteAccessAllowed::class,
            'passport_data' => PassportData::class,
            'proximity_alert_triggered' => ProximityAlertTriggered::class,
            'boost_added' => ChatBoostAdded::class,
            'chat_background_set' => ChatBackground::class,
            'forum_topic_created' => ForumTopicCreated::class,
            'forum_topic_edited' => ForumTopicEdited::class,
            'forum_topic_closed' => ForumTopicClosed::class,
            'forum_topic_reopened' => ForumTopicReopened::class,
            'general_forum_topic_hidden' => GeneralForumTopicHidden::class,
            'general_forum_topic_unhidden' => GeneralForumTopicUnhidden::class,
            'giveaway_created' => GiveawayCreated::class,
            'giveaway' => Giveaway::class,
            'giveaway_winners' => GiveawayWinners::class,
            'giveaway_completed' => GiveawayCompleted::class,
            'paid_message_price_changed' => PaidMessagePriceChanged::class,
            'video_chat_scheduled' => VideoChatScheduled::class,
            'video_chat_started' => VideoChatStarted::class,
            'video_chat_ended' => VideoChatEnded::class,
            'video_chat_participants_invited' => VideoChatParticipantsInvited::class,
            'web_app_data' => WebAppData::class,
            'reply_markup' => InlineKeyboardMarkup::class,
        ];
    }

    /**
     * Verifica si el mensaje es un comando
     */
    public function isCommand(): bool
    {
        if (isset($this->entities)) {
            return $this->__get('entities')->__get('type') === 'bot_command';
        }

        return false;
    }
}
