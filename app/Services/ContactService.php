<?php

namespace App\Services;

use App\Repositories\ContactRepository;
use App\Models\Contact;

class ContactService
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function createContact(array $data)
    {
        return $this->contactRepository->create($data);
    }

    public function updateContact(Contact $contact, array $data)
    {
        return $this->contactRepository->update($contact, $data);
    }

    public function deleteContact(Contact $contact)
    {
        return $this->contactRepository->delete($contact);
    }

    public function getAllContacts()
    {
        return $this->contactRepository->getAll();
    }
}
