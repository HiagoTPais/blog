<?php

namespace App\Services;

use App\Mail\ContactMessageMail;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactService
{
    public function send(array $data): Contact
    {
        $contact = Contact::create($data);

        Mail::to(config('blog.author_email'))
            ->send(new ContactMessageMail($contact));

        return $contact;
    }
}
