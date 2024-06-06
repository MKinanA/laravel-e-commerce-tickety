<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): View {
        $events = $this->fetchEvents();
        $categories = $this->fetchCategories();
        return view('frontend.index', compact('events', 'categories'));
    }

    private function fetchEvents(): mixed {
        $category = request()->query('category');
        $events = Event::upcoming();
        if (!request()->has('all_events')) {
            $events->limit(3);
        }
        if ($category) {
            $events->withCategory($category);
        }
        return $events->get();
    }

    private function fetchCategories(): mixed {
        $categories = Category::sortByMostEvents();
        if (!request()->has('all_categories')) {
            $categories->limit(4);
        }
        return $categories->get();
    }
}
