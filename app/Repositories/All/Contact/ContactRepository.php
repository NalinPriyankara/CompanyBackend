<?php

namespace App\Repositories\All\Contact;

use App\Models\Contact;
use App\Repositories\Base\BaseRepository;

class ContactRepository extends BaseRepository implements ContactInterface
{
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }
}
