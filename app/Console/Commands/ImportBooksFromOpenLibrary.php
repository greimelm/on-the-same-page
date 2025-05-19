<?php
// example book importer by ISBN; testing importer

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;


class ImportBooksFromOpenLibrary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-books-from-open-library';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //the woman in me, the will to change, the colour purple
        $isbns = ['9781668009062', '0743456076', '9782290021231'];

        foreach ($isbns as $isbn) {
            $url = "https://openlibrary.org/api/books?bibkeys=ISBN:$isbn&format=json&jscmd=data";
            $response = Http::get($url)->json();

            $bookData = $response["ISBN:$isbn"] ?? null;
            if ($bookData) {
                \App\Models\Book::updateOrCreate(
                    ['isbn' => $isbn],
                    [
                        'title' => $bookData['title'] ?? 'Unknown',
                        'author' => $bookData['authors'][0]['name'] ?? null,
                        'description' => $bookData['notes'] ?? null,
                        'cover_image' => $bookData['cover']['medium'] ?? null,
                    ]
                );
            }
        }
        $this->info("Books imported successfully!");
    }
}
