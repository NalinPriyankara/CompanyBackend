<?php

namespace App\Repositories\All\Project;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProjectInterface
{
    public function all(): Collection;
    public function find(mixed $id): ?Model;
    public function create(array $data): Model;
    public function update(mixed $id, array $data): bool;
    public function delete(mixed $id): bool;
}
