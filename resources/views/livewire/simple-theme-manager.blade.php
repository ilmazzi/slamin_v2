<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-white to-neutral-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-gradient mb-4">
                🎨 Color Generator
            </h1>
            <p class="text-xl text-neutral-600">
                Scegli 1 colore → Genera palette completa (50-950) + semantici fissi
            </p>
        </div>

        <!-- Messages -->
        @if($message)
            <div class="mb-8 animate-fade-in">
                @if($messageType === 'success')
                    <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg shadow-md">
                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-green-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="text-lg font-semibold text-green-800">Successo!</h3>
                                <p class="text-green-700 mt-1">{{ $message }}</p>
                                <div class="mt-4 p-4 bg-green-100 rounded border border-green-200">
                                    <p class="text-sm text-green-800 font-mono">
                                        💡 Ora esegui: <strong>npm run dev</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($messageType === 'error')
                    <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg shadow-md">
                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-red-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="text-lg font-semibold text-red-800">Errore</h3>
                                <p class="text-red-700 mt-1">{{ $message }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg shadow-md">
                        <p class="text-blue-700">{{ $message }}</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Main Generator Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 border border-neutral-200 mb-8">
            
            <!-- Preset Selection -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-neutral-800 mb-4">1️⃣ Scegli Tipo Palette</h2>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                    @foreach($presets as $key => $preset)
                        <button wire:click="selectPreset('{{ $key }}')"
                                class="p-4 rounded-xl border-2 transition-all duration-300 {{ $selectedPreset === $key ? 'border-primary-500 bg-primary-50 shadow-lg scale-105' : 'border-neutral-200 hover:border-neutral-300 hover:shadow-md' }}">
                            <div class="text-4xl mb-2">{{ $preset['icon'] }}</div>
                            <div class="font-bold text-neutral-800 text-sm">{{ $preset['name'] }}</div>
                            <div class="text-xs text-neutral-500 mt-1">{{ $preset['desc'] }}</div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Color Input -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-neutral-800 mb-4">2️⃣ Scegli il Colore Base</h2>
                <div class="flex gap-4 items-end">
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-neutral-700 mb-2">
                            🎨 Colore {{ $presets[$selectedPreset]['name'] }}
                        </label>
                        <div class="flex gap-3">
                            <input type="color" 
                                   wire:model.live="baseColor"
                                   class="w-24 h-16 rounded-xl cursor-pointer border-2 border-neutral-300">
                            <input type="text" 
                                   wire:model.live="baseColor"
                                   placeholder="#9bdbe8"
                                   class="flex-1 px-6 py-4 border-2 border-neutral-300 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-200 transition-all font-mono text-lg">
                        </div>
                    </div>
                </div>
                <p class="text-sm text-neutral-500 mt-3">
                    💡 Il sistema genererà 11 sfumature (50-950) da questo colore usando algoritmo CIELab
                </p>
            </div>

            <!-- Generate Button -->
            <button wire:click="generatePreview"
                    class="w-full px-8 py-5 bg-gradient-to-r from-primary-500 to-primary-700 hover:from-primary-600 hover:to-primary-800 text-white rounded-xl font-bold text-xl transition-all duration-300 transform hover:scale-[1.02] shadow-xl hover:shadow-2xl flex items-center justify-center gap-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Genera Palette
            </button>
        </div>

        <!-- Preview -->
        @if($preview)
        <div class="space-y-8 animate-fade-in">
            
            <!-- Apply Button -->
            <div class="flex items-center justify-between">
                <h2 class="text-3xl font-bold text-neutral-800">
                    👁️ Preview: {{ $presets[$selectedPreset]['name'] }}
                </h2>
                <button wire:click="applyPalette"
                        class="px-10 py-4 bg-green-500 hover:bg-green-600 text-white rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-xl">
                    ✓ Applica Palette
                </button>
            </div>

            <!-- Main Palette -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-neutral-200">
                <h3 class="text-2xl font-bold text-neutral-800 mb-6">
                    Palette Principale (50-950)
                </h3>
                <div class="grid grid-cols-11 gap-2">
                    @foreach($preview['main'] as $shade => $color)
                        <div class="text-center">
                            <div class="aspect-square rounded-lg shadow-lg mb-2 border border-neutral-200 hover:scale-110 transition-transform cursor-pointer" 
                                 style="background-color: {{ $color }}"
                                 title="{{ $shade }}: {{ $color }}">
                            </div>
                            <span class="text-xs font-bold text-neutral-600">{{ $shade }}</span>
                            <div class="text-xs font-mono text-neutral-400 mt-1">{{ $color }}</div>
                        </div>
                    @endforeach
                </div>
                <p class="text-sm text-neutral-500 mt-6">
                    💡 Generato con algoritmo CIELab per uniformità percettiva (come Tailwind ufficiale!)
                </p>
            </div>

            <!-- Semantic Colors -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-neutral-200">
                <h3 class="text-2xl font-bold text-neutral-800 mb-4">
                    Colori Semantici (Fissi tipo Tailwind)
                </h3>
                <div class="grid md:grid-cols-4 gap-6">
                    @foreach(['success' => '✅ Success', 'warning' => '⚠️ Warning', 'error' => '❌ Error', 'info' => 'ℹ️ Info'] as $key => $label)
                        <div class="text-center">
                            <div class="h-32 rounded-xl shadow-lg mb-3 flex items-center justify-center text-white font-bold text-lg" 
                                 style="background-color: {{ $preview['semantic'][$key] }}">
                                {{ $label }}
                            </div>
                            <span class="text-sm font-semibold text-neutral-700">{{ ucfirst($key) }}</span>
                            <div class="text-xs font-mono text-neutral-500 mt-1">{{ $preview['semantic'][$key] }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <strong>ℹ️ Nota:</strong> I colori semantici sono fissi tipo Tailwind (sempre gli stessi) e NON derivano dalla palette principale.
                        Questo garantisce che Success sia sempre VERDE, Error sempre ROSSO, etc.
                    </p>
                </div>
            </div>

        </div>
        @endif

        <!-- Info Box -->
        <div class="mt-12 bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 rounded-xl p-8 shadow-lg">
            <h3 class="text-lg font-bold text-blue-900 mb-3">
                ℹ️ Come Funziona (stile UIColors.app)
            </h3>
            <div class="text-blue-800 space-y-2">
                <p><strong>1.</strong> Scegli un preset (Sky, Emerald, Orange, Rose, Slate)</p>
                <p><strong>2.</strong> Personalizza il colore base (o usa quello suggerito)</p>
                <p><strong>3.</strong> Clicca "Genera Palette" → Vedi 11 sfumature (50-950) con algoritmo CIELab</p>
                <p><strong>4.</strong> I semantici sono FISSI (verde=success, rosso=error, sempre uguali)</p>
                <p><strong>5.</strong> Applica la palette</p>
                <p><strong>6.</strong> Ricompila con <code class="bg-blue-100 px-2 py-1 rounded font-mono text-sm">npm run dev</code></p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="/" class="inline-flex items-center px-6 py-3 bg-neutral-800 hover:bg-neutral-900 text-white rounded-lg font-semibold transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Torna alla Home
            </a>
        </div>

    </div>
</div>

