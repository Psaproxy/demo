<?php /** @noinspection PhpMissingFieldTypeInspection */

declare(strict_types=1);

namespace App\Console\Commands\App;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;

class AddUser extends Command
{
    use AuthorizesRequests, ValidatesRequests;

    private const ARG_IS_EMAIL_VERIFIED = 'is_email_verified';
    private const ARG_SILENT = 'silent';
    private const ERROR_CODE_INVALID_EMAIL = 1;

    /**
     * @var string
     */
    protected $signature = 'user:add 
                            {--' . User::COLUMN_NAME . '= : Имя} 
                            {--' . User::COLUMN_EMAIL . '= : Email} 
                            {--' . self::ARG_IS_EMAIL_VERIFIED . '= : Авто подтверждение email} 
                            {--' . User::COLUMN_PASSWORD . '= : Пароль}
                            {--' . self::ARG_SILENT . '= : Авто подтверждение}';

    /**
     * @var string
     */
    protected $description = 'Добавление пользователя';

    public function handle(): int
    {
        while (true) {
            $arguments = $this->requestArguments();

            if (true === $this->isSilentMode()) {
                $isConfirmedArgs = true;
            } else {
                $isConfirmedArgs = $this->confirm(
                    sprintf('Добавить пользователя "%s" с email "%s"?', $arguments->name, $arguments->email),
                    true
                );
            }

            if (true === $isConfirmedArgs) {
                break;
            }
        }

        User::forceCreate([
            User::COLUMN_NAME => $arguments->name,
            User::COLUMN_EMAIL => $arguments->email,
            User::COLUMN_EMAIL_VERIFIED_AT => true === $arguments->isEmailVerified ? now() : null,
            User::COLUMN_PASSWORD => Hash::make($arguments->password),
        ]);

        $this->info(
            sprintf('Пользователь "%s" с email "%s" успешно добавлен.', $arguments->name, $arguments->email)
        );

        return 0;
    }

    private function requestArguments(): AddUserDTO
    {
        $name = $this->option(User::COLUMN_NAME);
        if (null === $name) {
            $name = (string)$this->ask('Имя');
        }

        $email = $this->option(User::COLUMN_EMAIL);
        if (null === $email) {
            $email = $this->askEmail('Email');
        } else {
            if (false === $this->assertionIsValidEmail($email)) {
                exit(self::ERROR_CODE_INVALID_EMAIL);
            }
        }

        $isEmailVerified = $this->option(self::ARG_IS_EMAIL_VERIFIED);
        if (null === $isEmailVerified) {
            $isEmailVerified = $this->confirm('Авто подтверждение email', true);
        } else {
            $isEmailVerified = (bool)$isEmailVerified;
        }

        $password = $this->option(User::COLUMN_PASSWORD);
        if (null === $password) {
            $password = (string)$this->secret('Пароль');
        }

        return new AddUserDTO($name, $email, $isEmailVerified, $password);
    }

    private function askEmail(string $message): string
    {
        while (true) {
            $email = (string)$this->ask($message);
            $email = strtolower($email);

            if (false === $this->assertionIsValidEmail($email)) {
                continue;
            }

            return $email;
        }
    }

    private function assertionIsValidEmail(string $email): bool
    {
        if (false === $this->isValidEmail($email)) {
            $this->error(sprintf('Email должен быть валидным, "%s" невалидный email.', $email));
            return false;
        }

        if (false === $this->isUniqueEmail($email)) {
            $this->error(sprintf('Email должен быть уникальным, "%s" уже есть в системе.', $email));
            return false;
        }

        return true;
    }

    private function isValidEmail(string $email): bool
    {
        return false !== filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function isUniqueEmail(string $email): bool
    {
        $existingUserWithSameEmail = User::whereEmail($email)->first();

        return null === $existingUserWithSameEmail;
    }

    private function isSilentMode(): bool
    {
        return (bool)$this->option(self::ARG_SILENT);
    }
}
