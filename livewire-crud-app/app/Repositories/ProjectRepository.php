<?php

namespace App\Repositories;

class ProjectRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function saveProject($projectRequest)
    {
        return Project::create($projectRequest);
    }
}
