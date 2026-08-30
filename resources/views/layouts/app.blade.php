<!DOCTYPE html>
<html lang="th" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="AI Directory - คลังรวบรวมเครื่องมือ AI และระบบค้นหาแนะนำ AI ที่เหมาะกับงานของคุณ">
    <title>@yield('title', 'AI Directory — ค้นหา AI ที่ตอบโจทย์ทุกงานของคุณ')</title>

    <!-- Google Fonts: Prompt & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=Prompt:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Anti-flicker Dark mode script in head -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme_mode');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-50 text-zinc-900 dark:bg-black dark:text-zinc-100 min-h-screen flex flex-col font-sans selection:bg-zinc-900 selection:text-white dark:selection:bg-white dark:selection:text-black antialiased transition-colors duration-200"
      x-data="aiHub({
          tools: {{ Js::from($allToolsForJs ?? $tools ?? []) }},
          categories: {{ Js::from($categories ?? []) }},
          popularTasks: {{ Js::from($popularTasks ?? []) }}
      })">

    <!-- Subtle Background Ambient Grid -->
    <div class="fixed inset-0 pointer-events-none z-0 opacity-40 dark:opacity-20 bg-grid-pattern-light dark:bg-grid-pattern-dark"></div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-40 border-b border-zinc-200/80 dark:border-zinc-800/80 bg-white/85 dark:bg-black/85 backdrop-blur-md transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-black dark:bg-white text-white dark:text-black flex items-center justify-center font-bold text-lg shadow-sm group-hover:scale-105 transition-transform duration-200">
                    <span class="tracking-tighter">AI</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-base sm:text-lg tracking-tight text-zinc-900 dark:text-white leading-tight">
                        AI <span class="font-extralight text-zinc-500 dark:text-zinc-400">HUB</span>
                    </span>
                    <span class="text-[10px] text-zinc-500 dark:text-zinc-400 font-mono tracking-wider uppercase">Directory & Matchmaker</span>
                </div>
            </a>

            <!-- Center Navigation / Quick Stats -->
            <div class="hidden md:flex items-center gap-6 text-sm font-medium text-zinc-600 dark:text-zinc-400">
                <button @click="activeTab = 'all'; selectedTask = ''; selectedCategory = 'all'; $nextTick(() => window.renderIcons())" 
                        :class="activeTab === 'all' && !selectedTask ? 'text-black dark:text-white font-semibold' : 'hover:text-black dark:hover:text-white'" 
                        class="transition-colors">
                    เครื่องมือทั้งหมด
                </button>
                <button @click="activeTab = 'featured'; selectedTask = ''; $nextTick(() => window.renderIcons())" 
                        :class="activeTab === 'featured' ? 'text-black dark:text-white font-semibold' : 'hover:text-black dark:hover:text-white'" 
                        class="transition-colors flex items-center gap-1.5">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    <span>AI ยอดนิยม</span>
                </button>
                <button @click="activeTab = 'favorites'; $nextTick(() => window.renderIcons())" 
                        :class="activeTab === 'favorites' ? 'text-black dark:text-white font-semibold' : 'hover:text-black dark:hover:text-white'" 
                        class="transition-colors flex items-center gap-1.5">
                    <i data-lucide="heart" class="w-4 h-4" :class="favoriteCount > 0 ? 'fill-zinc-900 dark:fill-zinc-100' : ''"></i>
                    <span>รายการโปรด</span>
                    <span x-show="favoriteCount > 0" x-text="favoriteCount" class="text-xs px-1.5 py-0.5 rounded-full bg-zinc-200 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-mono font-bold"></span>
                </button>
            </div>

            <!-- Right Controls: Theme Toggle & Favorites Mobile -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Favorites Quick Button -->
                <button @click="activeTab = activeTab === 'favorites' ? 'all' : 'favorites'; $nextTick(() => window.renderIcons())" 
                        class="relative p-2 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all text-zinc-700 dark:text-zinc-300"
                        title="รายการโปรดของคุณ">
                    <i data-lucide="heart" class="w-4 h-4" :class="favoriteCount > 0 ? 'text-zinc-900 dark:text-white fill-zinc-900 dark:fill-white' : ''"></i>
                    <span x-show="favoriteCount > 0" 
                          x-text="favoriteCount" 
                          class="absolute -top-1.5 -right-1.5 text-[10px] w-4 h-4 rounded-full bg-black text-white dark:bg-white dark:text-black font-mono font-bold flex items-center justify-center shadow-xs">
                    </span>
                </button>

                <!-- Dark / Light Mode Switcher Button -->
                <button @click="$store.theme.toggle()" 
                        class="p-2 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all text-zinc-800 dark:text-zinc-200 flex items-center gap-1.5"
                        title="สลับโหมดมืด / โหมดสว่าง">
                    <span class="sr-only">สลับธีม</span>
                    <template x-if="$store.theme.mode === 'dark'">
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="sun" class="w-4 h-4 text-zinc-200"></i>
                            <span class="text-xs font-mono hidden sm:inline text-zinc-300">Light</span>
                        </div>
                    </template>
                    <template x-if="$store.theme.mode === 'light'">
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="moon" class="w-4 h-4 text-zinc-800"></i>
                            <span class="text-xs font-mono hidden sm:inline text-zinc-700">Dark</span>
                        </div>
                    </template>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 relative z-10">
        @yield('content')
    </main>

    <!-- Toast Notification Popup -->
    <div x-cloak
         x-show="showToast" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-2xl border border-zinc-900/10 dark:border-zinc-700/40 bg-zinc-950 text-white dark:bg-zinc-100 dark:text-zinc-950 shadow-2xl backdrop-blur-md">
        <i data-lucide="info" class="w-4 h-4 shrink-0"></i>
        <span class="text-sm font-medium" x-text="toastMessage"></span>
    </div>

    <!-- Global AI Tool Detail Modal -->
    <div x-cloak
         x-show="isModalOpen" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog" 
         aria-modal="true">
        
        <!-- Backdrop -->
        <div x-show="isModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeModal()"
             class="fixed inset-0 bg-black/70 backdrop-blur-xs transition-opacity"></div>

        <!-- Modal Dialog Box -->
        <div x-show="isModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative w-full max-w-2xl max-h-[90vh] flex flex-col bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl shadow-2xl overflow-hidden z-10 transition-all text-zinc-900 dark:text-zinc-100">
            
            <template x-if="activeModalTool">
                <div class="flex flex-col h-full overflow-y-auto">
                    <!-- Modal Header -->
                    <div class="relative p-6 sm:p-8 border-b border-zinc-100 dark:border-zinc-800/80 bg-zinc-50/50 dark:bg-zinc-950/40">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-zinc-100/90 dark:bg-zinc-800 border border-zinc-200/80 dark:border-zinc-700/60 p-3 flex items-center justify-center shadow-md overflow-hidden shrink-0">
                                    <div class="w-full h-full flex items-center justify-center" x-html="getLogoSvg(activeModalTool.slug, activeModalTool.name)"></div>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="text-xl sm:text-2xl font-bold tracking-tight text-zinc-900 dark:text-white" x-text="activeModalTool.name"></h3>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-mono uppercase tracking-wider font-semibold border"
                                              :class="{
                                                  'bg-zinc-100 text-zinc-800 border-zinc-300 dark:bg-zinc-800 dark:text-zinc-200 dark:border-zinc-700': activeModalTool.pricing_type === 'freemium',
                                                  'bg-black text-white border-black dark:bg-white dark:text-black dark:border-white': activeModalTool.pricing_type === 'paid',
                                                  'bg-zinc-200 text-zinc-900 border-zinc-300 dark:bg-zinc-800 dark:text-zinc-100 dark:border-zinc-700': activeModalTool.pricing_type === 'free' || activeModalTool.pricing_type === 'open_source'
                                              }"
                                              x-text="activeModalTool.pricing_type">
                                        </span>
                                    </div>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1" x-text="activeModalTool.tagline_th || activeModalTool.tagline"></p>
                                </div>
                            </div>

                            <!-- Actions: Favorite & Close -->
                            <div class="flex items-center gap-2">
                                <button @click="toggleFavorite(activeModalTool.id)"
                                        class="p-2.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                                        :title="isFavorite(activeModalTool.id) ? 'ลบออกจากรายการโปรด' : 'เพิ่มในรายการโปรด'">
                                    <i data-lucide="heart" class="w-5 h-5" :class="isFavorite(activeModalTool.id) ? 'text-zinc-950 dark:text-white fill-zinc-950 dark:fill-white' : 'text-zinc-400 dark:text-zinc-500'"></i>
                                </button>
                                <button @click="closeModal()" 
                                        class="p-2.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 text-zinc-500 dark:text-zinc-400 hover:text-black dark:hover:text-white transition-colors">
                                    <i data-lucide="x" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 sm:p-8 space-y-6">
                        <!-- Best for Badge -->
                        <div x-show="activeModalTool.best_for_th || activeModalTool.best_for" class="p-4 rounded-2xl bg-zinc-100 dark:bg-zinc-800/60 border border-zinc-200/80 dark:border-zinc-700/60 flex items-start gap-3">
                            <i data-lucide="award" class="w-5 h-5 text-zinc-900 dark:text-zinc-100 shrink-0 mt-0.5"></i>
                            <div>
                                <h4 class="text-xs font-mono uppercase tracking-wider font-bold text-zinc-500 dark:text-zinc-400">เหมาะสำหรับงานประเภทไหน</h4>
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 mt-0.5" x-text="activeModalTool.best_for_th || activeModalTool.best_for"></p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <h4 class="text-xs font-mono uppercase tracking-wider font-bold text-zinc-500 dark:text-zinc-400 mb-2">รายละเอียดความสามารถ</h4>
                            <p class="text-sm sm:text-base leading-relaxed text-zinc-700 dark:text-zinc-300 font-normal" x-text="activeModalTool.description_th || activeModalTool.description"></p>
                        </div>

                        <!-- Features Checklist -->
                        <div x-show="activeModalTool.features_th && activeModalTool.features_th.length">
                            <h4 class="text-xs font-mono uppercase tracking-wider font-bold text-zinc-500 dark:text-zinc-400 mb-3">ฟีเจอร์และจุดเด่นหลัก</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                <template x-for="(feat, idx) in (activeModalTool.features_th || activeModalTool.features)" :key="idx">
                                    <div class="flex items-center gap-2.5 text-sm text-zinc-700 dark:text-zinc-300">
                                        <i data-lucide="check-circle-2" class="w-4 h-4 text-zinc-900 dark:text-zinc-100 shrink-0"></i>
                                        <span x-text="feat"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Tasks / Capabilities Tags -->
                        <div>
                            <h4 class="text-xs font-mono uppercase tracking-wider font-bold text-zinc-500 dark:text-zinc-400 mb-2.5">แท็กประเภทงาน</h4>
                            <div class="flex flex-wrap gap-1.5">
                                <template x-for="(task, idx) in (activeModalTool.tasks_th || activeModalTool.tasks)" :key="idx">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 border border-zinc-200 dark:border-zinc-700 font-mono" x-text="task"></span>
                                </template>
                            </div>
                        </div>

                        <!-- Pricing Info -->
                        <div class="p-4 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/70 dark:bg-zinc-950/60 flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center gap-2.5">
                                <i data-lucide="tag" class="w-4 h-4 text-zinc-500 dark:text-zinc-400"></i>
                                <span class="text-xs font-mono text-zinc-500 dark:text-zinc-400">โมเดลราคา:</span>
                                <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100" x-text="activeModalTool.pricing_details_th || activeModalTool.pricing_details || activeModalTool.pricing_type"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer with CTA -->
                    <div class="p-6 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950 flex items-center justify-end gap-3 mt-auto">
                        <button @click="closeModal()" 
                                class="px-5 py-2.5 rounded-xl border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-200 dark:hover:bg-zinc-800 text-sm font-medium transition-colors">
                            ปิดหน้าต่าง
                        </button>
                        <a :href="activeModalTool.website_url" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="px-6 py-2.5 rounded-xl bg-black text-white hover:bg-zinc-800 dark:bg-white dark:text-black dark:hover:bg-zinc-200 text-sm font-semibold shadow-sm inline-flex items-center gap-2 transition-all">
                            <span>ไปยังเว็บไซต์ทางการ</span>
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-20 border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-black transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
            
            <!-- Legal Disclaimer Box -->
            <div class="p-4 sm:p-5 rounded-2xl border border-zinc-200 dark:border-zinc-800/80 bg-zinc-50/70 dark:bg-zinc-950/60 text-xs text-zinc-500 dark:text-zinc-400 space-y-1.5 leading-relaxed font-sans">
                <div class="flex items-center gap-2 text-zinc-700 dark:text-zinc-300 font-semibold font-mono text-[11px] uppercase tracking-wider">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-zinc-900 dark:text-zinc-100"></i>
                    <span>ข้อสงวนสิทธิ์ทางกฎหมายและเครื่องหมายการค้า (Trademark & Legal Disclaimer)</span>
                </div>
                <p>
                    เครื่องหมายการค้า โลโก้ ชื่อผลิตภัณฑ์ และบริการทั้งหมดที่ปรากฏบนเว็บไซต์นี้ เป็นทรัพย์สินและลิขสิทธิ์ของบริษัทหรือเจ้าของสิทธิ์แต่ละราย เว็บไซต์นี้จัดทำขึ้นเพื่อวัตถุประสงค์ในการรวบรวมข้อมูล เปรียบเทียบความสามารถ และอำนวยความสะดวกในการค้นหาเครื่องมือ AI (Nominative Fair Use) โดยไม่มีเจตนาละเมิดลิขสิทธิ์หรือแอบอ้างความสัมพันธ์ทางการค้าใดๆ ทั้งสิ้น
                </p>
                <p class="font-mono text-[10px] text-zinc-400 dark:text-zinc-500">
                    All trademarks, service marks, trade names, and logos referenced on this site are the property of their respective owners. Used strictly for informational identification and directory linking purposes.
                </p>
            </div>

            <!-- Footer Bottom Line -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-zinc-500 dark:text-zinc-400 font-mono pt-2">
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 rounded-lg bg-black dark:bg-white text-white dark:text-black flex items-center justify-center font-bold text-[10px]">
                        AI
                    </div>
                    <span>AI Hub Directory — พัฒนาด้วย Laravel & Tailwind CSS</span>
                </div>
                <div class="flex items-center gap-4">
                    <span>โทนขาว-ดำ Minimalist Monochrome</span>
                    <span>•</span>
                    <span>Dark / Light Mode</span>
                </div>
            </div>

        </div>
    </footer>
</body>
</html>
