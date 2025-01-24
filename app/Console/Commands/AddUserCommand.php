<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Console\Command;

class AddUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devit:user-add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Yangi User qo'shish uchun";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ismni so'rash
        $name = $this->askWithValidation('Ismni kiriting', function ($input) {
            return !empty($input) ? true : 'Ismni kiritishingiz kerak.';
        });

        // Emailni so'rash
        $email = $this->askWithValidation('Emailni kiriting', function ($input) {
            if (empty($input)) {
                return 'Emailni kiritishingiz kerak.';
            }
            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                return 'Email manzil noto\'g\'ri formatda.';
            }
            if (User::where('email', $input)->exists()) {
                return 'Ushbu email allaqachon mavjud.';
            }
            return true;
        });

        // Parolni so'rash
        $password = $this->askWithValidation('Parolni kiriting', function ($input) {
            if (empty($input)) {
                return 'Parolni kiritishingiz kerak.';
            }
            if (strlen($input) < 6) {
                return 'Parol kamida 6 ta belgidan iborat bo\'lishi kerak.';
            }
            return true;
        });

        // Parolni tasdiqlash
        $confirmPassword = $this->secret('Parolni qayta kiriting');
        if ($password !== $confirmPassword) {
            $this->error('Parollar mos kelmadi. Iltimos, qayta urinib ko\'ring.');
            return 1; // Xato kodi
        }

        // Foydalanuvchini yaratish
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Foydalanuvchi muvaffaqiyatli yaratildi!');

        return 0; // Muvaffaqiyat kodi
    }

    /**
     * Ask a question with validation and exit handling.
     *
     * @param string $question
     * @param callable $validationCallback
     * @return string
     */
    private function askWithValidation(string $question, callable $validationCallback): string
    {
        do {
            $input = $this->ask($question);

            // Agar foydalanuvchi "exit" deb yozsa, chiqishni so'rash
            if (strtolower($input) === 'exit') {
                if ($this->confirm('Chiqishni xohlaysizmi?')) {
                    $this->info('Komanda bekor qilindi.');
                    exit;
                }
            }

            $validation = $validationCallback($input);

            if ($validation !== true) {
                $this->error($validation);
            }
        } while ($validation !== true);

        return $input;
    }
}
