@php
    $dbStations = [];
    if (isset($musics) && $musics->count() > 0) {
        $dbStations = $musics->map(function($music) {
            return [
                'title' => $music->title,
                'subtitle' => $music->subtitle ?? 'Local Music',
                'src' => Storage::url($music->file_path),
            ];
        })->toArray();
    }

    $defaultStations = [
        [ 'title' => 'Lofi Coding Vibes', 'subtitle' => 'I Love Lofi & Chill', 'src' => 'https://streams.ilovemusic.de/iloveradio17.mp3' ],
        [ 'title' => 'Chillout Lounge', 'subtitle' => 'I Love Chill & Relax', 'src' => 'https://streams.ilovemusic.de/iloveradio10.mp3' ],
        [ 'title' => 'Energy Boost', 'subtitle' => 'I Love Dance & EDM', 'src' => 'https://streams.ilovemusic.de/iloveradio2.mp3' ],
    ];

    $stationsToUse = empty($dbStations) ? $defaultStations : $dbStations;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Danang Abu Hafid | Full Stack Developer</title>
    <!-- Terminal Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%231a202c'/><text x='15' y='68' fill='%234ade80' font-family='monospace' font-weight='bold' font-size='55'>&gt;_</text></svg>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- GSAP & Draggable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <!-- Typed.js -->
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>

    <style>
        .window-drag-handle { cursor: grab; }
        .window-drag-handle:active { cursor: grabbing; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-primary text-white font-sans antialiased h-screen w-screen overflow-hidden flex flex-col relative transition-all duration-700" :class="currentWallpaper" x-data="portfolioOS()">

    <!-- Booting Overlay -->
    <div x-show="booting" class="absolute inset-0 bg-black z-[9999] flex flex-col justify-start p-8 font-mono text-green-500 text-sm overflow-hidden"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div id="boot-text" class="whitespace-pre-wrap leading-relaxed"></div>
    </div>

    <!-- Top Menu Bar -->
    <div class="h-7 bg-glass backdrop-blur-md flex items-center justify-between px-4 text-xs z-50 border-b border-white/10 select-none">
        <div class="flex items-center space-x-4">
            <span class="font-bold"> DanangOS</span>
            <span class="hidden sm:inline hover:bg-white/10 px-2 rounded cursor-pointer" @click="spotlightOpen = !spotlightOpen">Finder</span>
            <span class="hidden sm:inline hover:bg-white/10 px-2 rounded cursor-pointer" @click="toggleWindow('terminal')">Terminal</span>
            <span class="hidden sm:inline hover:bg-white/10 px-2 rounded cursor-pointer" @click="toggleWindow('projects')">Projects</span>
        </div>
        <div class="flex items-center space-x-3">
            <span class="hover:bg-white/10 px-2 py-0.5 rounded cursor-pointer font-bold" @click="toggleLanguage()" x-text="locale.toUpperCase()">
            </span>
            <!-- WiFi Dropdown -->
            <div class="relative flex items-center" x-data="{ showWifi: false }" @click.away="showWifi = false">
                <!-- WiFi Icon (Solid) -->
                <svg @click="showWifi = !showWifi" class="w-4 h-4 cursor-pointer hover:text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-10.146 2.278-13.5 5.949a.75.75 0 0 0 1.076 1.042c3.08-3.327 7.425-5.342 12.424-5.342s9.344 2.015 12.424 5.342a.75.75 0 0 0 1.076-1.042C22.146 4.528 17.385 2.25 12 2.25Zm0 5c-3.69 0-7.037 1.488-9.488 3.905a.75.75 0 0 0 1.076 1.042c2.176-2.145 5.15-3.447 8.412-3.447s6.236 1.302 8.412 3.447a.75.75 0 0 0 1.076-1.042C19.037 8.738 15.69 7.25 12 7.25Zm0 5c-2.025 0-3.865.807-5.212 2.115a.75.75 0 0 0 1.076 1.042C8.825 14.417 10.33 13.75 12 13.75s3.175.667 4.136 1.657a.75.75 0 0 0 1.076-1.042C15.865 13.057 14.025 12.25 12 12.25Zm0 5a1.875 1.875 0 1 0 0 3.75 1.875 1.875 0 0 0 0-3.75Z" clip-rule="evenodd" />
                </svg>
                
                <!-- Dropdown Menu -->
                <div x-show="showWifi" x-transition x-cloak class="absolute top-6 right-0 w-56 bg-glass backdrop-blur-2xl border border-white/20 rounded-lg shadow-2xl py-2 text-sm z-[100] text-white">
                    <div class="px-4 py-1 text-gray-400 text-xs font-semibold tracking-wide">Wi-Fi</div>
                    <div class="flex items-center space-x-2 px-4 py-1.5 bg-accent text-white cursor-pointer rounded mx-2">
                        <svg class="w-3 h-3 text-white font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-medium">DanangOS_5G</span>
                        <svg class="w-4 h-4 ml-auto" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-10.146 2.278-13.5 5.949a.75.75 0 0 0 1.076 1.042c3.08-3.327 7.425-5.342 12.424-5.342s9.344 2.015 12.424 5.342a.75.75 0 0 0 1.076-1.042C22.146 4.528 17.385 2.25 12 2.25Zm0 5c-3.69 0-7.037 1.488-9.488 3.905a.75.75 0 0 0 1.076 1.042c2.176-2.145 5.15-3.447 8.412-3.447s6.236 1.302 8.412 3.447a.75.75 0 0 0 1.076-1.042C19.037 8.738 15.69 7.25 12 7.25Zm0 5c-2.025 0-3.865.807-5.212 2.115a.75.75 0 0 0 1.076 1.042C8.825 14.417 10.33 13.75 12 13.75s3.175.667 4.136 1.657a.75.75 0 0 0 1.076-1.042C15.865 13.057 14.025 12.25 12 12.25Zm0 5a1.875 1.875 0 1 0 0 3.75 1.875 1.875 0 0 0 0-3.75Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex items-center space-x-2 px-4 py-1.5 hover:bg-white/10 cursor-pointer rounded mx-2 mt-1 transition-colors">
                        <svg class="w-3 h-3 opacity-0" viewBox="0 0 24 24"></svg>
                        <span>Guest Network</span>
                        <svg class="w-4 h-4 ml-auto opacity-50" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 7.25c-3.69 0-7.037 1.488-9.488 3.905a.75.75 0 0 0 1.076 1.042c2.176-2.145 5.15-3.447 8.412-3.447s6.236 1.302 8.412 3.447a.75.75 0 0 0 1.076-1.042C19.037 8.738 15.69 7.25 12 7.25Zm0 5c-2.025 0-3.865.807-5.212 2.115a.75.75 0 0 0 1.076 1.042C8.825 14.417 10.33 13.75 12 13.75s3.175.667 4.136 1.657a.75.75 0 0 0 1.076-1.042C15.865 13.057 14.025 12.25 12 12.25Zm0 5a1.875 1.875 0 1 0 0 3.75 1.875 1.875 0 0 0 0-3.75Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="border-t border-white/10 my-2"></div>
                    <div class="px-4 py-1.5 hover:bg-white/10 cursor-pointer rounded mx-2 transition-colors">Network Preferences...</div>
                </div>
            </div>
            
            <!-- Battery Icon (Custom macOS style) -->
            <svg class="w-[26px] h-[14px] opacity-90 cursor-pointer hover:opacity-100" viewBox="0 0 24 12" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                <rect x="1" y="1" width="20" height="10" rx="3" stroke-width="1.5" />
                <rect x="3" y="3" width="12" height="6" rx="1" fill="currentColor" stroke="none" />
                <path d="M23 4.5V7.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span class="cursor-pointer hover:bg-white/10 px-2 py-0.5 rounded" x-text="currentTime"></span>
        </div>
    </div>

    <!-- Spotlight Search Overlay -->
    <div x-show="spotlightOpen" x-transition x-cloak class="absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] max-w-[90vw] z-[200]" @keydown.window.escape="spotlightOpen = false">
        <div class="bg-glass backdrop-blur-3xl border border-white/20 rounded-xl shadow-2xl overflow-hidden flex flex-col">
            <div class="flex items-center px-4 py-3 border-b border-white/10">
                <svg class="w-6 h-6 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" x-model="searchQuery" class="flex-1 bg-transparent text-xl text-white outline-none placeholder-gray-400" placeholder="Spotlight Search..." autofocus>
                <button @click="spotlightOpen = false" class="text-xs bg-white/10 hover:bg-white/20 px-2 py-1 rounded">ESC</button>
            </div>
            <div class="max-h-[400px] overflow-y-auto" x-show="searchQuery !== ''">
                <template x-for="result in searchResults" :key="result.title">
                    <div class="px-6 py-3 border-b border-white/5 hover:bg-white/10 cursor-pointer" @click="spotlightOpen = false; windows[result.app].open = true; bringToFront(result.app)">
                        <div class="text-xs text-accent font-bold mb-1" x-text="result.type"></div>
                        <div class="font-bold text-white" x-text="result.title"></div>
                        <div class="text-sm text-gray-400 truncate" x-text="result.desc"></div>
                    </div>
                </template>
                <div x-show="searchResults.length === 0" class="px-6 py-4 text-gray-400 text-center" x-text="locale === 'en' ? 'No results found' : 'Tidak ada hasil'"></div>
            </div>
        </div>
    </div>

    <!-- Desktop Area -->
    <main class="flex-1 relative p-4 sm:p-8 z-10 overflow-hidden" id="desktop-area">
        
        <!-- Desktop Icons -->
        <div class="absolute top-4 left-4 flex flex-col space-y-6 z-0">
            <div class="flex flex-col items-center w-20 cursor-pointer group" @dblclick="toggleWindow('projects')" @click.stop>
                <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors border border-white/20 shadow-lg">
                    <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                </div>
                <span class="text-xs mt-1 text-white text-center font-medium drop-shadow-md bg-black/40 px-1 rounded">Projects</span>
            </div>
            <div class="flex flex-col items-center w-20 cursor-pointer group" @dblclick="toggleWindow('terminal')" @click.stop>
                <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors border border-white/20 shadow-lg">
                    <svg class="w-7 h-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-xs mt-1 text-white text-center font-medium drop-shadow-md bg-black/40 px-1 rounded">Terminal</span>
            </div>
            <div class="flex flex-col items-center w-20 cursor-pointer group" @dblclick="toggleWindow('notes')" @click.stop>
                <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors border border-white/20 shadow-lg">
                    <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <span class="text-xs mt-1 text-white text-center font-medium drop-shadow-md bg-black/40 px-1 rounded">Notes</span>
            </div>
            <div class="flex flex-col items-center w-20 cursor-pointer group" @dblclick="toggleWindow('music')" @click.stop>
                <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors border border-white/20 shadow-lg">
                    <svg class="w-7 h-7 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                </div>
                <span class="text-xs mt-1 text-white text-center font-medium drop-shadow-md bg-black/40 px-1 rounded whitespace-nowrap">Lofi Player</span>
            </div>
            <div class="flex flex-col items-center w-20 cursor-pointer group" @dblclick="toggleWindow('preferences')" @click.stop>
                <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors border border-white/20 shadow-lg">
                    <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <span class="text-xs mt-1 text-white text-center font-medium drop-shadow-md bg-black/40 px-1 rounded whitespace-nowrap">Settings</span>
            </div>
        </div>
        
        <!-- Terminal Window -->
        <div class="absolute top-10 left-10 w-[680px] max-w-full bg-secondary/95 rounded-lg shadow-2xl border border-white/10 flex flex-col os-window backdrop-blur-xl"
             id="terminal-window" x-show="windows.terminal.open" x-transition x-on:mousedown="bringToFront('terminal')" :style="'z-index: ' + windows.terminal.z" x-draggable>
            <div class="h-8 bg-primary flex items-center px-4 window-drag-handle border-b border-white/10 rounded-t-lg">
                <div class="flex space-x-2">
                    <div class="w-3 h-3 rounded-full bg-danger cursor-pointer hover:opacity-80" @click="toggleWindow('terminal')"></div>
                    <div class="w-3 h-3 rounded-full bg-warning cursor-pointer hover:opacity-80"></div>
                    <div class="w-3 h-3 rounded-full bg-success cursor-pointer hover:opacity-80"></div>
                </div>
                <div class="mx-auto text-xs text-gray-400 font-mono">danang@portfolio: ~</div>
            </div>
            <div class="p-4 font-mono text-sm text-gray-300 flex-1 overflow-y-auto h-[440px] flex flex-col" id="terminal-content">
                <div class="mb-3 text-xs text-gray-400">
                    DanangOS (v2.0.0) <br>
                    <span x-text="locale === 'en' ? 'Type \'neofetch\' or \'help\' for available commands.' : 'Ketik \'neofetch\' atau \'help\' untuk melihat perintah.'"></span>
                </div>
                <div class="flex-1">
                    <div class="text-white whitespace-pre-wrap" id="typed-output"></div>
                </div>
                <div class="mt-3 flex items-center pt-2 border-t border-white/10">
                    <span class="text-success mr-2 font-mono text-sm">danang@portfolio:~$</span>
                    <input type="text" 
                           x-model="termInput" 
                           @keydown.enter="handleTerminalCommand" 
                           class="flex-1 bg-transparent border-none outline-none text-white font-mono text-sm placeholder-gray-500" 
                           spellcheck="false" 
                           autocomplete="off" 
                           placeholder="type 'neofetch' or 'help'...">
                </div>
            </div>
        </div>

        <!-- AI Terminal Window -->
        <div class="absolute top-16 right-8 w-[500px] max-w-full bg-secondary rounded-lg shadow-2xl border border-white/10 flex flex-col os-window"
             id="aichat-window" x-show="windows.aichat.open" x-transition x-on:mousedown="bringToFront('aichat')" :style="'z-index: ' + windows.aichat.z" x-cloak x-draggable>
            <div class="h-8 bg-primary flex items-center px-4 window-drag-handle border-b border-white/10 rounded-t-lg">
                <div class="flex space-x-2">
                    <div class="w-3 h-3 rounded-full bg-danger cursor-pointer hover:opacity-80" @click="toggleWindow('aichat')"></div>
                    <div class="w-3 h-3 rounded-full bg-warning cursor-pointer hover:opacity-80"></div>
                    <div class="w-3 h-3 rounded-full bg-success cursor-pointer hover:opacity-80"></div>
                </div>
                <div class="mx-auto text-xs text-blue-400 font-mono">Danang AI Assistant</div>
            </div>
            <div class="p-4 font-mono text-sm text-gray-300 flex-1 overflow-y-auto h-[400px] max-h-[400px]" id="aichat-content">
                <div class="mb-4 text-blue-400">
                    Danang AI System (Connected)<br>
                    <span x-text="locale === 'en' ? 'Hello! I am Danang\'s professional AI assistant. How can I help you today?' : 'Halo! Saya asisten AI profesional milik Danang. Ada yang bisa saya bantu?'"></span>
                </div>
                
                <!-- AI History -->
                <template x-for="item in aiHistory" :key="item.id">
                    <div class="mb-2">
                        <div x-show="item.type === 'user'" class="text-success">visitor@portfolio:~$ <span x-text="item.content"></span></div>
                        <div x-show="item.type === 'ai'" class="text-blue-300 whitespace-pre-wrap" x-text="item.content"></div>
                    </div>
                </template>
                
                <div x-show="aiThinking" class="text-gray-400 animate-pulse mb-2">Thinking...</div>
                
                <!-- AI Interactive Input -->
                <div class="flex items-center">
                    <span class="text-success mr-2">visitor@portfolio:~$</span>
                    <input type="text" x-model="aiInput" @keydown.enter="executeAiCommand" class="flex-1 bg-transparent border-none outline-none text-white font-mono" spellcheck="false" autocomplete="off" :disabled="aiThinking">
                </div>
            </div>
        </div>

        <!-- Projects Finder Window -->
        <div class="absolute top-20 left-40 w-[800px] max-w-full bg-secondary rounded-lg shadow-2xl border border-white/10 flex flex-col os-window"
             id="projects-window" x-show="windows.projects.open" x-transition x-on:mousedown="bringToFront('projects')" :style="'z-index: ' + windows.projects.z" x-cloak x-draggable>
            <div class="h-8 bg-primary flex items-center px-4 window-drag-handle border-b border-white/10 rounded-t-lg">
                <div class="flex space-x-2">
                    <div class="w-3 h-3 rounded-full bg-danger cursor-pointer hover:opacity-80" @click="toggleWindow('projects')"></div>
                    <div class="w-3 h-3 rounded-full bg-warning cursor-pointer hover:opacity-80"></div>
                    <div class="w-3 h-3 rounded-full bg-success cursor-pointer hover:opacity-80"></div>
                </div>
                <div class="mx-auto text-xs text-gray-400 font-mono">Projects - Finder</div>
            </div>
            <div class="p-6 overflow-y-auto h-[500px] bg-slate-900/50">
                <h2 class="text-2xl font-bold mb-4" x-text="locale === 'en' ? 'My Projects' : 'Proyek Saya'"></h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($projects as $project)
                        <div class="bg-primary border border-white/10 rounded-lg p-4 hover:border-accent transition-colors cursor-pointer" @click="openProjectPreview({{ $project->id }})">
                            <h3 class="font-bold text-lg text-accent" x-text='locale === "en" ? @json($project->title_en ?? $project->title_id) : @json($project->title_id ?? $project->title_en)'></h3>
                            <p class="text-sm text-gray-400 mt-2" x-text='locale === "en" ? @json(Str::limit($project->description_en ?? $project->description_id, 100)) : @json(Str::limit($project->description_id ?? $project->description_en, 100))'></p>
                        </div>
                    @empty
                        <div class="text-gray-500 text-sm" x-text="locale === 'en' ? 'No projects available yet.' : 'Belum ada proyek.'"></div>
                    @endforelse
                </div>
            </div>
            </div>
        </div>
        
        <!-- Project Preview Window -->
        <div class="absolute top-24 left-[20%] w-[700px] max-w-full bg-secondary rounded-lg shadow-2xl border border-white/10 flex flex-col os-window"
             id="project-preview-window" x-show="windows.projectPreview.open" x-transition x-on:mousedown="bringToFront('projectPreview')" :style="'z-index: ' + windows.projectPreview.z" x-cloak x-draggable>
            <div class="h-8 bg-primary flex items-center px-4 window-drag-handle border-b border-white/10 rounded-t-lg">
                <div class="flex space-x-2">
                    <div class="w-3 h-3 rounded-full bg-danger cursor-pointer hover:opacity-80" @click="toggleWindow('projectPreview')"></div>
                    <div class="w-3 h-3 rounded-full bg-warning cursor-pointer hover:opacity-80"></div>
                    <div class="w-3 h-3 rounded-full bg-success cursor-pointer hover:opacity-80"></div>
                </div>
                <div class="mx-auto text-xs text-gray-400 font-mono">Preview - <span x-text="selectedProject ? (locale === 'en' ? (selectedProject.title_en || selectedProject.title_id) : (selectedProject.title_id || selectedProject.title_en)) : ''"></span></div>
            </div>
            <div class="p-0 overflow-y-auto h-[500px] bg-slate-900/90" x-show="selectedProject">
                <template x-if="selectedProject && selectedProject.image">
                    <img :src="`/storage/${selectedProject.image}`" class="w-full h-64 object-cover border-b border-white/10" alt="Project Image">
                </template>
                <div class="p-6">
                    <h2 class="text-3xl font-bold mb-2 text-white" x-text="selectedProject ? (locale === 'en' ? (selectedProject.title_en || selectedProject.title_id) : (selectedProject.title_id || selectedProject.title_en)) : ''"></h2>
                    <template x-if="selectedProject && selectedProject.category">
                        <span class="inline-block px-3 py-1 bg-accent/20 text-accent text-xs rounded-full mb-4 font-mono" x-text="locale === 'en' ? (selectedProject.category.name_en || selectedProject.category.name_id) : (selectedProject.category.name_id || selectedProject.category.name_en)"></span>
                    </template>
                    <p class="text-gray-300 leading-relaxed" x-text="selectedProject ? (locale === 'en' ? (selectedProject.description_en || selectedProject.description_id) : (selectedProject.description_id || selectedProject.description_en)) : ''"></p>
                    <template x-if="selectedProject && selectedProject.link">
                        <div class="mt-8">
                            <a :href="selectedProject.link" target="_blank" class="inline-flex items-center px-4 py-2 border border-accent text-accent font-mono text-sm rounded hover:bg-accent hover:text-primary transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                <span x-text="locale === 'en' ? 'Launch Project' : 'Buka Proyek'"></span>
                            </a>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        
        <!-- Experience Window -->
        <div class="absolute top-32 left-64 w-[700px] max-w-full bg-secondary rounded-lg shadow-2xl border border-white/10 flex flex-col os-window"
             id="experience-window" x-show="windows.experience.open" x-transition x-on:mousedown="bringToFront('experience')" :style="'z-index: ' + windows.experience.z" x-cloak x-draggable>
            <div class="h-8 bg-primary flex items-center px-4 window-drag-handle border-b border-white/10 rounded-t-lg">
                <div class="flex space-x-2">
                    <div class="w-3 h-3 rounded-full bg-danger cursor-pointer hover:opacity-80" @click="toggleWindow('experience')"></div>
                    <div class="w-3 h-3 rounded-full bg-warning cursor-pointer hover:opacity-80"></div>
                    <div class="w-3 h-3 rounded-full bg-success cursor-pointer hover:opacity-80"></div>
                </div>
                <div class="mx-auto text-xs text-gray-400 font-mono">Experience.md</div>
            </div>
            <div class="p-6 overflow-y-auto h-[500px] bg-slate-900/50">
                <h2 class="text-2xl font-bold mb-6 text-warning" x-text="locale === 'en' ? '# Professional Experience' : '# Pengalaman Kerja'"></h2>
                <div class="space-y-6 relative border-l border-white/20 ml-3">
                    @forelse($experiences as $exp)
                        <div class="pl-6 relative">
                            <div class="absolute w-3 h-3 bg-warning rounded-full -left-[6.5px] top-1"></div>
                            <h3 class="font-bold text-lg"><span x-text='locale === "en" ? @json($exp->title_en ?? $exp->title_id) : @json($exp->title_id ?? $exp->title_en)'></span> <span class="text-sm text-gray-400 font-normal">@ {{ $exp->company }}</span></h3>
                            <p class="text-xs text-gray-500 mb-2">{{ $exp->start_date ? \Carbon\Carbon::parse($exp->start_date)->format('M Y') : 'Start' }} - {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'Present' }}</p>
                            <p class="text-sm text-gray-300" x-text='locale === "en" ? @json($exp->description_en ?? $exp->description_id) : @json($exp->description_id ?? $exp->description_en)'></p>
                        </div>
                    @empty
                        <div class="pl-6 text-gray-500 text-sm" x-text="locale === 'en' ? 'Experience data is empty.' : 'Data pengalaman kosong.'"></div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Skills Window -->
        <div class="absolute top-10 left-[500px] w-[500px] max-w-full bg-secondary rounded-lg shadow-2xl border border-white/10 flex flex-col os-window"
             id="skills-window" x-show="windows.skills.open" x-transition x-on:mousedown="bringToFront('skills')" :style="'z-index: ' + windows.skills.z" x-cloak x-draggable>
            <div class="h-8 bg-primary flex items-center px-4 window-drag-handle border-b border-white/10 rounded-t-lg">
                <div class="flex space-x-2">
                    <div class="w-3 h-3 rounded-full bg-danger cursor-pointer hover:opacity-80" @click="toggleWindow('skills')"></div>
                    <div class="w-3 h-3 rounded-full bg-warning cursor-pointer hover:opacity-80"></div>
                    <div class="w-3 h-3 rounded-full bg-success cursor-pointer hover:opacity-80"></div>
                </div>
                <div class="mx-auto text-xs text-gray-400 font-mono">Skills - System Preferences</div>
            </div>
            <div class="p-6 overflow-y-auto h-[400px] bg-slate-900/50">
                <h2 class="text-2xl font-bold mb-4" x-text="locale === 'en' ? 'Tech Stack' : 'Teknologi Utama'"></h2>
                <div class="space-y-4">
                    @forelse($skills as $skill)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span x-text='locale === "en" ? @json($skill->title_en ?? $skill->title_id) : @json($skill->title_id ?? $skill->title_en)'></span>
                                <span>{{ $skill->percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-accent h-2 rounded-full" style="width: {{ $skill->percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500 text-sm" x-text="locale === 'en' ? 'Skills data is empty.' : 'Data keahlian kosong.'"></div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Contact Window -->
        <div class="absolute top-24 left-96 w-[400px] max-w-full bg-secondary rounded-lg shadow-2xl border border-white/10 flex flex-col os-window"
             id="contact-window" x-show="windows.contact.open" x-transition x-on:mousedown="bringToFront('contact')" :style="'z-index: ' + windows.contact.z" x-cloak x-draggable>
            <div class="h-8 bg-primary flex items-center px-4 window-drag-handle border-b border-white/10 rounded-t-lg">
                <div class="flex space-x-2">
                    <div class="w-3 h-3 rounded-full bg-danger cursor-pointer hover:opacity-80" @click="toggleWindow('contact')"></div>
                    <div class="w-3 h-3 rounded-full bg-warning cursor-pointer hover:opacity-80"></div>
                    <div class="w-3 h-3 rounded-full bg-success cursor-pointer hover:opacity-80"></div>
                </div>
                <div class="mx-auto text-xs text-gray-400 font-mono">Mail - Compose</div>
            </div>
            <div class="p-6 bg-slate-900/50">
                <form @submit.prevent="submitContact" class="space-y-4">
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">To: Danang Abu Hafid</label>
                        <input type="text" x-model="contactForm.name" placeholder="Your Name" required class="w-full bg-primary border border-white/10 rounded p-2 text-sm focus:border-accent outline-none">
                    </div>
                    <div>
                        <input type="email" x-model="contactForm.email" placeholder="Your Email" required class="w-full bg-primary border border-white/10 rounded p-2 text-sm focus:border-accent outline-none">
                    </div>
                    <div>
                        <textarea x-model="contactForm.message" rows="4" placeholder="Message..." required class="w-full bg-primary border border-white/10 rounded p-2 text-sm focus:border-accent outline-none"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-accent hover:bg-blue-600 text-white font-bold py-2 rounded text-sm transition-colors flex items-center justify-center">
                        <span x-show="!contactSending">Send Message</span>
                        <span x-show="contactSending">Sending...</span>
                    </button>
                    <div x-show="contactSuccess" class="text-success text-xs text-center mt-2" x-cloak>Message sent successfully!</div>
                </form>
            </div>
        </div>

        <!-- Notes Window -->
        <div class="absolute top-20 left-1/4 w-[700px] max-w-full bg-[#1e1e1e] rounded-lg shadow-2xl border border-white/10 flex flex-col os-window"
             id="notes-window" x-show="windows.notes.open" x-transition x-on:mousedown="bringToFront('notes')" :style="'z-index: ' + windows.notes.z" x-cloak x-draggable>
            <div class="h-10 bg-[#2d2d2d] flex items-center px-4 window-drag-handle border-b border-[#3c3c3c] rounded-t-lg">
                <div class="flex space-x-2">
                    <div class="w-3 h-3 rounded-full bg-danger cursor-pointer hover:opacity-80" @click="toggleWindow('notes')"></div>
                    <div class="w-3 h-3 rounded-full bg-warning cursor-pointer hover:opacity-80"></div>
                    <div class="w-3 h-3 rounded-full bg-success cursor-pointer hover:opacity-80"></div>
                </div>
                <div class="mx-auto text-xs text-gray-300 font-medium flex items-center">
                    <svg class="w-4 h-4 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Notes
                </div>
            </div>
            <div class="flex h-[450px]">
                <!-- Sidebar -->
                <div class="w-1/3 border-r border-[#3c3c3c] bg-[#1e1e1e] overflow-y-auto">
                    <div class="p-3">
                        <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2" x-text="locale === 'en' ? 'My Notes' : 'Catatanku'"></div>
                        <template x-for="(note, index) in notesData" :key="index">
                            <div class="p-3 rounded-lg cursor-pointer transition-colors" 
                                 :class="selectedNoteIndex === index ? 'bg-accent/20 text-white' : 'text-gray-400 hover:bg-white/5'"
                                 @click="selectedNoteIndex = index">
                                <div class="font-bold truncate" x-text="note.title"></div>
                                <div class="text-xs mt-1 truncate text-gray-500" x-text="note.content"></div>
                            </div>
                        </template>
                    </div>
                </div>
                <!-- Content -->
                <div class="w-2/3 bg-[#1e1e1e] p-6 overflow-y-auto text-gray-200">
                    <template x-if="notesData.length > 0">
                        <div>
                            <h2 class="text-3xl font-bold mb-1 text-white" x-text="notesData[selectedNoteIndex].title"></h2>
                            <div class="text-xs text-gray-500 mb-6" x-text="notesData[selectedNoteIndex].date"></div>
                            <div class="whitespace-pre-wrap leading-relaxed text-sm" x-text="notesData[selectedNoteIndex].content"></div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- System Preferences Window -->
        <div class="absolute top-16 left-28 w-[640px] max-w-full bg-secondary/95 rounded-lg shadow-2xl border border-white/10 flex flex-col os-window backdrop-blur-xl"
             id="preferences-window" x-show="windows.preferences.open" x-transition x-on:mousedown="bringToFront('preferences')" :style="'z-index: ' + windows.preferences.z" x-cloak x-draggable>
            <div class="h-8 bg-primary flex items-center px-4 window-drag-handle border-b border-white/10 rounded-t-lg">
                <div class="flex space-x-2">
                    <div class="w-3 h-3 rounded-full bg-danger cursor-pointer hover:opacity-80" @click="toggleWindow('preferences')"></div>
                    <div class="w-3 h-3 rounded-full bg-warning cursor-pointer hover:opacity-80"></div>
                    <div class="w-3 h-3 rounded-full bg-success cursor-pointer hover:opacity-80"></div>
                </div>
                <div class="mx-auto text-xs text-gray-400 font-mono">System Preferences - Wallpaper & Themes</div>
            </div>
            <div class="p-6 bg-slate-900/60 overflow-y-auto max-h-[500px]">
                <h3 class="text-lg font-bold text-white mb-1">Desktop Wallpaper</h3>
                <p class="text-xs text-gray-400 mb-6">Select a wallpaper theme for your DanangOS desktop session.</p>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <!-- Sonoma Dark -->
                    <div class="border-2 rounded-xl p-3 cursor-pointer transition-all hover:scale-[1.02]"
                         :class="currentWallpaper === 'wallpaper-sonoma' ? 'border-accent bg-accent/10 shadow-lg' : 'border-white/10 bg-primary/40 hover:border-white/20'"
                         @click="currentWallpaper = 'wallpaper-sonoma'">
                        <div class="h-24 rounded-lg wallpaper-sonoma mb-3 shadow-inner border border-white/10 flex items-center justify-center">
                            <span class="text-xs font-mono bg-black/40 px-2 py-1 rounded text-white">Sonoma Dark</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-white">Sonoma Dark</span>
                            <span x-show="currentWallpaper === 'wallpaper-sonoma'" class="text-xs text-accent font-bold">Active</span>
                        </div>
                    </div>

                    <!-- Cyberpunk -->
                    <div class="border-2 rounded-xl p-3 cursor-pointer transition-all hover:scale-[1.02]"
                         :class="currentWallpaper === 'wallpaper-cyberpunk' ? 'border-accent bg-accent/10 shadow-lg' : 'border-white/10 bg-primary/40 hover:border-white/20'"
                         @click="currentWallpaper = 'wallpaper-cyberpunk'">
                        <div class="h-24 rounded-lg wallpaper-cyberpunk mb-3 shadow-inner border border-white/10 flex items-center justify-center">
                            <span class="text-xs font-mono bg-black/40 px-2 py-1 rounded text-pink-300">Cyberpunk Neon</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-white">Cyberpunk Neon</span>
                            <span x-show="currentWallpaper === 'wallpaper-cyberpunk'" class="text-xs text-accent font-bold">Active</span>
                        </div>
                    </div>

                    <!-- Retrowave -->
                    <div class="border-2 rounded-xl p-3 cursor-pointer transition-all hover:scale-[1.02]"
                         :class="currentWallpaper === 'wallpaper-retrowave' ? 'border-accent bg-accent/10 shadow-lg' : 'border-white/10 bg-primary/40 hover:border-white/20'"
                         @click="currentWallpaper = 'wallpaper-retrowave'">
                        <div class="h-24 rounded-lg wallpaper-retrowave mb-3 shadow-inner border border-white/10 flex items-center justify-center">
                            <span class="text-xs font-mono bg-black/40 px-2 py-1 rounded text-rose-300">Retrowave Sunset</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-white">Retrowave Sunset</span>
                            <span x-show="currentWallpaper === 'wallpaper-retrowave'" class="text-xs text-accent font-bold">Active</span>
                        </div>
                    </div>

                    <!-- Matrix Emerald -->
                    <div class="border-2 rounded-xl p-3 cursor-pointer transition-all hover:scale-[1.02]"
                         :class="currentWallpaper === 'wallpaper-matrix' ? 'border-accent bg-accent/10 shadow-lg' : 'border-white/10 bg-primary/40 hover:border-white/20'"
                         @click="currentWallpaper = 'wallpaper-matrix'">
                        <div class="h-24 rounded-lg wallpaper-matrix mb-3 shadow-inner border border-white/10 flex items-center justify-center">
                            <span class="text-xs font-mono bg-black/40 px-2 py-1 rounded text-green-400">Matrix Emerald</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-white">Matrix Emerald</span>
                            <span x-show="currentWallpaper === 'wallpaper-matrix'" class="text-xs text-accent font-bold">Active</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white/5 rounded-xl border border-white/10 text-xs text-gray-300 flex items-center justify-between">
                    <span>Pro-tip: You can also change themes directly from Terminal using <code class="bg-black/50 text-accent px-1.5 py-0.5 rounded font-mono">wallpaper 1..4</code> or <code class="bg-black/50 text-accent px-1.5 py-0.5 rounded font-mono">theme cyberpunk</code>!</span>
                </div>
            </div>
        </div>

        <!-- Music Player Window -->
        <div class="absolute bottom-24 right-8 w-80 bg-[#1e2330] rounded-3xl shadow-2xl overflow-hidden os-window border border-white/10"
             id="music-window" x-show="windows.music.open" x-transition x-on:mousedown="bringToFront('music')" :style="'z-index: ' + windows.music.z" x-cloak x-draggable>
            <div class="window-drag-handle flex items-center px-5 pt-5 pb-2">
                <div class="flex space-x-2">
                    <div class="w-3.5 h-3.5 rounded-full bg-[#ff5f56] cursor-pointer hover:opacity-80" @click="closeMusic()" title="Close"></div>
                    <div class="w-3.5 h-3.5 rounded-full bg-[#ffbd2e] cursor-pointer hover:opacity-80" @click="toggleWindow('music')" title="Minimize"></div>
                    <div class="w-3.5 h-3.5 rounded-full bg-[#27c93f] cursor-pointer hover:opacity-80"></div>
                </div>
            </div>
            <div class="px-6 pb-8 pt-4 flex flex-col items-center">
                <div class="w-36 h-36 rounded-full overflow-hidden mb-6 border-4 border-white/5 relative shadow-lg" :class="isAudioPlaying ? 'animate-[spin_4s_linear_infinite]' : ''">
                    <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
                    <div class="absolute inset-0 m-auto w-8 h-8 bg-[#1e2330] rounded-full border border-black/50 shadow-inner"></div>
                </div>
                <div class="text-center mb-6">
                    <h3 class="font-bold text-white text-xl mb-1" x-text="stations[currentStationIndex].title"></h3>
                    <p class="text-sm text-gray-400" x-text="stations[currentStationIndex].subtitle"></p>
                </div>
                
                <audio id="lofi-audio" :src="stations[currentStationIndex].src" preload="none"></audio>
                
                <div class="flex items-center space-x-8 mb-10">
                    <button @click="prevStation()" class="text-gray-300 hover:text-white transition-colors" title="Previous Station">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="toggleAudio()" class="w-14 h-14 bg-white text-black rounded-full flex items-center justify-center hover:scale-105 transition-transform shadow-lg">
                        <svg x-show="!isAudioPlaying" class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                        <svg x-show="isAudioPlaying" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path></svg>
                    </button>
                    <button @click="nextStation()" class="text-gray-300 hover:text-white transition-colors" title="Next Station">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    </button>
                </div>
                
                <!-- Volume Slider -->
                <div class="w-full flex items-center space-x-4 text-gray-400">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M17.95 6.05a8 8 0 010 11.9M12 18.5V5.5L7 10H4v4h3l5 4.5z"></path></svg>
                    <input type="range" x-model="audioVolume" @input="updateVolume" min="0" max="1" step="0.01" class="flex-1 h-1.5 bg-gray-600 rounded-lg appearance-none cursor-pointer" style="accent-color: white;">
                </div>
            </div>
        </div>

    </main>

    <!-- macOS Dock -->
    <div class="h-16 mb-4 flex justify-center z-50 pointer-events-none">
        <div class="bg-glass backdrop-blur-xl border border-white/10 rounded-2xl px-4 flex items-center space-x-4 pointer-events-auto">
            
            <!-- Terminal App -->
            <button class="w-12 h-12 rounded-xl bg-gray-900 border border-gray-700 flex items-center justify-center hover:scale-110 transition-transform shadow-lg relative group" @click="toggleWindow('terminal')">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="absolute -top-10 bg-secondary px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity">Terminal</span>
                <div class="absolute -bottom-1 w-1 h-1 bg-white rounded-full" x-show="windows.terminal.open"></div>
            </button>

            <!-- Projects App -->
            <button class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center hover:scale-110 transition-transform shadow-lg relative group" @click="toggleWindow('projects')">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span class="absolute -top-10 bg-secondary px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity">Projects</span>
                <div class="absolute -bottom-1 w-1 h-1 bg-white rounded-full" x-show="windows.projects.open" x-cloak></div>
            </button>
            
            <!-- Experience App -->
            <button class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center hover:scale-110 transition-transform shadow-lg relative group" @click="toggleWindow('experience')">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="absolute -top-10 bg-secondary px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity">Experience</span>
                <div class="absolute -bottom-1 w-1 h-1 bg-white rounded-full" x-show="windows.experience.open" x-cloak></div>
            </button>
            
            <!-- Skills App -->
            <button class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center hover:scale-110 transition-transform shadow-lg relative group" @click="toggleWindow('skills')">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                <span class="absolute -top-10 bg-secondary px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity">Skills</span>
                <div class="absolute -bottom-1 w-1 h-1 bg-white rounded-full" x-show="windows.skills.open" x-cloak></div>
            </button>
            
            <!-- Contact App -->
            <button class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center hover:scale-110 transition-transform shadow-lg relative group" @click="toggleWindow('contact')">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="absolute -top-10 bg-secondary px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity">Contact</span>
                <div class="absolute -bottom-1 w-1 h-1 bg-white rounded-full" x-show="windows.contact.open" x-cloak></div>
            </button>
            
            <div class="w-px h-10 bg-white/20 mx-1"></div>

            <!-- Notes App -->
            <button class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-300 to-yellow-600 flex items-center justify-center hover:scale-110 transition-transform shadow-lg relative group" @click="toggleWindow('notes')">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span class="absolute -top-10 bg-secondary px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity">Notes</span>
                <div class="absolute -bottom-1 w-1 h-1 bg-white rounded-full" x-show="windows.notes.open" x-cloak></div>
            </button>
            
            <!-- Music App -->
            <button class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center hover:scale-110 transition-transform shadow-lg relative group" @click="toggleWindow('music')">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                <span class="absolute -top-10 bg-secondary px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Lofi Player</span>
                <div class="absolute -bottom-1 w-1 h-1 bg-white rounded-full" x-show="windows.music.open" x-cloak></div>
            </button>

            <!-- Preferences App -->
            <button class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center hover:scale-110 transition-transform shadow-lg relative group" @click="toggleWindow('preferences')">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="absolute -top-10 bg-secondary px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Settings</span>
                <div class="absolute -bottom-1 w-1 h-1 bg-white rounded-full" x-show="windows.preferences.open" x-cloak></div>
            </button>
            
            <div class="w-px h-10 bg-white/20 mx-1"></div>
            
            <!-- AI App -->
            <button class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center hover:scale-110 transition-transform shadow-lg relative group" @click="toggleWindow('aichat')">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="absolute -top-10 bg-secondary px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Danang AI</span>
                <div class="absolute -bottom-1 w-1 h-1 bg-white rounded-full" x-show="windows.aichat.open" x-cloak></div>
            </button>
            
            <div class="w-px h-10 bg-white/20 mx-2"></div>

            <!-- Admin Panel -->
            <a href="/admin" class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center hover:scale-110 transition-transform shadow-lg relative group">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                <span class="absolute -top-10 bg-secondary px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity">Admin Panel</span>
            </a>

        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            // Draggable Directive
            Alpine.directive('draggable', (el, { modifiers }) => {
                let isDragging = false;
                let startX = 0, startY = 0;
                let initialX = 0, initialY = 0;
                let xOffset = 0, yOffset = 0;

                const handle = el.querySelector('.window-drag-handle') || el;

                handle.addEventListener('mousedown', dragStart);
                document.addEventListener('mouseup', dragEnd);
                document.addEventListener('mousemove', drag);

                function dragStart(e) {
                    if (e.target.tagName.toLowerCase() === 'button' || e.target.closest('button') || e.target.closest('.cursor-pointer')) return;
                    initialX = e.clientX - xOffset;
                    initialY = e.clientY - yOffset;
                    isDragging = true;
                    el.style.opacity = '0.9';
                }
                function dragEnd(e) {
                    initialX = xOffset;
                    initialY = yOffset;
                    isDragging = false;
                    el.style.opacity = '1';
                }
                function drag(e) {
                    if (isDragging) {
                        e.preventDefault();
                        xOffset = e.clientX - initialX;
                        yOffset = e.clientY - initialY;
                        setTranslate(xOffset, yOffset, el);
                    }
                }
                function setTranslate(xPos, yPos, el) {
                    el.style.transform = `translate3d(${xPos}px, ${yPos}px, 0)`;
                }
            });

            Alpine.data('portfolioOS', () => ({
                currentTime: '',
                maxZ: 10,
                windows: {
                    terminal: { open: true, z: 10 },
                    projects: { open: false, z: 9 },
                    experience: { open: false, z: 8 },
                    skills: { open: false, z: 7 },
                    contact: { open: false, z: 6 },
                    aichat: { open: true, z: 11 },
                    projectPreview: { open: false, z: 12 },
                    notes: { open: false, z: 13 },
                    music: { open: false, z: 14 },
                    preferences: { open: false, z: 15 }
                },
                currentWallpaper: 'wallpaper-sonoma',
                termInput: '',
                contactForm: { name: '', email: '', message: '' },
                contactSending: false,
                contactSuccess: false,
                locale: '{{ app()->getLocale() }}',
                
                spotlightOpen: false,
                searchQuery: '',
                projectsData: @json($projects),
                experienceData: @json($experiences),
                skillsData: @json($skills),
                
                selectedProject: null,
                
                booting: true,
                isAudioPlaying: false,
                audioVolume: 0.5,
                stations: @json($stationsToUse),
                currentStationIndex: 0,
                notesData: [
                    { title: "Building DanangOS", date: "August 2026", content: "Today I rebuilt my portfolio into a Mac OS clone.\nIt uses Alpine.js for window management and Tailwind CSS for styling.\nIt's fully draggable and interactive! This Notes app uses mock data until the backend is fully developed." },
                    { title: "Laravel & Vue Tips", date: "July 2026", content: "When building SPAs, always ensure your API endpoints are properly authenticated using Laravel Sanctum.\n\nKeep components small and reusable." },
                    { title: "My Journey in Tech", date: "June 2026", content: "Started as a junior, now I'm a full stack developer building crazy OS-like portfolios on the web. It is incredibly fun to combine design and coding to build something memorable." }
                ],
                selectedNoteIndex: 0,
                
                aiHistory: [],
                aiInput: '',
                aiThinking: false,

                get searchResults() {
                    if (this.searchQuery.trim() === '') return [];
                    const q = this.searchQuery.toLowerCase();
                    const results = [];
                    this.projectsData.forEach(p => {
                        const title = this.locale === 'en' ? (p.title_en || p.title_id) : (p.title_id || p.title_en);
                        const desc = this.locale === 'en' ? (p.description_en || p.description_id) : (p.description_id || p.description_en);
                        if ((title && title.toLowerCase().includes(q)) || (desc && desc.toLowerCase().includes(q))) {
                            results.push({ type: 'Project', title: title, desc: desc, app: 'projects' });
                        }
                    });
                    this.experienceData.forEach(e => {
                        const title = this.locale === 'en' ? (e.title_en || e.title_id) : (e.title_id || e.title_en);
                        const desc = this.locale === 'en' ? (e.description_en || e.description_id) : (e.description_id || e.description_en);
                        if ((title && title.toLowerCase().includes(q)) || (e.company && e.company.toLowerCase().includes(q))) {
                            results.push({ type: 'Experience', title: `${title} @ ${e.company}`, desc: desc, app: 'experience' });
                        }
                    });
                    this.skillsData.forEach(s => {
                        const title = this.locale === 'en' ? (s.title_en || s.title_id) : (s.title_id || s.title_en);
                        if (title && title.toLowerCase().includes(q)) {
                            results.push({ type: 'Skill', title: title, desc: `Proficiency: ${s.percentage}%`, app: 'skills' });
                        }
                    });
                    return results;
                },
                init() {
                    // Boot Sequence
                    const bootLines = [
                        'DanangOS Kernel v2.0.0 booting...',
                        'Initializing Memory Management... [OK]',
                        'Mounting Virtual File System... [OK]',
                        'Starting Networking Services... eth0 [UP]',
                        'Loading Desktop Environment...',
                        'Welcome to DanangOS.'
                    ];
                    let i = 0;
                    const bootInterval = setInterval(() => {
                        const el = document.getElementById('boot-text');
                        if (el && i < bootLines.length) {
                            el.innerHTML += bootLines[i] + '<br>';
                            i++;
                        } else {
                            clearInterval(bootInterval);
                            setTimeout(() => {
                                this.booting = false;
                                this.initTyped();
                            }, 1500);
                        }
                    }, 400);

                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                },
                initTyped() {
                    if (this.typedInterval) clearTimeout(this.typedInterval);
                    const el = document.getElementById('typed-output');
                    if (!el) return;
                    el.innerHTML = '';

                    const whoamiId = "Saya adalah seorang Web Developer dan mahasiswa Sistem Informasi yang memiliki minat besar terhadap pengembangan perangkat lunak dan teknologi web modern.<br><br>Berbekal pengalaman sebagai Web Developer Intern di Kementerian Perdagangan Republik Indonesia, sertifikasi BNSP Junior Web Developer, serta pengalaman dalam organisasi dan kompetisi teknologi, saya terus berkomitmen untuk mengembangkan solusi digital yang berkualitas, efisien, dan berorientasi pada kebutuhan pengguna.<br><br>Saya percaya bahwa setiap aplikasi yang baik tidak hanya dibangun dengan teknologi yang tepat, tetapi juga melalui pemahaman terhadap kebutuhan pengguna, perhatian terhadap detail, dan semangat untuk terus belajar mengikuti perkembangan industri.<br><br>Di luar aktivitas pengembangan perangkat lunak, saya senang mengeksplorasi teknologi baru, membangun proyek pribadi, serta terus meningkatkan kemampuan agar dapat memberikan kontribusi yang lebih besar di dunia teknologi.";
                    const whoamiEn = "I am a Web Developer and Information Systems student with a strong passion for software development and modern web technologies.<br><br>With experience as a Web Developer Intern at the Ministry of Trade of the Republic of Indonesia, a BNSP Junior Web Developer certification, and involvement in tech organizations and competitions, I am constantly committed to developing high-quality, efficient, and user-oriented digital solutions.<br><br>I believe that every good application is built not only with the right technology but also through a deep understanding of user needs, attention to detail, and a passion for continuous learning in a fast-paced industry.<br><br>Outside of software development, I enjoy exploring new technologies, building personal projects, and continuously improving my skills to make a greater impact in the tech world.";
                    
                    const commands = [
                        { cmd: 'whoami', out: this.locale === 'en' ? whoamiEn : whoamiId },
                        { cmd: 'skills', out: 'Laravel, Vue, React, Tailwind, MySQL' },
                        { cmd: './explore.sh', out: this.locale === 'en' ? 'Click the apps in the dock to explore.' : 'Klik aplikasi di dock untuk menjelajah.' }
                    ];
                    
                    let cmdIndex = 0;
                    let charIndex = 0;
                    let isTypingOutput = false;
                    
                    const typeNext = () => {
                        if (cmdIndex >= commands.length) return;
                        
                        if (charIndex === 0 && !isTypingOutput) {
                            el.innerHTML += (cmdIndex > 0 ? '<br><br>' : '') + '<span class="text-success">danang@portfolio:~$</span> ';
                        }
                        
                        const currentText = isTypingOutput ? commands[cmdIndex].out : commands[cmdIndex].cmd;
                        
                        if (charIndex < currentText.length) {
                            // Check for HTML tags like <br><br> in the output so it doesn't print < and b separately
                            if (isTypingOutput && currentText.substring(charIndex, charIndex + 4) === '<br>') {
                                el.innerHTML += '<br>';
                                charIndex += 4;
                            } else {
                                el.innerHTML += currentText.charAt(charIndex);
                                charIndex++;
                            }
                            
                            // Commands are typed faster, output is typed slower
                            const delay = isTypingOutput ? (20 + Math.random() * 20) : (40 + Math.random() * 40);
                            this.typedInterval = setTimeout(typeNext, delay);
                        } else {
                            if (!isTypingOutput) {
                                // Done typing command, wait a bit then start typing output
                                this.typedInterval = setTimeout(() => {
                                    el.innerHTML += '<br><span class="text-gray-300">';
                                    isTypingOutput = true;
                                    charIndex = 0;
                                    typeNext();
                                }, 300);
                            } else {
                                // Done typing output, close span and wait before next command
                                el.innerHTML += '</span>';
                                isTypingOutput = false;
                                cmdIndex++;
                                charIndex = 0;
                                this.typedInterval = setTimeout(typeNext, 800);
                            }
                        }
                    };
                    
                    typeNext();
                },
                handleTerminalCommand() {
                    const raw = this.termInput.trim();
                    if (!raw) return;
                    this.termInput = '';
                    
                    const el = document.getElementById('typed-output');
                    if (!el) return;

                    const command = raw.toLowerCase();
                    const escaped = raw.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
                    
                    let responseHtml = '';

                    if (command === 'clear') {
                        el.innerHTML = '';
                        return;
                    } else if (command === 'neofetch' || command === 'fetch') {
                        const wallName = this.currentWallpaper.replace('wallpaper-', '').toUpperCase();
                        responseHtml = `
<div class="flex flex-col sm:flex-row items-start space-x-0 sm:space-x-4 my-2 text-xs font-mono">
<pre class="text-cyan-400 font-bold leading-tight hidden sm:block">
  ██████╗  █████╗ ███╗   ██╗ █████╗ ███╗   ██╗ ██████╗ 
  ██╔══██╗██╔══██╗████╗  ██║██╔══██╗████╗  ██║██╔════╝ 
  ██║  ██║███████║██╔██╗ ██║███████║██╔██╗ ██║██║  ███╗
  ██║  ██║██╔══██║██║╚██╗██║██╔══██║██║╚██╗██║██║   ██║
  ██████╔╝██║  ██║██║ ╚████║██║  ██║██║ ╚████║╚██████╔╝
  ╚═════╝ ╚═╝  ╚═╝╚═╝  ╚═══╝╚═╝  ╚═══╝╚═╝  ╚═══╝ ╚═════╝ 
</pre>
<div class="text-gray-200 space-y-0.5">
<span class="text-emerald-400 font-bold">danang@portfolio</span><br>
----------------<br>
<span class="text-blue-400 font-bold">OS:</span> DanangOS v2.0.0 (Mac OS Clone)<br>
<span class="text-blue-400 font-bold">Kernel:</span> Alpine.js 3.x / Tailwind CSS v4<br>
<span class="text-blue-400 font-bold">Framework:</span> Laravel 11 / Filament Admin<br>
<span class="text-blue-400 font-bold">Wallpaper:</span> <span class="text-yellow-400 font-bold">${wallName}</span><br>
<span class="text-blue-400 font-bold">Stack:</span> PHP, JavaScript, MySQL, Tailwind, Alpine<br>
<span class="text-blue-400 font-bold">Status:</span> <span class="text-emerald-400 font-bold">Available for hire / opportunities</span><br>
<div class="flex space-x-1 mt-2">
<span class="w-3 h-3 bg-red-500 rounded-sm inline-block"></span>
<span class="w-3 h-3 bg-green-500 rounded-sm inline-block"></span>
<span class="w-3 h-3 bg-yellow-500 rounded-sm inline-block"></span>
<span class="w-3 h-3 bg-blue-500 rounded-sm inline-block"></span>
<span class="w-3 h-3 bg-purple-500 rounded-sm inline-block"></span>
<span class="w-3 h-3 bg-pink-500 rounded-sm inline-block"></span>
</div>
</div>
</div>`;
                    } else if (command === 'help') {
                        responseHtml = `
<div class="text-gray-300 my-1 text-xs font-mono space-y-1">
<div class="text-accent font-bold">Available Commands:</div>
<div><span class="text-yellow-400 font-bold">neofetch</span> - Display system specifications & logo</div>
<div><span class="text-yellow-400 font-bold">theme &lt;name&gt;</span> - Change wallpaper (sonoma, cyberpunk, retrowave, matrix)</div>
<div><span class="text-yellow-400 font-bold">wallpaper &lt;1-4&gt;</span> - Change wallpaper by index</div>
<div><span class="text-yellow-400 font-bold">matrix</span> - Show digital rain ASCII effect</div>
<div><span class="text-yellow-400 font-bold">whoami</span> - Display Danang's bio</div>
<div><span class="text-yellow-400 font-bold">skills</span> - List core technical skills</div>
<div><span class="text-yellow-400 font-bold">projects</span> - Open Projects window</div>
<div><span class="text-yellow-400 font-bold">contact</span> - Open Contact window</div>
<div><span class="text-yellow-400 font-bold">music</span> - Open Lofi Music Player</div>
<div><span class="text-yellow-400 font-bold">pref</span> - Open System Preferences</div>
<div><span class="text-yellow-400 font-bold">clear</span> - Clear terminal screen</div>
</div>`;
                    } else if (command.startsWith('theme ') || command.startsWith('wallpaper ')) {
                        const arg = command.split(' ')[1];
                        if (arg === '1' || arg === 'sonoma') {
                            this.currentWallpaper = 'wallpaper-sonoma';
                            responseHtml = '<div class="text-emerald-400">Wallpaper changed to Sonoma Dark.</div>';
                        } else if (arg === '2' || arg === 'cyberpunk') {
                            this.currentWallpaper = 'wallpaper-cyberpunk';
                            responseHtml = '<div class="text-emerald-400">Wallpaper changed to Cyberpunk Neon.</div>';
                        } else if (arg === '3' || arg === 'retrowave') {
                            this.currentWallpaper = 'wallpaper-retrowave';
                            responseHtml = '<div class="text-emerald-400">Wallpaper changed to Retrowave Sunset.</div>';
                        } else if (arg === '4' || arg === 'matrix') {
                            this.currentWallpaper = 'wallpaper-matrix';
                            responseHtml = '<div class="text-emerald-400">Wallpaper changed to Matrix Emerald.</div>';
                        } else {
                            responseHtml = '<div class="text-red-400">Unknown theme. Available: sonoma, cyberpunk, retrowave, matrix (or 1..4)</div>';
                        }
                    } else if (command === 'matrix') {
                        responseHtml = `
<div class="text-emerald-400 font-mono text-xs my-2 leading-none">
01000100 01000001 01001110 01000001 01001110 01000111 01001111 01010011<br>
Wake up, Neo... The Matrix has you.<br>
01000011 01001111 01000100 01001001 01001110 01000111 00100000 01010011 01001111 01000011 01001011 01010011<br>
Follow the white rabbit. 🐇
</div>`;
                    } else if (command === 'whoami') {
                        responseHtml = '<div class="text-gray-300 my-1">Danang Abu Hafid - Full Stack Developer & Information Systems Student.</div>';
                    } else if (command === 'skills') {
                        responseHtml = '<div class="text-gray-300 my-1">Laravel, Vue.js, React, Tailwind CSS, MySQL, Alpine.js, PHP, JavaScript, Git</div>';
                    } else if (command === 'projects') {
                        this.windows.projects.open = true;
                        this.bringToFront('projects');
                        responseHtml = '<div class="text-emerald-400">Opening Projects window...</div>';
                    } else if (command === 'contact') {
                        this.windows.contact.open = true;
                        this.bringToFront('contact');
                        responseHtml = '<div class="text-emerald-400">Opening Contact window...</div>';
                    } else if (command === 'music') {
                        this.windows.music.open = true;
                        this.bringToFront('music');
                        responseHtml = '<div class="text-emerald-400">Opening Music Player...</div>';
                    } else if (command === 'pref' || command === 'settings' || command === 'preferences') {
                        this.windows.preferences.open = true;
                        this.bringToFront('preferences');
                        responseHtml = '<div class="text-emerald-400">Opening System Preferences...</div>';
                    } else {
                        responseHtml = `<div class="text-red-400">zsh: command not found: ${escaped}. Type 'help' for available commands.</div>`;
                    }

                    el.innerHTML += `<br><br><span class="text-success">danang@portfolio:~$</span> ${escaped}<br>${responseHtml}`;
                    
                    this.$nextTick(() => {
                        const termContainer = document.getElementById('terminal-content');
                        if (termContainer) termContainer.scrollTop = termContainer.scrollHeight;
                    });
                },
                updateTime() {
                    const now = new Date();
                    const day = String(now.getDate()).padStart(2, '0');
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const year = now.getFullYear();
                    const time = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    
                    // Short day name (e.g. Sat)
                    const dayName = now.toLocaleDateString('en-US', { weekday: 'short' });
                    
                    this.currentTime = `${dayName} ${day}-${month}-${year} ${time}`;
                },
                toggleLanguage() {
                    this.locale = this.locale === 'en' ? 'id' : 'en';
                    fetch('/language', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ locale: this.locale })
                    });
                    
                    // Only start typing if booting is already finished
                    if (!this.booting) {
                        this.initTyped();
                    }
                },
                toggleWindow(id) {
                    this.windows[id].open = !this.windows[id].open;
                    if(this.windows[id].open) {
                        this.bringToFront(id);
                    }
                },
                bringToFront(id) {
                    this.maxZ++;
                    this.windows[id].z = this.maxZ;
                },
                executeAiCommand() {
                    if (!this.aiInput.trim() || this.aiThinking) return;
                    const prompt = this.aiInput.trim();
                    
                    this.aiHistory.push({ id: Date.now(), type: 'user', content: prompt });
                    this.aiInput = '';
                    this.aiThinking = true;
                    
                    setTimeout(() => {
                        const el = document.getElementById('aichat-content');
                        if (el) el.scrollTop = el.scrollHeight;
                    }, 50);

                    fetch('/ai-chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ prompt: prompt })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.aiThinking = false;
                        this.aiHistory.push({ id: Date.now(), type: 'ai', content: data.response });
                        setTimeout(() => {
                            const el = document.getElementById('aichat-content');
                            if (el) el.scrollTop = el.scrollHeight;
                        }, 50);
                    })
                    .catch(err => {
                        this.aiThinking = false;
                        this.aiHistory.push({ id: Date.now(), type: 'ai', content: 'Connection Error: ' + err.message });
                    });
                },
                submitContact() {
                    this.contactSending = true;
                    // Mock AJAX request since backend endpoint is pending
                    setTimeout(() => {
                        this.contactSending = false;
                        this.contactSuccess = true;
                        this.contactForm = { name: '', email: '', message: '' };
                        setTimeout(() => this.contactSuccess = false, 3000);
                    }, 1500);
                },
                openProjectPreview(projectId) {
                    const project = this.projectsData.find(p => p.id === projectId);
                    if (project) {
                        this.selectedProject = project;
                        if (!this.windows.projectPreview) {
                            this.windows.projectPreview = { open: true, z: ++this.maxZ };
                        } else {
                            this.windows.projectPreview.open = true;
                            this.bringToFront('projectPreview');
                        }
                    }
                },
                toggleAudio() {
                    const audio = document.getElementById('lofi-audio');
                    if (this.isAudioPlaying) {
                        audio.pause();
                        this.isAudioPlaying = false;
                    } else {
                        audio.volume = this.audioVolume;
                        audio.play().catch(e => console.log('Audio playback failed', e));
                        this.isAudioPlaying = true;
                    }
                },
                nextStation() {
                    this.currentStationIndex = (this.currentStationIndex + 1) % this.stations.length;
                    this.changeStation();
                },
                prevStation() {
                    this.currentStationIndex = (this.currentStationIndex - 1 + this.stations.length) % this.stations.length;
                    this.changeStation();
                },
                changeStation() {
                    const audio = document.getElementById('lofi-audio');
                    if (audio) {
                        const wasPlaying = this.isAudioPlaying;
                        audio.pause();
                        
                        // Manually set src so we don't wait for Alpine's next DOM tick
                        audio.src = this.stations[this.currentStationIndex].src;
                        audio.load();
                        
                        if (wasPlaying) {
                            audio.play().catch(e => console.log('Audio playback failed', e));
                        }
                    }
                },
                updateVolume() {
                    const audio = document.getElementById('lofi-audio');
                    if (audio) {
                        audio.volume = this.audioVolume;
                    }
                },
                closeMusic() {
                    this.windows.music.open = false;
                    const audio = document.getElementById('lofi-audio');
                    if (audio) {
                        audio.pause();
                        this.isAudioPlaying = false;
                    }
                }
            }))
        })
    </script>
</body>
</html>
