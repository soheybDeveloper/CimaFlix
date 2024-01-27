<?php

namespace App\Http\Controllers;

use App\Services\ShowService;
use Illuminate\Http\Request;

class ShowsController extends Controller
{
    private ShowService $showService;
    //constructor
    public function __construct()
    {
        $this->showService = new ShowService();
    }


    // get count of movies
    public function getMoviesCount()
    {
        $moviesCount = $this->showService->getMoviesCount();
        return response($moviesCount, 201);
    }
    // get count of tv shows
    public function getTVShowsCount()
    {
        $tvShowsCount = $this->showService->getTVShowsCount();
        return response($tvShowsCount, 201);
    }
     public function getMovies()
     {

         $movies = $this->showService->getMovies();
         return response($movies, 201);
     }
     public function getTvShows()
     {
         $tvShows = $this->showService->getTVShows();
         return response($tvShows, 201);
     }
     public function getShowDetails($id)
     {

       $response=  $this->showService->showDetails($id);
         return $response;
     }
     public function getShowTrailer($id)
     {
         $response=  $this->showService->showTrailer($id);
         return $response;
     }
     public function searchShowsbyTitle(Request $request)
     {
         $shows = $this->showService->searchShowsbyTitle($request->all());
         return response($shows, 201);
     }

    public function index()
    {
        $shows = $this->showService->getShows();
        return response($shows, 201);
    }
    public function filter(Request $request)
    {
        $filters = $request->only(['title', 'release_year', 'rating', 'type']);


        $filteredShows = $this->showService->filterShows($filters);

        return response()->json($filteredShows, 201);
    }
}
