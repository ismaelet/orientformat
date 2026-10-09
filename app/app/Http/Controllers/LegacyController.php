<?php

namespace App\Http\Controllers;

use App\Legacy\Exceptions\LegacyRedirectException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

class LegacyController extends Controller {

    public function __invoke(): SymfonyResponse {
        $initialBufferLevel = ob_get_level();

        ob_start();

        try {
            // Execute legacy application and capture its response
            $result = require app_path('Http/legacy.php');

            // Capture any output from legacy code
            $output = ob_get_contents();

            // Legacy application returned a Laravel/Symfony response
            if ($result instanceof SymfonyResponse) {
                if ($output !== '') {
                    Log::warning('Legacy application produced output alongside a response', [
                        'url' => request()->fullUrl(),
                        'output_length' => strlen($output),
                    ]);
                }

                return $result;
            }

            // Fallback for legacy code that still echoes HTML
            return response($output);
        } catch (LegacyRedirectException $e) {
            return redirect()->to($e->url);
        } catch (Throwable $e) {
            Log::error('Legacy application failed', [
                'exception' => $e,
                'url' => request()->fullUrl(),
                'buffer_level' => ob_get_level(),
                'headers_sent' => headers_sent(),
            ]);

            throw $e;
        } finally {
            // Clean up all buffers created during legacy execution
            while (ob_get_level() > $initialBufferLevel) {
                ob_end_clean();
            }
        }
    }
}
