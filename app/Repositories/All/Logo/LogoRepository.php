<?php

namespace App\Repositories\All\Logo;

use App\Models\Logo;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class LogoRepository extends BaseRepository implements LogoInterface
{
    public function __construct(Logo $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): Logo
    {
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $data['logo'] = $data['logo']->store('logos', 'public');
        }

        return parent::create($data);
    }

    public function update(mixed $id, array $data): bool
    {
        $record = $this->find($id);
        if (! $record) return false;

        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            if ($record->logo) {
                Storage::disk('public')->delete($record->logo);
            }
            $data['logo'] = $data['logo']->store('logos', 'public');
        }

        return $record->update($data);
    }
}
