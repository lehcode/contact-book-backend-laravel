<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository
{
    public function create(array $data)
    {
        $contact = Contact::create($data);

        if (isset($data['phones'])) {
            foreach ($data['phones'] as $phone) {
                $contact->phones()->create($phone);
            }
        }

        return $contact;
    }

    public function update(Contact $contact, array $data)
    {
        $contact->update($data);

        if (isset($data['phones'])) {
            $contact->phones()->delete();
            foreach ($data['phones'] as $phone) {
                $contact->phones()->create($phone);
            }
        }

        return $contact;
    }

    public function delete(Contact $contact)
    {
        return $contact->delete();
    }

    public function getAll()
    {
        return Contact::with('phones')->paginate(15);
    }
}
