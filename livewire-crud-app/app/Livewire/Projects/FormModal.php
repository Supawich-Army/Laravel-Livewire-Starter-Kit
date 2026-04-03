<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormModal extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $deadline;
    public $status = 'pending';
    public $project_logo;

    public function saveProject()
    {
        $validated = $this->validate([
            'name' => 'required|string|min:3|max:100',
            'description' => 'required|string|max:255',
            'deadline' => 'required|date',
            'status' => 'required|in:pending,in-progress,completed,cancelled',
            'project_logo' => 'nullable|image|max:5120',
        ]);

        if ($this->project_logo) {
            $validated['project_logo'] = $this->project_logo->store('project-logos', 'public');
        }

        Project::create($validated);

        // Reset the form fields
        $this->reset(['name', 'description', 'deadline', 'status', 'project_logo']);

        // Dispatch an event to refresh the project list (if you have one)
        $this->dispatch('project-created');

        // Close the modal using Flux's JavaScript API
        $this->js("Flux.modal('project-modal').close()");
    }

    public function render()
    {
        return view('livewire.projects.form-modal');
    }
}
