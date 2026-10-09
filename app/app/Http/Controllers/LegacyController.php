<?php

namespace App\Http\Controllers;

use App\Legacy\Exceptions\LegacyRedirectException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class LegacyController extends Controller {
    public function __invoke(): Response|RedirectResponse {
        $initialBufferLevel = ob_get_level();

        ob_start();

        try {
            require app_path('Http/legacy.php');

            return response(ob_get_contents());
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
            while (ob_get_level() > $initialBufferLevel) {
                ob_end_clean();
            }
        }
    }
}
