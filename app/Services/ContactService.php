<?php

namespace App\Services;

use App\Repositories\ContactRepository;
use App\Models\Contact;
use Faker\Factory;

class ContactService
{
    protected $contactRepository;
    protected $faker;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
        if (env('MOCK_DATA') === 'yes') {
            $this->faker = Factory::create();
        }
    }

    public function createContact(array $data)
    {
        if (env('MOCK_DATA') === 'yes') {
            $contact = new Contact([
                "first_name" => $this->faker->first_name,
                "last_name" => $this->faker->last_name,
                "phones" => []
            ]);

            print_r($contact);

            return $contact;
        } else {
            return $this->contactRepository->create($data);
        }
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
        if (env('MOCK_DATA') === 'yes') {
            $contacts = [];
            for ($i = 0; $i < 10; $i++) {
                $contact = new Contact([
                    "first_name" => $this->faker->firstName,
                    "last_name" => $this->faker->lastName,
                    "phones" => []
                ]);
                $contacts[] = $contact;
            }
            return $contacts;
        }

        return $this->contactRepository->getAll();
    }
}
