<?php

namespace App\Http\Controllers;

use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Response as HttpResponse;

class GameController extends Controller
{

    protected $service;

    public function __construct()
    {
        $this->service = new GameService();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Game', [
            'uuid' => $request->uuid
        ]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function play(Request $request): JsonResponse
    {
        return response()->json($this->service->game($request->uuid));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function history(Request $request): JsonResponse
    {
        return response()->json($this->service->getHistory($request->uuid));
    }

}
