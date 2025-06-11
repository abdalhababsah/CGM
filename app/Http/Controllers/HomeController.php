<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch the Coming Soon items
        $commingSoons = $this->homeService->getComingSoonItems();

        // Render the home page with Coming Soon items
        return view('home', compact('commingSoons'));
    }
}