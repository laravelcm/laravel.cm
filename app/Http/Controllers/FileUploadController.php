<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

final class FileUploadController extends Controller
{
    public function process(Request $request): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        /** @var UploadedFile[] $files */
        $files = $request->allFiles();

        if (empty($files)) {
            abort(422, __('Aucun fichier n\'a été uploader'));
        }

        if (count($files) > 1) {
            abort(422, __('Un seul fichier peut être téléchargé à la fois.'));
        }

        $requestKey = array_key_first($files);

        $file = is_array($request->input($requestKey))
            ? $request->file($requestKey)[0] // @phpstan-ignore-line
            : $request->file($requestKey);

        $user->addMedia($file)->toMediaCollection('avatar');
        $user->avatar_type = 'storage';
        $user->save();
    }
}
