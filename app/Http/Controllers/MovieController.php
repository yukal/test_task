<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Movie;
use App\Models\Genre;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Requests\PublishMovieRequest;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $isShowUnpublished = false;
        $movies = Movie::where('is_published', 1)->paginate(10);
        $statuses = Movie::getStatuses();

        return view('movies.index', compact('movies', 'statuses', 'isShowUnpublished'))
            ->with('i', ($request->input('page', 1) - 1) * $movies->perPage());
    }

    /**
     * Display a listing of the resource.
     */
    public function unpublished(Request $request): View
    {
        $isShowUnpublished = true;
        $movies = Movie::where('is_published', 0)->paginate(10);
        $statuses = Movie::getStatuses();

        return view('movies.index', compact('movies', 'statuses', 'isShowUnpublished'))
            ->with('i', ($request->input('page', 1) - 1) * $movies->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $genres = Genre::All();
        return view('movies.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request): RedirectResponse
    {
        $fields = $request->validated();

        if (isset($fields['image'])) {
            // $fields['poster'] = $request->image->storePublicly('movies', 'local');
            $fields['poster'] = $request->image->storePublicly('movies', 'public');
        }

        $movie = Movie::create($fields);
        $movie->genres()->sync($fields['genres']);

        return redirect()->route('movies.index', ['unpublished' => 1])
            ->with('success', 'Movie created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie): View
    {
        $movie->append(['statusText']);
        return view('movies.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie): View
    {
        $genres = Genre::All();
        $statuses = Movie::getStatuses();
        $movie->append(['_genresMap']);

        return view('movies.edit', compact('movie', 'genres', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie): RedirectResponse
    {
        $fields = $request->validated();

        if (isset($fields['image'])) {
            if ($movie->existImage) {
                Storage::disk('public')->delete($movie->poster);
            }

            $fields['poster'] = $request->image->storePublicly('movies', 'public');
        }

        if (count($fields) > 0) {
            $movie->update($fields);

            if (isset($fields['genres'])) {
                $movie->genres()->sync($fields['genres']);
            }
        }

        return redirect()
            ->route('movies.index')
            ->with('success', 'Movie updated successfully');
    }

    /**
     * Publish movie.
     */
    public function publish(PublishMovieRequest $request, Movie $movie): RedirectResponse
    {
        $movie->update($request->validated());

        return redirect()->route('movies.index')
            ->with('success', 'Movie published successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        $fs = Storage::disk('public');

        if (!empty($movie->poster) && $fs->exists($movie->poster)) {
            $fs->delete($movie->poster);
        }

        $movie->delete();

        return redirect()->route('movies.index')
            ->with('success', 'Movie deleted successfully');
    }
}
