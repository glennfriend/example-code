<?php

namespace Modules\Core\ValueObjects;

/**
 * Eddie build it
 */
class URL
{
    private string $text;

    public function __construct(string $text)
    {
        if (!URL::is($text)) {
            throw new \InvalidArgumentException("{$text} is not valid URL");
        }

        $this->text = $text;
    }

    public static function is(string $text): bool
    {
        return filter_var($text, FILTER_VALIDATE_URL) !== false;
    }

    public function __toString(): string
    {
        return $this->text;
    }
}