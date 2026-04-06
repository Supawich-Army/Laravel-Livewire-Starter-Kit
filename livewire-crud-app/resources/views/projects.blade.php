<x-layouts::app :title="__('Projects')">
    <div class="relative mb-6 w-full p-4">
        <flux:heading size="xl" level="1">{{ __('Project Management') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Create and manage your project.') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- เรียกใช้ Livewire Component ที่เราเตรียมไว้ --}}
    <livewire:projects.index />

</x-layouts::app>
