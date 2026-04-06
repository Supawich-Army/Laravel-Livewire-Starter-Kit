<div class="p-4">
    {{-- button section --}}
    <div class="text-end mb-4">
        <flux:modal.trigger name="project-modal">
            <flux:button wire:click="$dispatch('open-project-modal', {mode: 'create'})" variant="primary" color="indigo"
                icon="plus-circle" class="cursor-pointer">Add Project
            </flux:button>
        </flux:modal.trigger>
    </div>

    {{-- Render form component --}}
    <livewire:projects.form-modal />

    {{-- Flash Message component --}}
    <div x-data="{ show: false, message: '', type: '' }" x-init="window.addEventListener('flash', e => {
        const data = e.detail;
        message = data.message;
        type = data.type;
        show = true;
        setTimeout(() => show = false, 4000);
    });" x-show="show" x-transition
        class="fixed top-4 right-4 px-4 py-2 rounded shadow-lg text-white z-50"
        :class="{
            'bg-emerald-600': type === 'success',
            'bg-red-600': type === 'error',
        }"
        style="display: none;">
        <span x-text="message"></span>
    </div>

    {{-- Table for listing --}}
    <div class="overflow-x auto border rounded-xl shadow-md bg-white dark:bg-zinc-900">
        <table class="min-w-full table-auto text-sm text-left">
            <thead
                class="bg-gray-50 dark:bg-zinc-800 text-gray-700 dark:text-zinc-300 uppercase text-xs font-semibold border-b">
                <tr>
                    <th class="p-4">#</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">Description</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Deadline</th>
                    <th class="px-13 py-4">Logo</th>
                    <th class="p-4 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($projects as $project)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800 transition border-b last:border-0">
                        <td class="p-4">
                            {{ ($projects->currentPage() - 1) * $projects->perPage() + $loop->iteration }}</td>
                        <td class="p-4 font-medium">{{ $project->name }}</td>
                        <td class="p-4 text-gray-600 dark:text-zinc-400">{{ $project->description }}</td>
                        <td class="p-4 capitalize">
                            @php
                                $statusColor = match ($project->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'in-progress' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'completed' => 'bg-green-100 text-green-800 border-green-200',
                                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                    default => 'bg-gray-100 text-gray-800 border-gray-200',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-medium border {{ $statusColor }}">
                                {{ str_replace('-', ' ', $project->status) }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-600 dark:text-zinc-400">{{ $project->deadline }}</td>
                        <td class="p-4">
                            @if ($project->project_logo)
                                <img src="{{ asset('storage/' . $project->project_logo) }}" alt="Project logo"
                                    class="h-10 w-16 object-cover rounded border" />
                            @else
                                <div
                                    class="h-10 w-16 bg-gray-100 dark:bg-zinc-800 rounded border flex items-center justify-center text-gray-400 text-[10px]">
                                    No Logo</div>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                <flux:modal.trigger name="project-modal">
                                    {{-- View --}}
                                    <flux:button
                                        wire:click="$dispatch('open-project-modal', {mode: 'view' , projectId: {{ $project->id }} })"
                                        variant="ghost" size="sm" icon="eye" class="cursor-pointer">
                                    </flux:button>

                                    {{-- Edit --}}
                                    <flux:button
                                        wire:click="$dispatch('open-project-modal', {mode: 'edit' , projectId: {{ $project->id }} })"
                                        variant="ghost" size="sm" icon="pencil"
                                        class="cursor-pointer text-blue-600">
                                    </flux:button>
                                </flux:modal.trigger>

                                {{-- Delete --}}
                                <flux:modal.trigger name="delete-project">
                                    <flux:button wire:click="$dispatch('delete-project', {id: {{ $project->id }}})"
                                        variant="ghost" size="sm" icon="trash"
                                        class="cursor-pointer text-red-600">
                                    </flux:button>
                                </flux:modal.trigger>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <flux:icon.exclamation-triangle class="mb-2 size-8 text-gray-300" />
                                <span>No projects found.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $projects->links() }}
    </div>

    {{-- Delete Project Modal --}}
    <flux:modal name="delete-project" class="min-w-[25rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete project?</flux:heading>
                <flux:text class="mt-2 text-zinc-500 dark:text-zinc-400">
                    You're about to delete this project.<br>
                    This action cannot be reversed.
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click='deleteProject' variant="danger">Delete project</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
