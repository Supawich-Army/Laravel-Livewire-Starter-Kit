<?php

namespace App\Livewire\Projects;

use Flux\Flux;
use App\Services\ProjectService;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class FormModal extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:100')]
    public $name = null;

    #[Validate('required|string|max:255')]
    public $description = null;

    #[Validate('required|date|after_or_equal:today')]
    public $deadline = null;

    #[Validate('required|in:pending,in_progress,completed,cancelled')]
    public $status = 'pending';

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:5120')]
    public $project_logo = null;

    /**
     * Function: saveProject
     */
    public function saveProject(ProjectService $projectService)
    {

        // $this->authorize('create', Project::class);

        # Validating form here
        $validatedProjectRequest = $this->validate();

        $projectService->saveProject($validatedProjectRequest);

        $this->reset(['name', 'description', 'deadline', 'project_logo']);
        $this->status = 'pending';

        $this->dispatch(
            'flash',
            message: 'Project created successfully.',
            type: 'success',
        );

        Flux::modal('project-modal')->close();
    }

    #[On('open-project-modal')]
    public function projectDetail()
    {
        dd('hello');
    }

    public function render()
    {
        return view('livewire.projects.form-modal');
    }
}
