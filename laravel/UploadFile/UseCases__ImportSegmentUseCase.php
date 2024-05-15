<?php

namespace Modules\Segment\UseCases;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Import\Parsers\CSVParser;
use Modules\Segment\Entities\Segment;
use Modules\Segment\Importers\SegmentImporter;
use Modules\Segment\ValueObjects\SegmentImportResource;
use OnrampLab\CleanArchitecture\UseCase;
use OnrampLab\CleanArchitecture\ValidationAttributes\UnsignedInteger;

/**
 * @method static Segment perform(mixed $args)
 */
class ImportSegmentUseCase extends UseCase
{
    #[UnsignedInteger]
    public int $accountId;

    public UploadedFile $file;

    public function handle(): array
    {
        $originSegmentImportResources = $this->getSegmentImportResources();
        $segmentImporter = new SegmentImporter();
        $segmentImportResources = $segmentImporter->verify($originSegmentImportResources);

        if ($segmentImporter->isVerifySucceed()) {
            $uuid = Str::uuid()->toString();
            Cache::put($uuid, $segmentImportResources, 3600);
        }

        return [
            'id'     => $uuid ?? null,
            'result' => $segmentImportResources->toArray(),
        ];
    }

    private function getSegmentImportResources(): Collection
    {
        $resources = collect();
        foreach ($this->getCSVRows() as $row) {
            $resource = new SegmentImportResource(array_merge(
                $row->toArray(),
                [
                    'account_id' => $this->accountId,
                    'app_integration_id' => $this->appIntegrationId,
                ]
            ));
            $resources->push($resource);
        }
        return $resources;
    }

    private function getCSVRows(): Collection
    {
        $parser = new CSVParser($this->file);
        $rows = $parser->parse();
        return $rows[0];
    }
}
