<?php
// app/Services/ShowService.php

namespace App\Services;

use App\Models\Show;
use App\Enums\ShowType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShowService
{

    public function getMoviesCount()
    {
        return Show::where('type', ShowType::Movie)->count();
    }
    public function getTVShowsCount()
    {
        return Show::where('type', ShowType::TVShow)->count();
    }
    public function getShows()
    {
        return Show::get()->paginate(10);
    }

    public function getMovies($perPage = 10)
    {
        return Show::where('type', ShowType::Movie)->paginate($perPage);
    }

    public function getTVShows($perPage = 10)
    {
        return Show::where('type', ShowType::TVShow)->paginate($perPage);
    }


    public function searchShowsbyTitle(array $data)

    {

        $rules = [
            'title' => 'required|string|min:2|max:255',
        ];

        $messages = [
            'title.required' => __('Title is required'),
            'title.min' => __('Title should be at least 2 characters'),
            'title.max' => __('Title should be at most 255 characters'),
        ];
        $validated_title = Validator::validate($data, $rules, $messages);

        return Show::where('title', 'like', '%' . $validated_title['title'] . '%')->get();
    }


    public function filterShows(array $data)
    {
        $rules = [
            'title' => 'nullable|string|min:2|max:255',
            'release_year' => 'nullable|integer|max:2024',
            'rating' => [
                'nullable',
                'string',
                'in:66 min,74 min,84 min,G,NC-17,NR,PG,PG-13,R,TV-14,TV-G,TV-MA,TV-PG,TV-Y,TV-Y7,TV-Y7-FV,UR',
            ],
            'type' => 'nullable|string|in:Movie,TV Show',
        ];
        $messeges = [
            'title.min' => __('Title should be at least 2 characters'),
            'title.max' => __('Title should be at most 255 characters'),
            'release_year.max' => __('Release year should be at most 2021'),
            'rating.in' => __('Rating should be one of the following: 66 min,74 min,84 min,G,NC-17,NR,PG,PG-13,R,TV-14,TV-G,TV-MA,TV-PG,TV-Y,TV-Y7,TV-Y7-FV,UR'),
            'type.in' => __('Type should be one of the following: Movie,TV Show'),
        ];
        $validated_filters = Validator::validate($data, $rules, $messeges);

        $query = Show::query();

        if (isset($validated_filters['title']) && $validated_filters['title']!= null ) {
            $query->where('title', 'like', '%' . $validated_filters['title'] . '%');
        }

        if (isset($validated_filters['release_year']) && $validated_filters['release_year'] != null) {
            $query->where('release_year', $validated_filters['release_year']);
        }

        if (isset($validated_filters['rating']) && $validated_filters['rating'] != null) {
            $query->where('rating', $validated_filters['rating']);
        }

        if (isset($validated_filters['type']) && $validated_filters['type'] != null) {
            $query->where('type', $validated_filters['type']);
        }

        return $query->get();
    }

    public function showDetails($id)
    {

            $show = Show::findOrFail($id);

            if(!$show){
                return response()->json([
                    'message' => 'Show not found'
                ], 404);
            }

            return response()->json([
                'id' => $show->id,
                'title' => $show->title,
                'description' => $show->description,
            ]);



    }
    public function showTrailer($id)
    {
        $show = Show::findOrFail($id);
        if(!$show){
            return response()->json([
                'message' => 'Show not found'
            ], 404);
        }

        return response()->json($show->trailer_url,201);
    }

}
