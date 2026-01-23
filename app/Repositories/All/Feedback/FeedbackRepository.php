<?php

namespace App\Repositories\All\Feedback;

use App\Models\Feedback;
use App\Repositories\Base\BaseRepository;

class FeedbackRepository extends BaseRepository implements FeedbackInterface
{
    public function __construct(Feedback $model)
    {
        parent::__construct($model);
    }
}
