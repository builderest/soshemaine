<?php

class ContactController
{
    private ContactModel $contacts;

    public function __construct()
    {
        $this->contacts = new ContactModel();
    }

    public function submit(): void
    {
        if (!is_post() || !Csrf::verify()) {
            flash('contact_error', 'Your session expired. Please try again.');
            redirect('contact.php');
        }
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');
        if (!$name || !$email || !$message) {
            flash('contact_error', 'Please fill in all fields.');
            redirect('contact.php');
        }
        $this->contacts->create([
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'status' => 'new',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        flash('contact_success', 'Thank you for contacting us!');
        redirect('contact.php');
    }
}

