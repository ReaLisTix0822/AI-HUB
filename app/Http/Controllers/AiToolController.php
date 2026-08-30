<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\AiTool;
use Illuminate\Http\Request;

class AiToolController extends Controller
{
    /**
     * Display the home directory page with all tools, categories, and task tags.
     */
    public function index(Request $request)
    {
        $categories = Category::withCount('aiTools')->orderBy('order')->get();
        
        $query = AiTool::with('category')->orderBy('popularity_score', 'desc');

        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('pricing') && $request->pricing !== 'all') {
            $query->where('pricing_type', $request->pricing);
        }

        if ($request->filled('q')) {
            $term = '%' . $request->q . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('tagline', 'like', $term)
                  ->orWhere('tagline_th', 'like', $term)
                  ->orWhere('description', 'like', $term)
                  ->orWhere('description_th', 'like', $term)
                  ->orWhere('best_for', 'like', $term)
                  ->orWhere('best_for_th', 'like', $term);
            });
        }

        $tools = $query->get();
        $allToolsForJs = AiTool::with('category')->orderBy('popularity_score', 'desc')->get();

        // Collect popular task shortcuts for task-based recommendation matching
        $popularTasks = [
            ['key' => 'coding', 'name_th' => 'เขียนโค้ด & สร้างเว็บ', 'name_en' => 'Coding & Web Dev', 'icon' => 'code'],
            ['key' => 'image_gen', 'name_th' => 'สร้างภาพ & งานกราฟิก', 'name_en' => 'Image Gen & Art', 'icon' => 'image'],
            ['key' => 'video_gen', 'name_th' => 'สร้างวิดีโอ & แอนิเมชัน', 'name_en' => 'Video Creation', 'icon' => 'video'],
            ['key' => 'voiceover', 'name_th' => 'พากย์เสียง & โคลนเสียง', 'name_en' => 'Voiceover & Cloning', 'icon' => 'mic'],
            ['key' => 'music_generation', 'name_th' => 'แต่งเพลง & ดนตรี', 'name_en' => 'Music Generation', 'icon' => 'music'],
            ['key' => 'research', 'name_th' => 'ค้นคว้า & สรุปเอกสาร PDF', 'name_en' => 'Research & PDF Summary', 'icon' => 'search'],
            ['key' => 'presentation', 'name_th' => 'ทำสไลด์ & พรีเซนเทชัน', 'name_en' => 'Slide Presentations', 'icon' => 'presentation'],
            ['key' => 'writing', 'name_th' => 'เขียนบทความ & แคปชัน', 'name_en' => 'Copywriting & Content', 'icon' => 'pen-tool'],
        ];

        return view('home', compact('categories', 'tools', 'allToolsForJs', 'popularTasks'));
    }

    /**
     * Show detail page or json response for a specific AI tool.
     */
    public function show($slug, Request $request)
    {
        $tool = AiTool::with('category')->where('slug', $slug)->firstOrFail();
        $relatedTools = AiTool::where('category_id', $tool->category_id)
            ->where('id', '!=', $tool->id)
            ->limit(4)
            ->get();

        if ($request->wantsJson()) {
            return response()->json([
                'tool' => $tool,
                'related' => $relatedTools,
            ]);
        }

        return view('tool-detail', compact('tool', 'relatedTools'));
    }

    /**
     * API for search and filtering.
     */
    public function apiSearch(Request $request)
    {
        $query = AiTool::with('category');

        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('pricing') && $request->pricing !== 'all') {
            $query->where('pricing_type', $request->pricing);
        }

        if ($request->filled('task')) {
            $query->whereJsonContains('tasks', $request->task);
        }

        if ($request->filled('q')) {
            $term = '%' . $request->q . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('tagline', 'like', $term)
                  ->orWhere('tagline_th', 'like', $term)
                  ->orWhere('description_th', 'like', $term);
            });
        }

        $tools = $query->orderBy('popularity_score', 'desc')->get();

        return response()->json($tools);
    }
}
