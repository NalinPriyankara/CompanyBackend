<?php

namespace App\Repositories\All\Project;

use App\Models\Project;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProjectRepository extends BaseRepository implements ProjectInterface
{
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): Project
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('projects', 'public');
        }

        return parent::create($data);
    }

    public function update(mixed $id, array $data): bool
    {
        $project = $this->find($id);
        if (! $project) return false;

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $data['image'] = $data['image']->store('projects', 'public');
        }

        return $project->update($data);
    }
}
