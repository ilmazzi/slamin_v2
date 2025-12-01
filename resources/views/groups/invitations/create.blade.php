<x-layouts.app>
<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-lg p-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">{{ __('groups.invite_user_to') }} {{ $group->name }}</h1>
                <a href="{{ route('groups.invitations.pending', $group) }}" 
                   class="text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    {{ __('groups.view_pending_invitations') }}
                </a>
            </div>
            
            <form action="{{ route('groups.invitations.store', $group) }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="user_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('groups.select_user') }}
                    </label>
                    <input type="text" id="user_search" placeholder="{{ __('groups.search_user') }}"
                           class="w-full px-4 py-2 rounded-xl bg-neutral-100 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 focus:ring-2 focus:ring-primary-500 text-neutral-900 dark:text-white mb-2">
                    <input type="hidden" name="user_id" id="user_id" required>
                    <div id="search_results" class="mt-2"></div>
                    @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 px-6 py-3 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700">
                        {{ __('groups.send_invitation') }}
                    </button>
                    <a href="{{ route('groups.show', $group) }}" class="flex-1 px-6 py-3 bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-xl font-semibold hover:bg-neutral-300 dark:hover:bg-neutral-600 text-center">
                        {{ __('groups.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('user_search').addEventListener('input', async function(e) {
    const search = e.target.value;
    if (search.length < 2) {
        document.getElementById('search_results').innerHTML = '';
        return;
    }
    
    const response = await fetch(`{{ route('groups.members.search', $group) }}?search=${search}`);
    const users = await response.json();
    
    let html = '<div class="space-y-2">';
    users.forEach(user => {
        html += `<div class="p-3 bg-neutral-50 dark:bg-neutral-800 rounded-lg cursor-pointer hover:bg-neutral-100 dark:hover:bg-neutral-700" onclick="selectUser(${user.id}, '${user.name}')">
            <strong>${user.name}</strong> (${user.nickname || user.email})
        </div>`;
    });
    html += '</div>';
    
    document.getElementById('search_results').innerHTML = html;
});

function selectUser(id, name) {
    document.getElementById('user_id').value = id;
    document.getElementById('user_search').value = name;
    document.getElementById('search_results').innerHTML = '';
}
</script>
</x-layouts.app>

