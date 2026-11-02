<?php

namespace App\Http\Controllers;

use App\Legacy\Exceptions\LegacyRedirectException;
use App\Legacy\LegacyRoute;
use App\Models\Activities\Area;
use App\Models\Activities\Section;
use App\Services\LegacyPageRenderer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

class LegacyController extends Controller
{
    public function __invoke(): SymfonyResponse
    {
        return $this->execute(fn () => LegacyRoute::run());
    }

    public function landing(): SymfonyResponse
    {
        return redirect()->route('login');
    }

    public function wait(): SymfonyResponse
    {
        return $this->execute(function () {
            if (user()->status) {
                return redirect()->route('home');
            }

            return app(LegacyPageRenderer::class)->render(
                page: 'access/wait',
                title: 'Attendi',
                middlewares: ['public', 'logged'],
            );
        });
    }

    public function addEmail(): SymfonyResponse
    {
        return $this->execute(function () {
            if (user()->email) {
                return redirect()->route('home');
            }

            return app(LegacyPageRenderer::class)->render(
                page: 'access/add-email',
                template: 'form',
                title: 'Aggiungi il tuo indirizzo e-mail',
                middlewares: ['public', 'logged'],
            );
        });
    }

    public function tutorial(): SymfonyResponse
    {
        return $this->execute(fn () => app(LegacyPageRenderer::class)->render(
            page: 'support',
            title: 'Supporto',
        ));
    }

    public function interest(): SymfonyResponse
    {
        return $this->execute(function () {
            add_grade_style();

            return app(LegacyPageRenderer::class)->render(
                page: 'interest',
                middlewares: ['logged'],
            );
        });
    }

    public function review(): SymfonyResponse
    {
        return $this->execute(function () {
            add_grade_style();

            return app(LegacyPageRenderer::class)->render(
                page: 'review',
                middlewares: ['public', 'student', 'logged', 'active', 'required-email'],
            );
        });
    }

    public function knowMore(): SymfonyResponse
    {
        return $this->execute(fn () => app(LegacyPageRenderer::class)->render(
            page: 'teacher/know-more',
            title: 'Saperne di più',
            middlewares: ['public', 'teacherOrAdministrator'],
        ));
    }

    public function paths(): SymfonyResponse
    {
        return $this->execute(fn () => app(LegacyPageRenderer::class)->render(
            page: 'teacher/paths',
            title: 'Percorsi',
            middlewares: ['public', 'teacherOrAdministrator'],
        ));
    }

    public function read(Request $request): SymfonyResponse
    {
        return $this->execute(function () use ($request) {
            $sectionId = $request->query('id');
            $areaId = $request->query('area-id');
            $slug = $sectionId
                ? Section::query()->whereKey($sectionId)->value('slug')
                : ($areaId ? Area::query()->whereKey($areaId)->value('slug') : null);

            if (! $slug) {
                return redirect()->route('home');
            }

            $page = $sectionId ? $slug : 'area-'.$slug;

            return app(LegacyPageRenderer::class)->render(
                page: 'read/'.$page,
                template: 'read',
            );
        });
    }

    protected function initializeLegacy(): void
    {
        require_once base_path('legacy/system/setup/setup.php');
    }

    protected function execute(Closure $action): SymfonyResponse
    {
        $initialBufferLevel = ob_get_level();

        ob_start();

        try {
            $this->initializeLegacy();
            $result = $action();

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
