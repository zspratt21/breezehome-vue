<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\User;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard');
    }

    public function searchUsers(SearchRequest $request): Collection
    {
        return User::search($request->validated('query'))->get()->map(function ($user) {
            return User::toSearchable($user);
        });
    }
}
