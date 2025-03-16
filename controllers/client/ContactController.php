<?php
// controllers/client/ContactController.php

class ContactController {
    public function index() {
        // Load view contact.html
        include __DIR__ . '/../../views/client/layout/contact.php';
    }
}
?>