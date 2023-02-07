<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\UsersService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new UsersService();
    }

    /**
     * Display the registration view.
     */
    public function index(): Response
    {
        return Inertia::render('Register');
    }


    /** Create new user and redirect it to unique link
     * @param RegisterRequest $request
     * @return RedirectResponse
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        return $this->service->createNewUser(
            $request->input('name'),
            $request->input('phone')
        );
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        return $this->service->regenerateLink($request->uuid);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        return $this->service->disableLink($request->uuid);
    }
}
