<?php

namespace App\Http\Controllers;

use App\Http\Requests\Movie\Destroy;
use App\Http\Requests\Movie\Find;
use App\Http\Requests\Movie\Store;
use App\Http\Requests\Movie\Sync;
use App\Http\Requests\Movie\Update;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Movie as MovieService;

class MovieController extends Controller
{
    /**
     * Instance of MovieService
     *
     * @var MovieService
     */
    private $movieService;

    /**
     * MovieController constructor
     *
     * @param MovieService $movieService
     */
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $movies = $this->movieService->all(
            $request->query('orderBy', 'id'),
            $request->query('order', 'asc'),
            $request->query('perPage', 15)
        );

        if ($movies->isNotEmpty()) {
            return response()->json(
                $movies,
                200
            );
        }

        return response()->error('Error', [ 'movies' => 'not found movies' ], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return JsonResponse
     */
    public function store(Store $request)
    {
        $movie = $this->movieService->create($request->all());

        if ($movie) {
            return response()->json($movie, 201);
        }

        return response()->error('Error', [ 'movies' => 'the movies was not created' ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param Find $request
     * @return JsonResponse
     */
    public function show(Find $request)
    {
        $movie = $this->movieService->find([ 'id' => $request->route('movie') ]);

        if ($movie) {
            return response()->json($movie, 200);
        }

        return response()->error('Error', [ 'movies' => 'the movies doesnt exists' ], 404);
    }

    /**
     * Sync the relation ids
     *
     * @return JsonResponse
     */
    public function sync(Sync $request)
    {
        $movie = $this->movieService->sync([ 'id' => $request->route('movie') ], $request->input('turns'));

        if ($movie) {
            return response()->json($movie, 200);
        }

        return response()->error('Error', [ 'movies' => 'the movies was not updated' ], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Update $request
     * @return JsonResponse
     */
    public function update(Update $request)
    {
        $movie = $this->movieService->update([ 'id' => $request->route('movie') ], $request->all());

        if ($movie) {
            return response()->json($movie, 200);
        }

        return response()->error('Error', [ 'movies' => 'the movies was not updated' ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Destroy $request
     * @return JsonResponse
     */
    public function destroy(Destroy $request)
    {
        $movie = $this->movieService->delete([ 'id' => $request->route('movie') ]);

        if ($movie >= 1) {
            return response()->json('the movies was deleted', 204);
        }

        return response()->error('Error', [ 'movies' => 'the movie was not deleted' ], 500);
    }
}
