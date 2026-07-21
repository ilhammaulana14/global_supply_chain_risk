<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportNews extends Command
{
    protected $signature = 'news:import';

    protected $description = 'Import News from NewsData.io';

    public function handle()
    {
        $this->info('Mengambil berita dari NewsData.io...');

        $response = Http::timeout(60)->get(
            'https://newsdata.io/api/1/news',
            [
                'apikey' => env('NEWSDATA_API_KEY'),
                'q' => 'supply chain',
                'language' => 'en',
            ]
        );

        if (!$response->successful()) {

            $this->error('API gagal diakses.');

            $this->error('Status : '.$response->status());

            return Command::FAILURE;
        }

        $data = $response->json();

        if (!isset($data['results'])) {

            $this->error('Data tidak ditemukan.');

            return Command::FAILURE;
        }

        $count = 0;

        foreach ($data['results'] as $item) {

            News::updateOrCreate(

                [
                    'url' => $item['link'] ?? uniqid(),
                ],

                [
                    'country_id' => null,

                    'title' => $item['title'] ?? '',

                    'description' => $item['description'] ?? '',

                    'source' => $item['source_name'] ?? '',

                    'author' => '',

                    'image' => $item['image_url'] ?? '',

                    'published_at' => $item['pubDate'] ?? now(),
                ]

            );

            $count++;
        }

        $this->info('===================================');
        $this->info('Import News Berhasil');
        $this->info('Data Diproses : '.$count);
        $this->info('Total News : '.News::count());
        $this->info('===================================');

        return Command::SUCCESS;
    }
}
