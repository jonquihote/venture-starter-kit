<?php

namespace Venture\Home\Http\Controllers;

use App\Http\Controllers\Controller;
use Venture\Home\Models\Attachment;

class AttachmentDownloadController extends Controller
{
    public function __invoke(Attachment $attachment)
    {
        $attachment->downloads_count++;
        $attachment->save();

        return response()->download($attachment->mediaPath());
    }
}
