<?php

interface MailerServiceInterface
{
    static function sendConfirmationEmail(User $user): void;
}
