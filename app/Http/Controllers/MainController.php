<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Content;
use App\Models\Genre;
use App\Models\Language;
use App\Models\TvCategory;
use App\Models\TvChannel;
use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $movieCount = Content::where('content_type', 1)->count();
        $seriesCount = Content::where('content_type', 2)->count();
        $tvChannel = TvChannel::count();
        $tvCategory = TvCategory::count();
        $genre = Genre::count();
        $language = Language::count();
        $actor = Actor::count();
        $user = User::count();
        return view(
            'index',
            [
                'movie' => $movieCount,
                'series' => $seriesCount,
                'tvChannel' => $tvChannel,
                'tvCategory' => $tvCategory,
                'genre' => $genre,
                'language' => $language,
                'actor' => $actor,
                'user' => $user,
            ]
        );
    }
}
