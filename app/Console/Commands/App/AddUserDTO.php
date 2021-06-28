<?php /** @noinspection PhpMissingFieldTypeInspection */

declare(strict_types=1);

namespace App\Console\Commands\App;

class AddUserDTO
{
    public string $name;
    public string $email;
    public bool $isEmailVerified;
    public string $password;

    public function __construct(string $name, string $email, bool $isEmailVerified, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->isEmailVerified = $isEmailVerified;
        $this->password = $password;
    }
}
