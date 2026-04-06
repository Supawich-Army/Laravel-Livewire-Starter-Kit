{{-- Delete Project Modal --}}
<flux:modal name="{{ $modalName }}" class="min-w-[25rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="xs">{{ $heading }}</flux:heading>
            <flux:text class="mt-5">
                <p class="leading-loose">{!! $subheading !!}</p>
            </flux:text>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">
                    Cancel
                </flux:button>
            </flux:modal.close>

            <flux:button wire:click="delete" variant="danger">
                {{ $confirmButtonText }}
            </flux:button>
        </div>
    </div>
</flux:modal>
