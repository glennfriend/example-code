<?php

namespace Modules\Segment\Http\Controllers;

use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Account;
use Modules\Segment\Entities\Segment;

class ImportController extends Controller
{
    public function verify(ImportVerificationRequest $request, int $accountId): JsonResponse
    {
        $data = $request->validated();
        $result = ImporterVerificationUseCase::perform([
            'accountId' => $accountId,
            'file' => $data['file']
        ]);

        return response()->json(['data' => $result]);
    }

    public function getImportExample(Request $request): BinaryFileResponse
    {
        return response()->file(base_path('Modules/Segment/Documents/import_segment_example.csv'));
    }

    /**
     * upload 應該要由一支獨立的 API 來完成
     * 其它 controller 只需要從 $fileId = 'j6oqiw4gb5oamnr7os8' 拿檔案內容即可
     */
    private function uploadFile(UploadedFile $file)
    {
    }
}
