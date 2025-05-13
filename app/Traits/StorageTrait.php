<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait StorageTrait
{
    public function makeDirectory($directory)
    {
        if (!Storage::exists($directory)) {
            return Storage::makeDirectory($directory, 0755, true);
        } else {
            return false;
        }
    }

    public function updateRecursivePermissions($path, $permission)
    {
        $dirPath = Storage::path($path);
        shell_exec("chmod -R $permission " . escapeshellarg($dirPath));
    }
}
