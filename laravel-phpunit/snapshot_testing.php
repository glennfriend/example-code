<?php

namespace Modules\Contact\Tests\Unit\Console;

use Modules\Account\Entities\Account;
use Modules\Contact\Entities\Contact;
use Tests\TestCase;

class UpdatePublisherTransferNumberFromAccount58Test extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->account = Account::factory()->create();
    }

    /**
     * @test
     * @dataProvider contact_data
     */
    public function should_match_update_contact_data($isMatch, $$createdAt, $publisherName, $number, $dryRun): void
    {
        $contact = Contact::factory()->withAccount($this->account)->create()->refresh();

        $this
            ->artisan('contact:update-publisher-transfer-number-from-account-58', [
                'startDate' => '2000-01-01',
                'endDate' => '2000-01-01',
            ])
            ->expectsQuestion('Do you wish to continue ?', 'yes')
            ->assertExitCode(0);

        $before = $contact->toArray();
        $contact->refresh();
        $after = $contact->toArray();

        $this->assertSame($isMatch, '+18449494876' === $contact->publisher['transfer_number']);
        $this->assertMatchesSnapshotTesting($before, $after, ['updated_at', 'publisher.transfer_number']);
    }

    public function contact_data(): array
    {
        return [
            [true,  '2000-01-02 00:00:00', '326752', '+18884812473', 0],
            [false, '2000-01-01 23:59:59', '326752', '+18884812473', 0],
            [false, '2000-01-01 23:59:59', '123', '+18884812473', 0],
        ];
    }

    /**
     * snapshot testing
     * 
     * 比對自己預期會不同 "以外" 的所有資料, 以確保沒有誤改到預期外的資料
     */
    private function assertMatchesSnapshotTesting(array $before, array $after, array $removeAttributeNames = []): void
    {
        ksort($before);
        ksort($after);
        foreach ($removeAttributeNames as $attributeName) {
            array_forget($before, $attributeName);
            array_forget($after, $attributeName);
        }

        $beforeJson = json_encode($before, JSON_PRETTY_PRINT);
        $afterJson = json_encode($after, JSON_PRETTY_PRINT);
        $this->assertSame($beforeJson, $afterJson);
    }
}
