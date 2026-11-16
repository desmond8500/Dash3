<?php

namespace App\Http\Controllers;

use App\Models\TechReport;
use App\Models\TechShare;
use Illuminate\Support\Facades\Storage;

/** Fichiers privés de l'espace technicien, servis aux utilisateurs Dash3 (permission erp). */
class TechFileController extends Controller
{
    public function reportPhoto(TechReport $report, int $photo)
    {
        $photo = $report->photos()->findOrFail($photo);
        abort_unless(Storage::disk('local')->exists($photo->path), 404);

        return Storage::disk('local')->response($photo->path);
    }

    public function shareFile(TechShare $share)
    {
        abort_unless($share->file_path && Storage::disk('local')->exists($share->file_path), 404, 'Fichier expiré ou absent');

        return Storage::disk('local')->download($share->file_path, $share->file_name);
    }
}
