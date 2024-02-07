<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $page = $request->input('page') ? $request->input('page') : 1;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 8;
        $skip = $page * $perPage - $perPage;

        // if ($request->genre) {
        //     $movies = Genre::where('title', $request->genre)->take($perPage)->skip($skip)->get();
        // }
        // // $serach = $request->input('search') ? $request->input('search') : null;
        // if ($request->search) {
        //     if ($movies) {
        //         $movies = $movies::where();
        //     } else {
        //         $movies = Movie::take($perPage)->skip($skip)->where('title', 'like', '%' . request('search') . '%')->get();
        //     }
        // }
        // if (!$movies) {
        //     $movies = Movie::take($perPage)->skip($skip)->get();
        // }
        $query = Movie::query();

        // Filter by title
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        // Filter by genre
        if ($request->has('genre')) {
            $query->whereHas('genres', function ($query) use ($request) {
                $query->where('title', $request->input('genre'));
            });
        }

        // Get the filtered movies
        $movies = $query->get();

        // return response()->json($movies);


        $metaData = [
            'metadata' => [
                'total' => Movie::count(),
                'count' => $movies->count(),
                'perPage' => $perPage
            ]
        ];
        return MovieResource::collection($movies)->additional($metaData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        $request->validated();
        $movie = Movie::create($request->only('title', 'description', 'author', 'duration', 'poster_url'));
        $movie->genres()->attach($request->genres);
        return new MovieResource($movie);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new MovieResource(Movie::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
