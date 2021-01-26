<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\BaseRepository;

class ContactRepository extends BaseRepository
{

    function __construct(Contact $contact = null)
    {
        parent::__construct($contact ?? new Contact());
    }

}
