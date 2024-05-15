<?php

namespace Modules\Demo\ValueObjects;

use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule as IlluminateRule;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

enum HappyStatus: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
}

#[MapName(SnakeCaseMapper::class)]
class HappyResource extends Data
{
    public readonly string $fullName;

    /**
     * @throws Exception
     */
    public function __construct(
        public readonly int $accountId,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly HappyStatus $status,
        public readonly array $options = [],
    )
    {
        $this->fullName = $lastName . ' ' . $firstName;

        $this->validator();
    }

    /**
     * @throws Exception
     */
    private function validator(): void
    {
        $validator = Validator::make([
            'last_name' => $this->lastName,
            'options' => $this->options,
        ], [
            'last_name' => ['nullable', IlluminateRule::in(['Michael', 'Chen'])],
            'options' => ['array', 'nullable'],
        ]);

        if ($validator->fails()) {
            $fieldName = key($validator->failed());
            throw new Exception('validate failed: ' . $fieldName);
        }
    }
}
