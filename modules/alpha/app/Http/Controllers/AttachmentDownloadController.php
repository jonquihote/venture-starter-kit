<?php

namespace Venture\Alpha\Http\Controllers;

use App\Http\Controllers\Controller;
use Venture\Alpha\Models\Attachment;

class AttachmentDownloadController extends Controller
{
    public function __invoke(Attachment $attachment)
    {
        $attachment->downloads_count++;
        $attachment->save();

        return response()->download($attachment->mediaPath());
    }
}
