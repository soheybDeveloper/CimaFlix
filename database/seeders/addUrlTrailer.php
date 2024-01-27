<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class addUrlTrailer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update the trailer_url for a specific show
        $showId = 2328;
        $trailerUrl = 'https://www.youtube.com/watch?v=rrwycJ08PSA&ab_channel=ONEMedia';

        // Find the show by ID and update the trailer_url
        DB::table('shows')->where('id', $showId)->update(['trailer_url' => $trailerUrl]);


    }
}
