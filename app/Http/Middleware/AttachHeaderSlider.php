<?php

namespace App\Http\Middleware;

use App\Services\HomeService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AttachHeaderSlider
{
    protected $homeService;

    /**
     * Inject the HomeService dependency.
     *
     * @param \App\Services\HomeService $homeService
     */
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the first Header Slider
        $headerSlider = $this->homeService->getFirstSlider();

        // Share the slider with all views
        View::share('headerSlider', $headerSlider);

        return $next($request);
    }
}