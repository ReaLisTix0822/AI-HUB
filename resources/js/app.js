import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;

// Helper to render icons after DOM updates
window.renderIcons = () => {
    try {
        createIcons({ icons });
    } catch (e) {
        console.error('Error rendering icons:', e);
    }
};

// Official Authentic Full-Color Brand SVG Logo Map
const BRAND_LOGOS = {
    'chatgpt-gpt-4o': `<svg viewBox="0 0 24 24" class="w-full h-full" fill="#10A37F"><path d="M22.2819 9.8211a5.9847 5.9847 0 0 0-.5157-4.9108 6.0462 6.0462 0 0 0-6.5098-2.9A6.0651 6.0651 0 0 0 4.9807 4.1818a5.9847 5.9847 0 0 0-3.9977 2.9 6.0462 6.0462 0 0 0 .7427 7.0966 5.98 5.98 0 0 0 .511 4.9107 6.051 6.051 0 0 0 6.5146 2.9001A5.9847 5.9847 0 0 0 13.2599 24a6.0557 6.0557 0 0 0 5.7718-4.2058 5.9894 5.9894 0 0 0 3.9977-2.9001 6.0557 6.0557 0 0 0-.7475-7.0729zm-9.022 12.6081a4.4755 4.4755 0 0 1-2.8764-1.0408l.1419-.0804 4.7783-2.7582a.7948.7948 0 0 0 .3927-.6813v-6.7369l2.02 1.1686a.071.071 0 0 1 .038.052v5.5826a4.504 4.504 0 0 1-4.4945 4.4944zm-9.6607-4.1254a4.4708 4.4708 0 0 1-.5346-3.0137l.142.0852 4.783 2.7582a.7712.7712 0 0 0 .7806 0l5.8428-3.3685v2.3324a.0804.0804 0 0 1-.0332.0615L9.74 19.9503a4.4992 4.4992 0 0 1-6.1408-1.6465zM2.3428 7.897a4.485 4.485 0 0 1 2.3655-1.9728V11.6a.7664.7664 0 0 0 .3879.6765l5.8144 3.3543-2.0201 1.1685a.0757.0757 0 0 1-.071 0l-4.8303-2.7865A4.504 4.504 0 0 1 2.3428 7.897zm16.5996 3.8558L13.1038 8.384 15.1239 7.215a.0757.0757 0 0 1 .071 0l4.8303 2.7913a4.4944 4.4944 0 0 1-.6765 8.1042v-5.6772a.79.79 0 0 0-.407-.6805zm2.0107-3.0231l-.142-.0852-4.7735-2.7818a.7759.7759 0 0 0-.7854 0L9.409 9.2297V6.8974a.0662.0662 0 0 1 .0284-.0615l4.8303-2.7866a4.4992 4.4992 0 0 1 6.6802 4.66zm-12.6401 4.135l-2.02-1.1639a.0804.0804 0 0 1-.038-.0567V6.0768a4.4992 4.4992 0 0 1 7.3757-3.4537l-.142.0805L6.7088 5.4618a.7948.7948 0 0 0-.3927.6813v6.7369zm1.1214-2.555a.7712.7712 0 0 0 .3928.6766l4.2494 2.4514a.8.8 0 0 0 .79 0l4.2494-2.4514a.7712.7712 0 0 0 .3928-.6766V8.9248a.7712.7712 0 0 0-.3928-.6765L12.399 5.7969a.8.8 0 0 0-.79 0L7.3596 8.2483a.7712.7712 0 0 0-.3928.6765z"/></svg>`,
    'claude-3-7-sonnet': `<svg viewBox="0 0 24 24" class="w-full h-full" fill="#D97706"><path d="M4.5 10.5C3.67 10.5 3 11.17 3 12s.67 1.5 1.5 1.5h15c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5h-15zm3.18-5.32c-.59-.59-1.54-.59-2.12 0-.59.59-.59 1.54 0 2.12l10.61 10.61c.59.59 1.54.59 2.12 0 .59-.59.59-1.54 0-2.12L7.68 5.18zm8.64 0c-.59-.59-1.54-.59-2.12 0l-10.61 10.61c-.59.59-.59 1.54 0 2.12.59.59 1.54.59 2.12 0L16.32 7.3c.59-.59.59-1.54 0-2.12zM12 3c-.83 0-1.5.67-1.5 1.5v15c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5v-15c0-.83-.67-1.5-1.5-1.5z"/></svg>`,
    'google-gemini': `<svg viewBox="0 0 24 24" class="w-full h-full"><defs><linearGradient id="gemini-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#4E82EE"/><stop offset="35%" stop-color="#9B72CB"/><stop offset="70%" stop-color="#D96570"/><stop offset="100%" stop-color="#F4A261"/></linearGradient></defs><path fill="url(#gemini-grad)" d="M12 0C12 6.627 6.627 12 0 12c6.627 0 12 5.627 12 12 0-6.627 5.627-12 12-12-6.627 0-12-5.373-12-12z"/></svg>`,
    'cursor': `<svg viewBox="0 0 24 24" class="w-full h-full"><defs><linearGradient id="cursor-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#0284C7"/><stop offset="100%" stop-color="#0369A1"/></linearGradient></defs><path fill="url(#cursor-grad)" d="M4.5 2.5l14 7-7 2.5-2.5 7-4.5-16.5zm5.5 11.5l1.5-4.5 4.5-1.5-9-4.5 3 10.5z"/></svg>`,
    'v0-vercel': `<svg viewBox="0 0 24 24" class="w-full h-full"><rect width="24" height="24" rx="6" fill="#000000"/><path fill="#FFFFFF" d="M19 18.5H5L12 5.5l7 13z"/></svg>`,
    'github-copilot': `<svg viewBox="0 0 24 24" class="w-full h-full" fill="#6E40C9"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.87 8.17 6.84 9.5.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34-.46-1.16-1.11-1.47-1.11-1.47-.91-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.87 1.52 2.34 1.07 2.91.83.1-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.92 0-1.11.38-2 1.03-2.71-.1-.25-.45-1.29.1-2.64 0 0 .84-.27 2.75 1.02.79-.22 1.65-.33 2.5-.33.85 0 1.71.11 2.5.33 1.91-1.29 2.75-1.02 2.75-1.02.55 1.35.2 2.39.1 2.64.65.71 1.03 1.6 1.03 2.71 0 3.82-2.34 4.66-4.57 4.91.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2z"/></svg>`,
    'bolt-new': `<svg viewBox="0 0 24 24" class="w-full h-full"><defs><linearGradient id="bolt-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#F59E0B"/><stop offset="100%" stop-color="#D97706"/></linearGradient></defs><path fill="url(#bolt-grad)" d="M13 2L3 14h8l-2 8 12-12h-8l2-8z"/></svg>`,
    'midjourney': `<svg viewBox="0 0 24 24" class="w-full h-full" fill="#6366F1"><path d="M12.75 2.25c-4.5 4.5-8.5 11.25-9.75 16.5 4.5-1.5 8.25-4.5 10.5-8.25 1.5 3 4.5 6 9 7.5-1.5-4.5-5.25-11.25-9.75-15.75z"/></svg>`,
    'flux-1': `<svg viewBox="0 0 24 24" class="w-full h-full"><defs><linearGradient id="flux-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#F43F5E"/><stop offset="100%" stop-color="#FB7185"/></linearGradient></defs><path fill="url(#flux-grad)" d="M12 2L2 7l10 5 10-5-10-5zm0 9L4.5 7.25 12 3.5l7.5 3.75L12 11zm-10 6l10 5 10-5-2.5-1.25L12 19.5l-7.5-3.75L2 17zm0-4.5l10 5 10-5-2.5-1.25L12 15l-7.5-3.75L2 12.5z"/></svg>`,
    'leonardo-ai': `<svg viewBox="0 0 24 24" class="w-full h-full"><defs><linearGradient id="leo-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#A855F7"/><stop offset="100%" stop-color="#EC4899"/></linearGradient></defs><path fill="url(#leo-grad)" d="M12 2L2 9l3.5 13h13L22 9 12 2zm0 3.2L18.4 9 12 13.6 5.6 9 12 5.2zM6.6 19.8L4.6 10.9 11 15.5v4.3H6.6zm6.4 0v-4.3l6.4-4.6-2 8.9H13z"/></svg>`,
    'canva-magic-studio': `<svg viewBox="0 0 24 24" class="w-full h-full"><defs><linearGradient id="canva-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#00C4CC"/><stop offset="100%" stop-color="#7D2AE8"/></linearGradient></defs><circle cx="12" cy="12" r="10.5" fill="url(#canva-grad)"/><path fill="#FFFFFF" d="M13.5 15.8c-2.1 0-3.6-1.6-3.6-3.8 0-2.2 1.5-3.8 3.6-3.8 1.2 0 2.2.6 2.8 1.5l-1.3.9c-.4-.6-.9-.9-1.5-.9-1.2 0-2.1 1-2.1 2.3s.9 2.3 2.1 2.3c.7 0 1.2-.3 1.6-.9l1.3.9c-.7 1-1.7 1.5-2.9 1.5z"/></svg>`,
    'runway-gen-3': `<svg viewBox="0 0 24 24" class="w-full h-full"><defs><linearGradient id="runway-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#10B981"/><stop offset="100%" stop-color="#059669"/></linearGradient></defs><rect width="24" height="24" rx="6" fill="url(#runway-grad)"/><path fill="#FFFFFF" d="M6 6h6a3.5 3.5 0 0 1 3.5 3.5 3.5 3.5 0 0 1-3.5 3.5H9v5H6V6zm3 3v4h3a1.5 1.5 0 0 0 1.5-1.5A1.5 1.5 0 0 0 12 9H9zm5 5 4 4h-3.5l-3-3h1.5z"/></svg>`,
    'kling-ai': `<svg viewBox="0 0 24 24" class="w-full h-full"><defs><linearGradient id="kling-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#EF4444"/><stop offset="100%" stop-color="#F97316"/></linearGradient></defs><rect width="24" height="24" rx="6" fill="url(#kling-grad)"/><path fill="#FFFFFF" d="M6 5h3.5v6.5L14 5h4l-5.5 7 6 7h-4.2L9.5 13.5V19H6V5z"/></svg>`,
    'heygen': `<svg viewBox="0 0 24 24" class="w-full h-full"><defs><linearGradient id="heygen-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#8B5CF6"/><stop offset="100%" stop-color="#6D28D9"/></linearGradient></defs><rect width="24" height="24" rx="6" fill="url(#heygen-grad)"/><path fill="#FFFFFF" d="M6 6h3.5v4.5h5V6H18v12h-3.5v-4.5h-5V18H6V6z"/></svg>`,
    'elevenlabs': `<svg viewBox="0 0 24 24" class="w-full h-full"><rect width="24" height="24" rx="6" fill="#18181B"/><path fill="#F97316" d="M6 5h4v14H6V5zm8 0h4v14h-4V5z"/></svg>`,
    'suno-ai': `<svg viewBox="0 0 24 24" class="w-full h-full"><defs><linearGradient id="suno-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FF5722"/><stop offset="100%" stop-color="#F43F5E"/></linearGradient></defs><rect width="24" height="24" rx="6" fill="url(#suno-grad)"/><path d="M12 5v14M8 8v8M5 10v4M16 8v8M19 10v4" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"/></svg>`,
    'udio': `<svg viewBox="0 0 24 24" class="w-full h-full"><defs><linearGradient id="udio-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#06B6D4"/><stop offset="100%" stop-color="#3B82F6"/></linearGradient></defs><rect width="24" height="24" rx="6" fill="url(#udio-grad)"/><path fill="#FFFFFF" d="M7 5v8a5 5 0 0 0 10 0V5h-3v8a2 2 0 0 1-4 0V5H7z"/></svg>`,
    'perplexity-ai': `<svg viewBox="0 0 24 24" class="w-full h-full" fill="#14B8A6"><path d="M12 2L4 7v10l8 5 8-5V7l-8-5zm0 2.5l5.5 3.44L12 11.38 6.5 7.94 12 4.5zM5.5 9.1l5.5 3.44v6.88L5.5 16V9.1zm13 6.9l-5.5 3.42v-6.88l5.5-3.44v6.9z"/></svg>`,
    'deepseek-r1': `<svg viewBox="0 0 24 24" class="w-full h-full" fill="#2563EB"><path d="M3 13c0-4.97 4.03-9 9-9 4.18 0 7.7 2.85 8.68 6.77.34 1.34 1.83 1.95 2.83 1.05.78-.7 1.49-1.8 1.49-2.82C24 4.03 18.63 0 12 0 5.37 0 0 5.37 0 12c0 4.28 2.24 8.04 5.6 10.19.98.63 2.27-.08 2.27-1.25V19.4C5.17 18.06 3 15.77 3 13zm15.5-1c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5 1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"/></svg>`,
    'chatpdf': `<svg viewBox="0 0 24 24" class="w-full h-full" fill="#EF4444"><path d="M19 2H8a2 2 0 0 0-2 2v2h8a3 3 0 0 1 3 3v8h2a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM4 8h10a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2zm2 4v4h2v-4H6zm3 0v4h2v-4H9zm3 0v4h2v-4h-2z"/></svg>`,
    'gamma-app': `<svg viewBox="0 0 24 24" class="w-full h-full"><defs><linearGradient id="gamma-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#EC4899"/><stop offset="100%" stop-color="#8B5CF6"/></linearGradient></defs><rect width="24" height="24" rx="6" fill="url(#gamma-grad)"/><path fill="#FFFFFF" d="M6 6h12v3.5H11v8.5H7.5V6H6z"/></svg>`,
    'notion-ai': `<svg viewBox="0 0 24 24" class="w-full h-full"><path fill="#000000" class="dark:fill-white" d="M4.459 4.208c.746.606 1.026.56 2.428.466l13.215-.793c.28 0 .047-.28-.046-.326L17.86 1.55c-.42-.326-.98-.7-2.053-.607L2.92 2.063c-.467.047-.56.327-.374.56zm.793 4.293v13.58c0 .7.373.98 1.12.933l13.775-.793c.747-.047.933-.513.933-1.12V7.522c0-.653-.28-.98-.84-.933L5.86 7.429c-.467.047-.607.42-.607 1.072zm11.385.933l-5.32 7.794v-7.653c0-.467-.28-.7-.7-.654l-2.008.14c-.373.047-.466.327-.466.56v9.333c0 .466.233.7.7.653l2.613-.186c.327-.047.514-.234.7-.514l5.32-7.887v7.747c0 .467.28.7.7.654l2.007-.14c.373-.047.467-.327.467-.56V9.953c0-.466-.234-.7-.7-.653z"/></svg>`
};

