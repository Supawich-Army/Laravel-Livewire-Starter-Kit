<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div>
    <flux:modal name="project-modal" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">Create Project</flux:heading>
                <flux:text class="mt-2">Add a new project using the form below.</flux:text>
            </div>

            {{-- Project Name --}}
            <div class="form-group">
                <flux:input label="Project Name" placeholder="Enter project name" />
            </div>


            {{-- Description --}}
            <div class="form-group">
                <flux:textarea label="Description" placeholder="Short project description" rows="3" />
            </div>

            {{-- Deadline --}}
            <div class="form-group">
                <flux:input type="date" label="Deadline" />
            </div>

            {{-- Status --}}
            <div class="form-group">
                <flux:select wire:model="status" label="Status" placeholder="Select status">
                    <flux:select.option value="pending">Pending</flux:select.option>
                    <flux:select.option value="in-progress">In-Progress</flux:select.option>
                    <flux:select.option value="completed">Completed</flux:select.option>
                    <flux:select.option value="cancelled">Cancelled</flux:select.option>
                </flux:select>
            </div>

            {{-- Project Name --}}
            <div class="form-group">
                <flux:input type="file" class="cursor-pointer" label="Project Logo" accept="image/*"
                    placeholder="Enter project name" />
            </div>


            {{-- Buttons --}}
            <div class="flex justify-end pt-4">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary" color="indigo" class="cursor-pointer ms-2">
                    Save Project
                </flux:button>

            </div>
    </flux:modal>
</div>
