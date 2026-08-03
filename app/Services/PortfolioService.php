<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Blog;
use App\Models\Music;

class PortfolioService
{
    /**
     * Get all data required for the home page.
     *
     * @return array
     */
    public function getHomeData(): array
    {
        // Business logic to fetch data, potentially cache it, filter active ones, etc.
        $projects = Project::with('category')->latest()->take(6)->get();
        $experiences = Experience::orderBy('start_date', 'desc')->get();
        $skills = Skill::with('category')->orderBy('percentage', 'desc')->get();
        $latestBlogs = Blog::latest()->take(3)->get();
        $musics = Music::where('is_active', true)->get();

        return [
            'projects' => $projects,
            'experiences' => $experiences,
            'skills' => $skills,
            'blogs' => $latestBlogs,
            'musics' => $musics,
        ];
    }
}
