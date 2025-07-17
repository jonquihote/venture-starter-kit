<?php

namespace Venture\Home\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Venture\Home\Models\TemporaryFile;

class TemporaryFileDownloadController extends Controller
{
    public function __invoke(TemporaryFile $file)
    {
        $file->downloads_count++;
        $file->save();

        return Response::download($file->path());
    }
}
