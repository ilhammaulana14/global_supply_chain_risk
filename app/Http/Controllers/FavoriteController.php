<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Country $country)
    {
        $user = auth()->user();

        if ($user->favoriteCountries()->where('country_id', $country->id)->exists()) {
            $user->favoriteCountries()->detach($country->id);
            $status = 'removed';
            $message = "Country {$country->name} has been removed from your favorite monitoring list.";
        } else {
            $user->favoriteCountries()->attach($country->id);
            $status = 'added';
            $message = "Country {$country->name} has been added to your favorite monitoring list.";
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => $status,
                'message' => $message,
                'is_favorite' => $status === 'added'
            ]);
        }

        return back()->with('success', $message);
    }
}
