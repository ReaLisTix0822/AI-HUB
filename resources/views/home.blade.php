@extends('layouts.app')

@section('title', 'AI Directory — ค้นหา AI ที่ตอบโจทย์ทุกงานของคุณ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-10">

    <!-- Hero Section -->
    <section class="text-center max-w-4xl mx-auto space-y-5 pt-4 sm:pt-8">
        <!-- Minimalist Pill Badge -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-zinc-200 dark:border-zinc-800 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-xs text-xs font-mono text-zinc-600 dark:text-zinc-400 shadow-2xs">
            <span class="w-2 h-2 rounded-full bg-black dark:bg-white animate-pulse"></span>
            <span>ศูนย์รวมข้อมูลและความสามารถของ AI กว่า <strong class="text-zinc-900 dark:text-white" x-text="tools.length"></strong> ตัว</span>
        </div>

        <!-- Main Title -->
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-zinc-950 dark:text-white leading-[1.15]">
            ค้นหาและเลือกใช้ <span class="underline decoration-zinc-400 dark:decoration-zinc-600 decoration-wavy decoration-2 underline-offset-8">AI ที่ใช่</span><br class="hidden sm:inline">
            สำหรับงานที่คุณต้องการทำ
        </h1>

        <!-- Subtitle -->
        <p class="text-base sm:text-lg text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto leading-relaxed">
            เว็บไซต์รวบรวมเครื่องมือ AI ชั้นนำ พร้อมระบบคัดกรองอัจฉริยะตามเป้าหมายงาน และบันทึกรายการโปรดของคุณในสไตล์ขาว-ดำ Minimalist
        </p>
    </section>

    <!-- Task Matchmaker & Finder Section (คัดกรองตามงานที่ต้องการทำ) -->
    <section class="p-6 sm:p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-md shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-zinc-100 dark:border-zinc-800/80 pb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-900 dark:text-zinc-100">
                    <i data-lucide="target" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-zinc-900 dark:text-white">คุณต้องการให้ AI ช่วยทำงานอะไร?</h2>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">คลิกเลือกประเภทงานด้านล่างเพื่อคัดกรอง AI ที่เหมาะสมที่สุด</p>
                </div>
            </div>

            <!-- Clear selected task button -->
            <button x-show="selectedTask" 
                    @click="selectedTask = ''; $nextTick(() => window.renderIcons())" 
                    class="text-xs font-mono text-zinc-500 hover:text-black dark:hover:text-white flex items-center gap-1 self-start sm:self-auto py-1">
                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                <span>รีเซ็ตประเภทงาน</span>
            </button>
        </div>

        <!-- Task Badges Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-1">
            <template x-for="task in popularTasks" :key="task.key">
                <button @click="selectTask(task.key)"
                        class="p-3 rounded-2xl border text-left flex items-center gap-3 transition-all duration-200 group"
                        :class="selectedTask === task.key 
                            ? 'bg-black text-white border-black dark:bg-white dark:text-black dark:border-white shadow-md scale-[1.02]' 
                            : 'bg-zinc-50 dark:bg-zinc-950 text-zinc-800 dark:text-zinc-200 border-zinc-200/80 dark:border-zinc-800 hover:border-zinc-400 dark:hover:border-zinc-600'">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 transition-colors"
                         :class="selectedTask === task.key 
                             ? 'bg-zinc-800 text-white dark:bg-zinc-200 dark:text-black' 
                             : 'bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-800'">
                        <i :data-lucide="task.icon || 'sparkles'" class="w-4 h-4"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs sm:text-sm font-semibold truncate leading-tight" x-text="task.name_th"></div>
                        <div class="text-[10px] font-mono text-zinc-400 dark:text-zinc-500 truncate" :class="selectedTask === task.key ? 'text-zinc-300 dark:text-zinc-600' : ''" x-text="task.name_en"></div>
                    </div>
                </button>
            </template>
        </div>
    </section>

    <!-- Search & Filter Controls -->
    <section class="space-y-4">
        <div class="flex flex-col lg:flex-row gap-3 items-stretch lg:items-center">
            
            <!-- Live Search Bar -->
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-400 dark:text-zinc-500">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </div>
                <input type="text" 
                       x-model="searchQuery"
                       placeholder="ค้นหาชื่อ AI, ความสามารถ, หรือพิมพ์งานที่ต้องการ เช่น 'สรุปเอกสาร', 'เขียนโค้ด'..."
                       class="w-full pl-11 pr-10 py-3.5 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent text-sm transition-all shadow-xs">
                
                <!-- Clear Search Input button -->
                <button x-show="searchQuery" 
                        @click="searchQuery = ''; $nextTick(() => window.renderIcons())" 
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-zinc-400 hover:text-black dark:hover:text-white">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Dropdown Filters: Pricing & Sorting -->
            <div class="flex items-center gap-2.5 shrink-0">
                <!-- Pricing Filter -->
                <div class="relative flex-1 sm:flex-initial">
                    <select x-model="selectedPricing" 
                            class="w-full sm:w-auto appearance-none pl-4 pr-9 py-3.5 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 text-xs font-mono font-medium focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white cursor-pointer shadow-xs">
                        <option value="all">โมเดลราคาทั้งหมด (All)</option>
                        <option value="free">ฟรี 100% (Free)</option>
                        <option value="freemium">มีโควต้าฟรี (Freemium)</option>
                        <option value="paid">เสียเงิน (Paid)</option>
                        <option value="open_source">โอเพนซอร์ส (Open Source)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-zinc-400">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>

                <!-- Sort Filter -->
                <div class="relative flex-1 sm:flex-initial">
                    <select x-model="sortBy" 
                            class="w-full sm:w-auto appearance-none pl-4 pr-9 py-3.5 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 text-xs font-mono font-medium focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white cursor-pointer shadow-xs">
                        <option value="popular">เรียงตามความนิยม (Popular)</option>
                        <option value="name_asc">ชื่อ A → Z</option>
                        <option value="name_desc">ชื่อ Z → A</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-zinc-400">
                        <i data-lucide="arrow-down-up" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Filter Pills Bar -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 pt-1 no-scrollbar">
            <!-- All Categories Pill -->
            <button @click="selectedCategory = 'all'; $nextTick(() => window.renderIcons())"
                    class="px-4 py-2 rounded-xl text-xs font-medium shrink-0 transition-all border font-mono"
                    :class="selectedCategory === 'all'
                        ? 'bg-black text-white border-black dark:bg-white dark:text-black dark:border-white shadow-xs'
                        : 'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-800 hover:border-zinc-400 dark:hover:border-zinc-600'">
                ทุกหมวดหมู่ (<span x-text="tools.length"></span>)
            </button>

            <!-- Specific Categories -->
            <template x-for="cat in categories" :key="cat.slug">
                <button @click="selectedCategory = cat.slug; $nextTick(() => window.renderIcons())"
                        class="px-4 py-2 rounded-xl text-xs font-medium shrink-0 transition-all border flex items-center gap-1.5"
                        :class="selectedCategory === cat.slug
                            ? 'bg-black text-white border-black dark:bg-white dark:text-black dark:border-white shadow-xs'
                            : 'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-800 hover:border-zinc-400 dark:hover:border-zinc-600'">
                    <i :data-lucide="cat.icon || 'bot'" class="w-3.5 h-3.5"></i>
                    <span x-text="cat.name_th || cat.name"></span>
                    <span class="text-[10px] opacity-70 font-mono" x-text="`(${cat.ai_tools_count || 0})`"></span>
                </button>
            </template>
        </div>

        <!-- Active Filters Bar & Count -->
        <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400 pt-2 flex-wrap gap-2">
            <div class="flex items-center gap-2">
                <span>แสดงผล: <strong class="text-zinc-900 dark:text-zinc-100 font-mono" x-text="filteredTools.length"></strong> รายการ</span>
                
                <span x-show="activeTab === 'favorites'" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-zinc-200 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 font-mono text-[11px]">
                    <i data-lucide="heart" class="w-3 h-3 fill-current"></i>
                    <span>แท็บรายการโปรด</span>
                </span>
                <span x-show="selectedTask" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-zinc-200 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 font-mono text-[11px]">
                    <span>งาน: <span x-text="selectedTask"></span></span>
                    <button @click="selectedTask = ''; $nextTick(() => window.renderIcons())" class="hover:text-black dark:hover:text-white">✕</button>
                </span>
            </div>

            <!-- Clear All Filters Button -->
            <button x-show="searchQuery || selectedCategory !== 'all' || selectedPricing !== 'all' || selectedTask || activeTab !== 'all'"
                    @click="clearFilters()" 
                    class="text-xs font-mono text-zinc-500 hover:text-black dark:hover:text-white underline underline-offset-4 flex items-center gap-1">
                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                <span>ล้างตัวกรองทั้งหมด</span>
            </button>
        </div>
    </section>

    <!-- AI Tools Directory Grid -->
    <section>
        <!-- Cards Container -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="tool in filteredTools" :key="tool.id">
                <div class="group relative rounded-3xl border border-zinc-200 dark:border-zinc-800/80 bg-white dark:bg-zinc-900/90 p-6 flex flex-col justify-between hover:border-zinc-400 dark:hover:border-zinc-600 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    
                    <!-- Card Top: Avatar, Title, Pricing Badge, and Favorite Button -->
                    <div>
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="flex items-center gap-3">
                                <!-- Tool Icon / Avatar -->
                                <div class="w-12 h-12 rounded-2xl bg-zinc-100/90 dark:bg-zinc-800 border border-zinc-200/80 dark:border-zinc-700/60 p-2.5 flex items-center justify-center shadow-2xs group-hover:scale-105 transition-transform shrink-0 overflow-hidden">
                                    <div class="w-full h-full flex items-center justify-center" x-html="getLogoSvg(tool.slug, tool.name)"></div>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white tracking-tight truncate" x-text="tool.name"></h3>
                                    <span class="text-xs font-mono text-zinc-400 dark:text-zinc-500 truncate block" x-text="tool.category ? (tool.category.name_th || tool.category.name) : 'AI Tool'"></span>
                                </div>
                            </div>

                            <!-- Favorite Heart Toggle Button -->
                            <button @click="toggleFavorite(tool.id, $event)"
                                    class="p-2 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/80 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors shrink-0"
                                    :title="isFavorite(tool.id) ? 'ลบออกจากรายการโปรด' : 'เพิ่มในรายการโปรด'">
                                <i data-lucide="heart" 
                                   class="w-4 h-4 transition-transform active:scale-125"
                                   :class="isFavorite(tool.id) ? 'text-zinc-950 dark:text-white fill-zinc-950 dark:fill-white' : 'text-zinc-400 dark:text-zinc-500'">
                                </i>
                            </button>
                        </div>

                        <!-- Tagline -->
                        <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300 line-clamp-2 leading-relaxed mb-4" x-text="tool.tagline_th || tool.tagline"></p>

                        <!-- Best For Highlight Box -->
                        <div x-show="tool.best_for_th || tool.best_for" class="mb-4 p-3 rounded-xl bg-zinc-100/70 dark:bg-zinc-800/50 border border-zinc-200/60 dark:border-zinc-700/50 text-xs text-zinc-600 dark:text-zinc-300">
                            <span class="font-bold text-zinc-900 dark:text-zinc-100 font-mono text-[10px] uppercase tracking-wider block mb-0.5">จุดเด่น:</span>
                            <span class="line-clamp-2" x-text="tool.best_for_th || tool.best_for"></span>
                        </div>

                        <!-- Tasks Tags List -->
                        <div class="flex flex-wrap gap-1.5 mb-5">
                            <template x-for="(task, idx) in (tool.tasks_th || tool.tasks || []).slice(0, 3)" :key="idx">
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-mono bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700/80" x-text="task"></span>
                            </template>
                        </div>
                    </div>

                    <!-- Card Bottom: Pricing Info & Action Buttons -->
                    <div class="border-t border-zinc-100 dark:border-zinc-800/80 pt-4 flex items-center justify-between gap-2 mt-auto">
                        <!-- Pricing Badge -->
                        <div class="flex items-center gap-1.5 text-xs font-mono text-zinc-500 dark:text-zinc-400">
                            <span class="w-1.5 h-1.5 rounded-full"
                                  :class="{
                                      'bg-emerald-500': tool.pricing_type === 'free' || tool.pricing_type === 'open_source',
                                      'bg-blue-500': tool.pricing_type === 'freemium',
                                      'bg-zinc-500': tool.pricing_type === 'paid'
                                  }"></span>
                            <span class="capitalize" x-text="tool.pricing_type"></span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2">
                            <button @click="openModal(tool)" 
                                    class="px-3 py-1.5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 text-xs font-semibold text-zinc-900 dark:text-zinc-100 transition-colors flex items-center gap-1">
                                <span>ดูข้อมูล</span>
                                <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                            </button>
                            <a :href="tool.website_url" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="p-1.5 rounded-xl bg-black dark:bg-white text-white dark:text-black hover:opacity-80 transition-opacity"
                               title="ไปยังเว็บทางการ">
                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </template>
        </div>

        <!-- Empty State (เมื่อค้นหาไม่พบ) -->
        <div x-show="filteredTools.length === 0" 
             class="text-center py-16 px-4 rounded-3xl border border-dashed border-zinc-300 dark:border-zinc-800 bg-white/50 dark:bg-zinc-900/50 my-6">
            <div class="w-14 h-14 rounded-2xl bg-zinc-100 dark:bg-zinc-800 text-zinc-400 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="search-x" class="w-7 h-7"></i>
            </div>
            <h3 class="text-lg font-bold text-zinc-900 dark:text-white">ไม่พบเครื่องมือ AI ที่ตรงกับเงื่อนไข</h3>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto mt-1 mb-6">
                ลองค้นหาด้วยคำอื่น หรือกดรีเซ็ตตัวกรองเพื่อดู AI ทั้งหมด
            </p>
            <button @click="clearFilters()" 
                    class="px-6 py-2.5 rounded-xl bg-black text-white dark:bg-white dark:text-black text-sm font-semibold hover:opacity-85 transition-opacity">
                รีเซ็ตตัวกรองทั้งหมด
            </button>
        </div>
    </section>

</div>
@endsection
