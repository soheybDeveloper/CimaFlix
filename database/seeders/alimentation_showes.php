<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class alimentation_showes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Specify the path to your CSV file
        $file = fopen(base_path('database/csv/Netflix_Dataset_exported.csv'), 'r');
        $header = true;

        while (($data = fgetcsv($file)) !== false) {
            if ($header) {
                $header = false;
                continue;
            }

            DB::table('shows')->insert([
                'type' => $data[1],
                'title' => $data[2],
                'director' => $data[3],
                'cast' => $data[4],
                'country' => $data[5],
                'date_added' => $data[6],
                'release_year' => $data[7],
                'rating' => $data[8],
                'duration' => $data[9],
                'listed_in' => $data[10],
                'description' => $data[11],
                // Add other columns as needed
            ]);
        }

        fclose($file);
    }
}
