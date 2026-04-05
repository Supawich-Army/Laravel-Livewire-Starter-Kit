<?php

namespace App\Livewire\Projects;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\ProjectService;
use Livewire\WithoutUrlPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function getAllProjects(ProjectService $projectService)
    {
        return $projectService->getAllProjects()->orderBy('id', 'DESC')->paginate(10);
    }


    public function render(ProjectService $projectService)
    {
        $projects = $this->getAllProjects($projectService);

        return view('livewire.projects.index', compact('projects'));
    }
}
