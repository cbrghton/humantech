<?php

namespace App\Http\Controllers;

use App\Http\Requests\Turn\Destroy;
use App\Http\Requests\Turn\Sync;
use App\Http\Requests\Turn\Find;
use App\Http\Requests\Turn\Store;
use App\Http\Requests\Turn\Update;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Turn as TurnService;

class TurnController extends Controller
{
    /**
     * @var TurnService
     */
    private $turnService;

    /**
     * TurnController constructor
     *
     * @param TurnService $turnService
     */
    public function __construct(TurnService $turnService)
    {
        $this->turnService = $turnService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $turns = $this->turnService->all(
            $request->query('orderBy', 'id'),
            $request->query('order', 'asc'),
            $request->query('perPage', 15)
        );

        if ($turns->isNotEmpty()) {
            return response()->json(
                $turns,
                200
            );
        }

        return response()->error('Error', [ 'turns' => 'not found turns' ], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return JsonResponse
     */
    public function store(Store $request)
    {
        $turn = $this->turnService->create($request->all());

        if ($turn) {
            return response()->json($turn, 201);
        }

        return response()->error('Error', [ 'turns' => 'the turns was not created' ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param Find $request
     * @return JsonResponse
     */
    public function show(Find $request)
    {
        $turn = $this->turnService->find([ 'id' => $request->route('turn') ]);

        if ($turn) {
            return response()->json($turn, 200);
        }

        return response()->error('Error', [ 'turns' => 'the turns doesnt exists' ], 404);
    }

    /**
     * Sync the relation ids
     *
     * @param Sync $request
     * @return JsonResponse
     */
    public function sync(Sync $request)
    {
        $turn = $this->turnService->sync([ 'id' => $request->route('turn') ], $request->input('movies'));

        if ($turn) {
            return response()->json($turn, 200);
        }

        return response()->error('Error', [ 'turns' => 'the turns was not updated' ], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Update $request
     * @return JsonResponse
     */
    public function update(Update $request)
    {
        $turn = $this->turnService->update([ 'id' => $request->route('turn') ], $request->all());

        if ($turn) {
            return response()->json($turn, 200);
        }

        return response()->error('Error', [ 'turns' => 'the turns was not updated' ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Destroy $request
     * @return JsonResponse
     */
    public function destroy(Destroy $request)
    {
        $turn = $this->turnService->delete([ 'id' => $request->route('turn') ]);

        if ($turn >= 1) {
            return response()->json('the turns was deleted', 204);
        }

        return response()->error('Error', [ 'turns' => 'the turns was not deleted' ], 500);
    }
}
