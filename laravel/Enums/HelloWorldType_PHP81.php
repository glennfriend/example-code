<?php

namespace Modules\______\Enums;

/**
 *  enum example
 *      InterestType::READ_BOOK->name                           // READ_BOOK
 *      InterestType::READ_BOOK->value                          // 7
 *      InterestType::READ_BOOK->label()                        // read_book
 *      InterestType::getLabel(InterestType::READ_BOOK)         // read_book
 *      InterestType::from('read_book')->value                  // 7
 *      InterestType::from('read_book')->label()                // read_book
 *
 *  error:
 *      UserListType::from('xxxx')
 *          -> ValueError: "xxxx" is not a valid backing value for enum "App\Enums\InterestType"
 *
 *      UserListType::tryFrom('non-exists-key')
 *          -> ErrorException: Attempt to read property "name" on null
 *
 */
enum InterestType: int
{
    case MOVIE = 1;
    case READ_BOOK = 7;

    public function label(): string
    {
        return static::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::MOVIE     => 'movie',
            self::READ_BOOK => 'read_book',
        };
    }
}
