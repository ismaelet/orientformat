<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        $public = Storage::disk('public');
        $private = Storage::disk('local');

        foreach ($public->allFiles('masterpieces') as $path) {
            if (! $private->exists($path)) {
                $source = $public->readStream($path);

                if ($source === false || ! $private->writeStream($path, $source)) {
                    throw new RuntimeException("Unable to secure masterpiece file: {$path}");
                }

                if (is_resource($source)) {
                    fclose($source);
                }
            }

            $public->delete($path);
        }
    }
};
