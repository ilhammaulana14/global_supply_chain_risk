<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('country');

        // Search
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('source', 'like', "%{$search}%")
                    ->orWhereHas('country', function ($country) use ($search) {

                        $country->where('name', 'like', "%{$search}%");

                    });

            });

        }

        $news = $query
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.news.index', [

            'news' => $news,

            'totalNews' => News::count(),

            'todayNews' => News::whereDate(
                'published_at',
                today()
            )->count(),

            'totalSources' => News::distinct('source')->count(),

            'latestDate' => optional(
                News::latest('published_at')->first()
            )->published_at,

        ]);
    }

    /**
     * Generate dummy news
     */
    public function generate()
{
    // Hapus data lama (opsional)
    News::truncate();

    $titles = [

        'Industrial Production Rises',
        'Port Congestion Increases',
        'Transport Strike Ends',
        'Heavy Rain Disrupts Logistics',
        'New Trade Agreement Signed',
        'Supply Chain Delays Reported',
        'Export Growth Improves',
        'Import Restrictions Announced',
        'Fuel Prices Increase',
        'Port Expansion Project Begins',

    ];

    $countries = Country::all();

    foreach ($countries as $country) {

        News::create([

            'country_id'   => $country->id,

            'title'        => $titles[array_rand($titles)],

            'description'  => 'Automatically generated news for dashboard presentation.',

            'source'       => 'SCRI System',

            'author'       => 'System',

            'url'          => '#',

            'image'        => null,

            'published_at' => now()->subDays(rand(0, 30)),

        ]);

    }

    return redirect()
        ->route('news.index')
        ->with('success', 'News generated successfully.');
}
}
