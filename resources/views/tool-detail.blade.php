@extends('layouts.app')

@section('title', ($tool->name ?? 'AI Tool') . ' — รายละเอียดและความสามารถ AI')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <!-- Back Button -->
    <div>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-medium text-zinc-500 hover:text-black dark:hover:text-white transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>กลับสู่หน้าหลัก</span>
        </a>
    </div>

    <!-- Main Tool Header Card -->
    <div class="rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 sm:p-10 shadow-sm space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-zinc-100 dark:border-zinc-800">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-zinc-100/90 dark:bg-zinc-800 border border-zinc-200/80 dark:border-zinc-700/60 p-3.5 flex items-center justify-center shadow-md overflow-hidden shrink-0">
                    <div class="w-full h-full flex items-center justify-center" x-html="getLogoSvg('{{ $tool->slug }}', '{{ $tool->name }}')"></div>
                </div>
                <div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-zinc-900 dark:text-white">{{ $tool->name }}</h1>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-mono uppercase tracking-wider font-semibold border bg-zinc-100 text-zinc-800 border-zinc-300 dark:bg-zinc-800 dark:text-zinc-200 dark:border-zinc-700">
                            {{ $tool->pricing_type }}
                        </span>
                    </div>
                    <p class="text-sm sm:text-base text-zinc-500 dark:text-zinc-400 mt-1">{{ $tool->tagline_th ?: $tool->tagline }}</p>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center gap-3">
                <button @click="toggleFavorite({{ $tool->id }}, $event)"
                        class="p-3 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                        :title="isFavorite({{ $tool->id }}) ? 'ลบออกจากรายการโปรด' : 'เพิ่มในรายการโปรด'">
                    <i data-lucide="heart" class="w-5 h-5" :class="isFavorite({{ $tool->id }}) ? 'text-zinc-950 dark:text-white fill-zinc-950 dark:fill-white' : 'text-zinc-400 dark:text-zinc-500'"></i>
                </button>
                <a href="{{ $tool->website_url }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="px-6 py-3 rounded-2xl bg-black text-white dark:bg-white dark:text-black hover:opacity-85 font-semibold text-sm inline-flex items-center gap-2 shadow-sm transition-all">
                    <span>ไปยังเว็บไซต์ทางการ</span>
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        <!-- Best for -->
        @if($tool->best_for_th || $tool->best_for)
        <div class="p-4 rounded-2xl bg-zinc-100 dark:bg-zinc-800/60 border border-zinc-200/80 dark:border-zinc-700/60 flex items-start gap-3">
            <i data-lucide="award" class="w-5 h-5 text-zinc-900 dark:text-zinc-100 shrink-0 mt-0.5"></i>
            <div>
                <h4 class="text-xs font-mono uppercase tracking-wider font-bold text-zinc-500 dark:text-zinc-400">เหมาะสำหรับ</h4>
                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 mt-0.5">{{ $tool->best_for_th ?: $tool->best_for }}</p>
            </div>
        </div>
        @endif

        <!-- Description -->
        <div class="space-y-3">
            <h3 class="text-sm font-mono font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">ภาพรวมและความสามารถ</h3>
            <p class="text-base text-zinc-700 dark:text-zinc-300 leading-relaxed">{{ $tool->description_th ?: $tool->description }}</p>
        </div>

        <!-- Features -->
        @if(!empty($tool->features_th) || !empty($tool->features))
        <div class="space-y-4">
            <h3 class="text-sm font-mono font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">จุดเด่นที่น่าสนใจ</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach(($tool->features_th ?: $tool->features) as $feat)
                <div class="flex items-center gap-3 text-sm text-zinc-700 dark:text-zinc-300">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-zinc-900 dark:text-zinc-100 shrink-0"></i>
                    <span>{{ $feat }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Tasks and Categories -->
        <div class="space-y-3">
            <h3 class="text-sm font-mono font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">หมวดหมู่และแท็กการใช้งาน</h3>
            <div class="flex flex-wrap gap-2">
                @if($tool->category)
                <span class="px-3 py-1 rounded-xl text-xs font-semibold bg-black text-white dark:bg-white dark:text-black font-mono">
                    {{ $tool->category->name_th ?: $tool->category->name }}
                </span>
                @endif
                @foreach(($tool->tasks_th ?: $tool->tasks ?: []) as $task)
                <span class="px-3 py-1 rounded-xl text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 border border-zinc-200 dark:border-zinc-700 font-mono">
                    {{ $task }}
                </span>
                @endforeach
            </div>
        </div>

        <!-- Pricing details -->
        <div class="p-5 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-2">
                <i data-lucide="tag" class="w-4 h-4 text-zinc-400"></i>
                <span class="text-xs font-mono text-zinc-500">ข้อมูลราคา:</span>
                <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $tool->pricing_details_th ?: $tool->pricing_details ?: $tool->pricing_type }}</span>
            </div>
        </div>
    </div>

    <!-- Related Tools in same category -->
    @if($relatedTools->count() > 0)
    <div class="space-y-4 pt-4">
        <h3 class="text-lg font-bold text-zinc-900 dark:text-white">AI อื่นๆ ในหมวดหมู่เดียวกัน</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($relatedTools as $rel)
            <a href="{{ route('tool.show', $rel->slug) }}" class="p-4 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 hover:border-zinc-400 dark:hover:border-zinc-600 transition-all flex items-center gap-4 group">
                <div class="w-10 h-10 rounded-xl bg-zinc-100/90 dark:bg-zinc-800 border border-zinc-200/80 dark:border-zinc-700/60 p-2 flex items-center justify-center shadow-2xs group-hover:scale-105 transition-transform shrink-0 overflow-hidden">
                    <div class="w-full h-full flex items-center justify-center" x-html="getLogoSvg('{{ $rel->slug }}', '{{ $rel->name }}')"></div>
                </div>
                <div class="min-w-0">
                    <h4 class="text-sm font-bold text-zinc-900 dark:text-white truncate">{{ $rel->name }}</h4>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ $rel->tagline_th ?: $rel->tagline }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
