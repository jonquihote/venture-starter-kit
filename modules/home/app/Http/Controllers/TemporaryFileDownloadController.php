<?php

namespace Venture\Home\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Venture\Home\Models\TemporaryFile;

class TemporaryFileDownloadController extends Controller
{
    public function __invoke(TemporaryFile $file)
    {
        return Response::download($file->path());
    }
}
