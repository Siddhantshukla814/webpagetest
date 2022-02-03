<?php

declare(strict_types=1);

namespace WebPageTest;

class ValidatorPatterns
{
    public static string $contact_info = '^([^<>&]|&([^#]|$))+$';
    public static string $password = '';
}
