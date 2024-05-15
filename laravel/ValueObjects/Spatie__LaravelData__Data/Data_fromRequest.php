<?php

namespace Modules\Demo\ValueObjects;

use Exception;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

/**
 * 未經測試 
 */
class HappyResource extends Data
{
    public readonly string $fullName;

    public function __construct(
        public readonly int $accountId,
        /** @var DataCollection<TagData> */
        public readonly null|Lazy|DataCollection $tags,
    )
    {
    }

    public static function fromRequest(Request $request): void
    {
        return self::from([
            ...$request->all(),
            'tags' => Tag::whereIn('id', $request->tag_ids)->get(),
        ])
    }
}
