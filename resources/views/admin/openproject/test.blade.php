<x-layouts.app>
    <x-slot name="title">Test Integrazione OpenProject</x-slot>

<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">
                    Test Integrazione OpenProject
                </h1>
                <p class="text-neutral-600 dark:text-neutral-400">
                    Verifica la connessione e testa la creazione di work packages
                </p>
            </div>

            {{-- Alert Messages --}}
            <div id="alert-container" class="mb-6"></div>

            {{-- Configuration Status --}}
            <div class="mb-6 p-4 bg-neutral-100 dark:bg-neutral-700 rounded-lg">
                <h3 class="font-semibold text-neutral-900 dark:text-white mb-2">Stato Configurazione</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="font-medium">URL:</span>
                        <span id="config-url" class="text-neutral-600 dark:text-neutral-400">
                            {{ config('services.openproject.url') ?: 'Non configurato' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-medium">API Key:</span>
                        <span id="config-key" class="text-neutral-600 dark:text-neutral-400">
                            {{ config('services.openproject.api_key') ? 'Configurato' : 'Non configurato' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-medium">Project ID:</span>
                        <span id="config-project" class="text-neutral-600 dark:text-neutral-400">
                            {{ config('services.openproject.project_id') ?: 'Non configurato' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Test Actions --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <button onclick="testConnection()" 
                        class="px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Test Connessione
                </button>

                <button onclick="loadProjects()" 
                        class="px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Carica Progetti
                </button>

                <button onclick="loadStatuses()" 
                        class="px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Carica Stati
                </button>

                <button onclick="loadWorkPackages()" 
                        class="px-4 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Carica Work Packages
                </button>
            </div>

            {{-- Projects List --}}
            <div id="projects-section" class="mb-6 hidden">
                <h3 class="font-semibold text-neutral-900 dark:text-white mb-3">Progetti Disponibili</h3>
                <div id="projects-list" class="space-y-2"></div>
            </div>

            {{-- Work Package Types --}}
            <div id="types-section" class="mb-6 hidden">
                <h3 class="font-semibold text-neutral-900 dark:text-white mb-3">Tipi Work Package</h3>
                <div id="types-list" class="space-y-2"></div>
            </div>

            {{-- Statuses List --}}
            <div id="statuses-section" class="mb-6 hidden">
                <h3 class="font-semibold text-neutral-900 dark:text-white mb-3">Stati Disponibili</h3>
                <div id="statuses-list" class="space-y-2"></div>
            </div>

            {{-- Create Test Work Package --}}
            <div class="border-t border-neutral-200 dark:border-neutral-700 pt-6 mt-6">
                <h3 class="font-semibold text-neutral-900 dark:text-white mb-4">Crea Work Package di Test</h3>
                <form id="create-wp-form" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Project ID
                        </label>
                        <input type="number" id="wp-project-id" name="project_id" 
                               value="{{ config('services.openproject.project_id') }}"
                               class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Type ID (default: 1 = Bug)
                        </label>
                        <input type="number" id="wp-type-id" name="type_id" 
                               value="{{ config('services.openproject.type_id', 1) }}"
                               class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Titolo
                        </label>
                        <input type="text" id="wp-subject" name="subject" 
                               value="Test Feedback da Slam in"
                               class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Descrizione
                        </label>
                        <textarea id="wp-description" name="description" rows="4"
                                  class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">Questo è un work package di test creato dal sistema di feedback di Slam in.</textarea>
                    </div>

                    <button type="submit" 
                            class="w-full px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Crea Work Package
                    </button>
                </form>
            </div>

            {{-- Results --}}
            <div id="results-section" class="mt-6 hidden">
                <h3 class="font-semibold text-neutral-900 dark:text-white mb-3">Risultati</h3>
                <pre id="results-content" class="p-4 bg-neutral-100 dark:bg-neutral-900 rounded-lg text-sm overflow-auto max-h-96"></pre>
            </div>
        </div>
    </div>
</div>

<script>
function showAlert(message, type = 'info') {
    const container = document.getElementById('alert-container');
    const colors = {
        success: 'bg-green-100 dark:bg-green-900 border-green-400 dark:border-green-700 text-green-700 dark:text-green-300',
        error: 'bg-red-100 dark:bg-red-900 border-red-400 dark:border-red-700 text-red-700 dark:text-red-300',
        info: 'bg-blue-100 dark:bg-blue-900 border-blue-400 dark:border-blue-700 text-blue-700 dark:text-blue-300',
        warning: 'bg-yellow-100 dark:bg-yellow-900 border-yellow-400 dark:border-yellow-700 text-yellow-700 dark:text-yellow-300'
    };
    
    container.innerHTML = `
        <div class="p-4 border rounded-lg ${colors[type]}">
            ${message}
        </div>
    `;
    
    setTimeout(() => {
        container.innerHTML = '';
    }, 5000);
}

function showResults(data) {
    const section = document.getElementById('results-section');
    const content = document.getElementById('results-content');
    section.classList.remove('hidden');
    content.textContent = JSON.stringify(data, null, 2);
}

async function testConnection() {
    showAlert('Test connessione in corso...', 'info');
    
    try {
        const response = await fetch('{{ route("admin.openproject.test.connection") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('✓ Connessione riuscita!', 'success');
            showResults(data);
        } else {
            showAlert('✗ Connessione fallita: ' + data.message, 'error');
            showResults(data);
        }
    } catch (error) {
        showAlert('✗ Errore: ' + error.message, 'error');
    }
}

async function loadProjects() {
    showAlert('Caricamento progetti...', 'info');
    
    try {
        const response = await fetch('{{ route("admin.openproject.test.projects") }}', {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('✓ Progetti caricati!', 'success');
            displayProjects(data.projects);
            showResults(data);
        } else {
            showAlert('✗ Errore: ' + data.message, 'error');
            showResults(data);
        }
    } catch (error) {
        showAlert('✗ Errore: ' + error.message, 'error');
    }
}

function displayProjects(projects) {
    const section = document.getElementById('projects-section');
    const list = document.getElementById('projects-list');
    const projectIdInput = document.getElementById('wp-project-id');
    
    section.classList.remove('hidden');
    list.innerHTML = '';
    
    if (projects.length === 0) {
        list.innerHTML = '<p class="text-neutral-600 dark:text-neutral-400">Nessun progetto trovato</p>';
        return;
    }
    
    projects.forEach(project => {
        const item = document.createElement('div');
        item.className = 'p-3 bg-neutral-100 dark:bg-neutral-700 rounded-lg cursor-pointer hover:bg-neutral-200 dark:hover:bg-neutral-600 transition-colors';
        item.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex-1" onclick="selectProject(${project.id}, '${(project.name || project.identifier).replace(/'/g, "\\'")}')">
                    <p class="font-semibold text-neutral-900 dark:text-white">${project.name || project.identifier}</p>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">ID: ${project.id} | Identifier: ${project.identifier || 'N/A'}</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="selectProject(${project.id}, '${(project.name || project.identifier).replace(/'/g, "\\'")}')" 
                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg">
                        Usa
                    </button>
                    <button onclick="loadTypes(${project.id})" 
                            class="px-3 py-1 bg-primary-600 hover:bg-primary-700 text-white text-sm rounded-lg">
                        Tipi
                    </button>
                </div>
            </div>
        `;
        list.appendChild(item);
    });
}

function selectProject(projectId, projectName) {
    document.getElementById('wp-project-id').value = projectId;
    showAlert(`✓ Progetto selezionato: ${projectName} (ID: ${projectId})`, 'success');
}

async function loadTypes(projectId) {
    showAlert('Caricamento tipi...', 'info');
    
    try {
        const response = await fetch(`{{ route("admin.openproject.test.types") }}?project_id=${projectId}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('✓ Tipi caricati!', 'success');
            displayTypes(data.types);
            showResults(data);
        } else {
            showAlert('✗ Errore: ' + data.message, 'error');
            showResults(data);
        }
    } catch (error) {
        showAlert('✗ Errore: ' + error.message, 'error');
    }
}

function displayTypes(types) {
    const section = document.getElementById('types-section');
    const list = document.getElementById('types-list');
    
    section.classList.remove('hidden');
    list.innerHTML = '';
    
    if (types.length === 0) {
        list.innerHTML = '<p class="text-neutral-600 dark:text-neutral-400">Nessun tipo trovato</p>';
        return;
    }
    
    types.forEach(type => {
        const item = document.createElement('div');
        item.className = 'p-3 bg-neutral-100 dark:bg-neutral-700 rounded-lg';
        item.innerHTML = `
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-semibold text-neutral-900 dark:text-white">${type.name}</p>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">ID: ${type.id}</p>
                </div>
            </div>
        `;
        list.appendChild(item);
    });
}

async function loadStatuses() {
    showAlert('Caricamento stati...', 'info');
    
    try {
        const response = await fetch('{{ route("admin.openproject.test.statuses") }}', {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('✓ Stati caricati!', 'success');
            displayStatuses(data.statuses);
            showResults(data);
        } else {
            showAlert('✗ Errore: ' + data.message, 'error');
            showResults(data);
        }
    } catch (error) {
        showAlert('✗ Errore: ' + error.message, 'error');
    }
}

function displayStatuses(statuses) {
    const section = document.getElementById('statuses-section');
    const list = document.getElementById('statuses-list');
    
    if (!section || !list) {
        console.error('Elementi statuses-section o statuses-list non trovati');
        return;
    }
    
    section.classList.remove('hidden');
    list.innerHTML = '';
    
    if (!statuses || statuses.length === 0) {
        list.innerHTML = '<p class="text-neutral-600 dark:text-neutral-400">Nessuno stato trovato</p>';
        return;
    }
    
    statuses.forEach(status => {
        const item = document.createElement('div');
        item.className = 'p-3 bg-neutral-100 dark:bg-neutral-700 rounded-lg';
        item.innerHTML = `
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-semibold text-neutral-900 dark:text-white">${status.name || 'N/A'}</p>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">ID: ${status.id || 'N/A'}</p>
                    ${status.isDefault ? '<span class="text-xs bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-2 py-1 rounded">Default</span>' : ''}
                </div>
            </div>
        `;
        list.appendChild(item);
    });
}

async function loadWorkPackages() {
    showAlert('Caricamento work packages...', 'info');
    
    try {
        const projectId = document.getElementById('wp-project-id')?.value || '{{ config("services.openproject.project_id", 3) }}';
        const response = await fetch(`{{ route("admin.openproject.test.work-packages") }}?project_id=${projectId}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        });
        
        const data = await response.json();
        
        if (data.success) {
            let message = `✓ ${data.total || data.work_packages?.length || 0} work packages caricati!`;
            if (data.kanban_info) {
                message += `\n\n📊 Info Kanban:\n- Bug totali: ${data.kanban_info.total_bugs}\n- Bug con stato "New": ${data.kanban_info.bugs_with_status_new}\n\n${data.kanban_info.message}`;
            }
            showAlert(message, 'success');
            displayWorkPackages(data.work_packages || []);
            showResults(data);
            
            // Mostra info kanban se disponibile
            if (data.kanban_info && data.kanban_info.bugs_with_status_new > 0) {
                const kanbanInfo = document.createElement('div');
                kanbanInfo.className = 'mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg';
                let bugsList = '';
                if (data.kanban_info.bugs_list && data.kanban_info.bugs_list.length > 0) {
                    bugsList = '<ul class="list-disc list-inside mt-2 space-y-1">';
                    data.kanban_info.bugs_list.forEach(bug => {
                        bugsList += `<li>#${bug.id}: "${bug.subject}" (${bug.type} - ${bug.status})</li>`;
                    });
                    bugsList += '</ul>';
                }
                
                kanbanInfo.innerHTML = `
                    <h4 class="font-semibold text-yellow-900 dark:text-yellow-200 mb-2">⚠️ Informazioni Kanban Board</h4>
                    <p class="text-sm text-yellow-800 dark:text-yellow-300 mb-2">
                        ${data.kanban_info.message}
                    </p>
                    ${bugsList}
                    <div class="mt-3 p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded">
                        <p class="text-sm font-semibold text-yellow-900 dark:text-yellow-200 mb-1">🔧 Soluzioni da provare:</p>
                        <ol class="list-decimal list-inside text-sm text-yellow-800 dark:text-yellow-300 space-y-1">
                            <li>Rimuovi e riaggiungi il filtro "Type: Bug" nel kanban board</li>
                            <li>Verifica che non ci siano altri filtri attivi (Status, Project, ecc.)</li>
                            <li>Ricarica la pagina del kanban board (F5)</li>
                            <li>Verifica che i work package siano nel progetto "Slamin.it - User Feedback"</li>
                            <li>Prova a rimuovere tutti i filtri temporaneamente per vedere se compaiono</li>
                        </ol>
                    </div>
                `;
                const section = document.getElementById('work-packages-section');
                if (section) {
                    section.appendChild(kanbanInfo);
                }
            }
        } else {
            showAlert('✗ Errore: ' + data.message, 'error');
            showResults(data);
        }
    } catch (error) {
        showAlert('✗ Errore: ' + error.message, 'error');
    }
}

function displayWorkPackages(workPackages) {
    const section = document.getElementById('work-packages-section');
    const list = document.getElementById('work-packages-list');
    
    if (!section || !list) {
        console.error('Elementi work-packages-section o work-packages-list non trovati');
        return;
    }
    
    section.classList.remove('hidden');
    list.innerHTML = '';
    
    if (!workPackages || workPackages.length === 0) {
        list.innerHTML = '<p class="text-neutral-600 dark:text-neutral-400">Nessun work package trovato</p>';
        return;
    }
    
    workPackages.forEach(wp => {
        const statusName = wp._links?.status?.title || 'N/A';
        const typeName = wp._links?.type?.title || 'N/A';
        const statusId = wp._links?.status?.href ? wp._links.status.href.split('/').pop() : null;
        
        const item = document.createElement('div');
        item.className = 'p-3 bg-neutral-100 dark:bg-neutral-700 rounded-lg';
        item.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="font-semibold text-neutral-900 dark:text-white">#${wp.id}: ${wp.subject || 'N/A'}</p>
                    <div class="flex gap-4 mt-1 text-sm">
                        <span class="text-neutral-600 dark:text-neutral-400">
                            <strong>Tipo:</strong> ${typeName}
                        </span>
                        <span class="text-neutral-600 dark:text-neutral-400">
                            <strong>Stato:</strong> ${statusName} ${statusId ? `(ID: ${statusId})` : ''}
                        </span>
                    </div>
                </div>
            </div>
        `;
        list.appendChild(item);
    });
}

const form = document.getElementById('create-wp-form');
if (form) {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const projectId = document.getElementById('wp-project-id').value.trim();
        const typeId = document.getElementById('wp-type-id').value.trim();
        const subject = document.getElementById('wp-subject').value.trim();
        const description = document.getElementById('wp-description').value.trim();
        
        // Validazione lato client
        if (!projectId || projectId === '') {
            showAlert('✗ Errore: Project ID è obbligatorio', 'error');
            return;
        }
        
        if (!typeId || typeId === '') {
            showAlert('✗ Errore: Type ID è obbligatorio', 'error');
            return;
        }
        
        if (!subject || subject === '') {
            showAlert('✗ Errore: Il titolo è obbligatorio', 'error');
            return;
        }
        
        const formData = {
            project_id: parseInt(projectId),
            type_id: parseInt(typeId),
            subject: subject,
            description: description,
        };
        
        console.log('Invio dati:', formData);
        showAlert('Creazione work package...', 'info');
        
        try {
            const response = await fetch('{{ route("admin.openproject.test.create") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            });
            
            const data = await response.json();
            console.log('Risposta:', data);
            
            if (data.success) {
                showAlert('✓ Work package creato con successo!', 'success');
                if (data.url) {
                    showAlert(`✓ Work package creato! <a href="${data.url}" target="_blank" class="underline">Visualizza</a>`, 'success');
                }
                showResults(data);
            } else {
                showAlert('✗ Errore: ' + data.message, 'error');
                showResults(data);
            }
        } catch (error) {
            console.error('Errore:', error);
            showAlert('✗ Errore: ' + error.message, 'error');
        }
    });
}
</script>
</x-layouts.app>

