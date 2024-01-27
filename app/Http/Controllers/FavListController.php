<?php

namespace App\Http\Controllers;

use App\Models\FavoriteList;

use Illuminate\Support\Facades\Auth;

class FavListController extends Controller
{

    public function pushShow($idshow)
    {
        $fav = $this->getFavList();

        // Check if the show is already in the favorite list
        if (!$fav->shows->contains($idshow)) {
            $fav->shows()->attach($idshow);
            return response('The show is added to your favorite list', 201);
        }

        return response('The show is already in your favorite list', 200);
    }

    public function popShow($idshow)
    {
        $fav = $this->getFavList();

        // Check if the show is in the favorite list before detaching
        if ($fav->shows->contains($idshow)) {
            $fav->shows()->detach($idshow);
            return response('The show is removed from your favorite list', 201);
        }

        return response('The show is not in your favorite list', 200);
    }

    private function getFavList() :FavoriteList
    {
        return Auth::user()->FavoriteList;

    }
    public function getFavListBody()
    {
        $FavShows=Auth::user()->FavoriteList->shows;
        return response(['Favorite list'=>$FavShows], 200);
    }


    public function createFavList($name)
    {
        $user = Auth::user();


        $existingList = $user->FavoriteList()->where('name', $name)->first();

        if ($existingList) {

            return response('You already have a favorite list named "" ' . $existingList->name. ' "" , created at '.$existingList->created_at, 200);
        }


        $favList = new FavoriteList();
        $favList->name = $name;
        $user->FavoriteList()->save($favList);

        return response('Favorite list is created: ' . $name, 201);
    }




}
