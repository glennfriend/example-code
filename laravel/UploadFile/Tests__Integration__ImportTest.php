<?php

namespace Modules\Segment\Tests\Integration\Importers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Modules\Account\Entities\Account;
use Modules\AppIntegration\Entities\AvaAppIntegration;
use Modules\Contact\Entities\ContactCustomField;
use Modules\Segment\Formatters\SegmentPayloadFormatter;
use Modules\Segment\Formatters\SegmentRulePayloadFormatter;
use Modules\Segment\Importers\SegmentImporter;
use Modules\Segment\Repositories\SegmentRepository;
use Modules\Segment\UseCases\ImporterVerificationUseCase;
use Modules\Trigger\Repositories\TriggerRepository;
use Tests\TestCase;

final class SegmentImporterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->create();
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * @test import()
     */
    public function create_segment_trigger_action(): void
    {
        $content = <<<'EOD'
Name, Age, Email
alice,20,alice@gmail.com
bob,50,bob@hotmail.com
EOD;
        $result = $this->import($content);
        $this->assertSame(2, $result->count());

        // user
        $user = ($this->userRepository->getByEmail('alice@gmail.com');
        $this->assertSame('alice', $user->name);
    }

    private function import(string $csvContent): Collection
    {
        $file = UploadedFile::fake()->createWithContent('test_file.csv', $csvContent);
        $result = ImporterVerificationUseCase::perform([
            'file'      => $file,
            'accountId' => $this->account->id,
        ]);
        $cacheId = $result['id'];
        $this->segmentImporter = app(SegmentImporter::class);
        return $this->segmentImporter->import($cacheId);
    }
}