window.getAiLogoSvg = (slug, name) => {
    if (slug && BRAND_LOGOS[slug]) {
        return BRAND_LOGOS[slug];
    }
    const initial = (name || 'AI').substring(0, 2).toUpperCase();
    return `<span class="font-bold text-sm tracking-tight">${initial}</span>`;
};

// Global AI Directory Store / Component
Alpine.data('aiHub', (initialData) => ({
    tools: initialData.tools || [],
    categories: initialData.categories || [],
    popularTasks: initialData.popularTasks || [],
    getLogoSvg: window.getAiLogoSvg,
    
    // State
    searchQuery: '',
    selectedCategory: 'all',
    selectedPricing: 'all',
    selectedTask: '',
    activeTab: 'all', // 'all', 'favorites', 'featured'
    sortBy: 'popular', // 'popular', 'name_asc', 'name_desc'
    favorites: JSON.parse(localStorage.getItem('ai_favorites') || '[]'),
    
    // Modal state
    activeModalTool: null,
    isModalOpen: false,
    
    // Toast notification
    toastMessage: '',
    showToast: false,

    init() {
        this.$nextTick(() => {
            window.renderIcons();
        });
        
        // Re-render icons on state changes
        this.$watch('searchQuery', () => this.$nextTick(() => window.renderIcons()));
        this.$watch('selectedCategory', () => this.$nextTick(() => window.renderIcons()));
        this.$watch('selectedPricing', () => this.$nextTick(() => window.renderIcons()));
        this.$watch('selectedTask', () => this.$nextTick(() => window.renderIcons()));
        this.$watch('activeTab', () => this.$nextTick(() => window.renderIcons()));
        this.$watch('sortBy', () => this.$nextTick(() => window.renderIcons()));
        
        this.$watch('favorites', (val) => {
            localStorage.setItem('ai_favorites', JSON.stringify(val));
            this.$nextTick(() => window.renderIcons());
        });
    },

    toggleFavorite(toolId, event) {
        if (event) event.stopPropagation();
        
        if (this.favorites.includes(toolId)) {
            this.favorites = this.favorites.filter(id => id !== toolId);
            this.triggerToast('ลบออกจากรายการโปรดแล้ว');
        } else {
            this.favorites.push(toolId);
            this.triggerToast('บันทึกลงในรายการโปรดเรียบร้อย ★');
        }
    },

    isFavorite(toolId) {
        return this.favorites.includes(toolId);
    },

    get favoriteCount() {
        return this.favorites.length;
    },

    selectTask(taskKey) {
        if (this.selectedTask === taskKey) {
            this.selectedTask = '';
        } else {
            this.selectedTask = taskKey;
            this.activeTab = 'all';
        }
        this.$nextTick(() => window.renderIcons());
    },

    clearFilters() {
        this.searchQuery = '';
        this.selectedCategory = 'all';
        this.selectedPricing = 'all';
        this.selectedTask = '';
        this.activeTab = 'all';
        this.sortBy = 'popular';
        this.$nextTick(() => window.renderIcons());
    },

    openModal(tool) {
        this.activeModalTool = tool;
        this.isModalOpen = true;
        document.body.style.overflow = 'hidden';
        this.$nextTick(() => window.renderIcons());
    },

    closeModal() {
        this.isModalOpen = false;
        this.activeModalTool = null;
        document.body.style.overflow = '';
    },

    triggerToast(msg) {
        this.toastMessage = msg;
        this.showToast = true;
        setTimeout(() => {
            this.showToast = false;
        }, 2200);
    },

    get filteredTools() {
        let list = this.tools;

        // Filter by tab
        if (this.activeTab === 'favorites') {
            list = list.filter(t => this.favorites.includes(t.id));
        } else if (this.activeTab === 'featured') {
            list = list.filter(t => t.is_featured);
        }

        // Filter by category
        if (this.selectedCategory !== 'all') {
            list = list.filter(t => t.category && t.category.slug === this.selectedCategory);
        }

        // Filter by pricing
        if (this.selectedPricing !== 'all') {
            list = list.filter(t => t.pricing_type === this.selectedPricing);
        }

        // Filter by task
        if (this.selectedTask) {
            list = list.filter(t => Array.isArray(t.tasks) && t.tasks.includes(this.selectedTask));
        }

        // Search query
        if (this.searchQuery.trim()) {
            const q = this.searchQuery.toLowerCase().trim();
            list = list.filter(t => {
                const name = (t.name || '').toLowerCase();
                const tagline = (t.tagline || '').toLowerCase();
                const taglineTh = (t.tagline_th || '').toLowerCase();
                const desc = (t.description || '').toLowerCase();
                const descTh = (t.description_th || '').toLowerCase();
                const bestFor = (t.best_for || '').toLowerCase();
                const bestForTh = (t.best_for_th || '').toLowerCase();
                const tasksStr = Array.isArray(t.tasks) ? t.tasks.join(' ').toLowerCase() : '';
                const tasksThStr = Array.isArray(t.tasks_th) ? t.tasks_th.join(' ').toLowerCase() : '';

                return name.includes(q) ||
                       tagline.includes(q) ||
                       taglineTh.includes(q) ||
                       desc.includes(q) ||
                       descTh.includes(q) ||
                       bestFor.includes(q) ||
                       bestForTh.includes(q) ||
                       tasksStr.includes(q) ||
                       tasksThStr.includes(q);
            });
        }

        // Sort
        return [...list].sort((a, b) => {
            if (this.sortBy === 'name_asc') {
                return a.name.localeCompare(b.name);
            }
            if (this.sortBy === 'name_desc') {
                return b.name.localeCompare(a.name);
            }
            return (b.popularity_score || 0) - (a.popularity_score || 0);
        });
    }
}));

// Theme manager store for instant switching with zero flicker
Alpine.store('theme', {
    mode: localStorage.getItem('theme_mode') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),
    
    init() {
        this.apply();
    },

    toggle() {
        this.mode = this.mode === 'dark' ? 'light' : 'dark';
        localStorage.setItem('theme_mode', this.mode);
        this.apply();
        this.$nextTick(() => window.renderIcons());
    },

    apply() {
        if (this.mode === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
});

Alpine.start();
window.renderIcons();

