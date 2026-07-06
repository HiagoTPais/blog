<x-mail::message>
# Nova mensagem de contato

**Nome:** {{ $contact->name }}

**Email:** {{ $contact->email }}

**Assunto:** {{ $contact->subject }}

---

{{ $contact->message }}

</x-mail::message>
