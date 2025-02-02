<?php

namespace Al3x5\xBot\Entities;

/**
 * User class
 */
class User extends Base
{
    /**
     * Unique identifier for this user or bot. This number may have more 
     * than 32 significant bits and some programming languages may have 
     * difficulty/silent defects in interpreting it. But it has at most 52 
     * significant bits, so a 64-bit integer or double-precision float type are safe 
     * for storing this identifier.
     */
    public int $id;

    /**
     * True, if this user is a bot
     */
    public bool $is_bot;

    /**
     * User's or bot's first name
     */
    public string $first_name;

    /**
     * Optional. User's or bot's last name
     */
    public string $last_name;

    /**
     * Optional. User's or bot's username
     */
    public string $username;

    /**
     * Optional. IETF language tag of the user's language
     */
    public string $language_code;

    /**
     * Optional. True, if this user is a Telegram Premium user

     */
    public bool $is_premium;

    /**
     * Optional. True, if this user added the bot to the attachment menu
     */
    public bool $added_to_attachment_menu;

    /**
     * Optional. True, if the bot can be invited to groups. Returned only in getMe.
     */
    public bool $can_join_groups;

    /**
     * Opcional . True , si el modo de privacidad está deshabilitado para el bot. 
     * Devuelto solo en GetMe .
     */
    public bool $can_read_all_group_messages;

    /**
     * Optional. True, if the bot supports inline queries. Returned only in getMe.
     */
    public bool $supports_inline_queries;

    /**
     * Optional. True, if the bot can be connected to a Telegram Business account to receive its messages. Returned only in getMe.
     */
    public bool $can_connect_to_business;

    /**
     * Optional. True, if the bot has a main Web App. Returned only in getMe.
     */
    public bool $has_main_web_app;

    protected function getEntities(): array
    {
        return [];
    }
}
