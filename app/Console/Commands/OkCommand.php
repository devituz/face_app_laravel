<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class OkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devit:ok';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Migratsiyalarni, urug'larni ekish vositalarini ishga tushiring va interaktiv tarzda standart administrator foydalanuvchisini yarating";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->confirm('Migratsiya qilishni xohlaysizmi?')) {
            $this->info('Migratsiya boshlandi...');
            Artisan::call('migrate');
            $this->info('Migratsiya tugadi.');
        }


        if ($this->confirm('Seederlarni ishlatishni xohlaysizmi?')) {
            $this->info('Seederlar ishlatilmoqda...');
            Artisan::call('db:seed');
            $this->info('Seederlar tugadi.');
        }


        if ($this->confirm('Jobs uchun ishlov berishni xohlaysizmi?')) {
            $this->info('Jobs uchun ishlov berish boshlandi...');
            Artisan::call('queue:work');
            $this->info('Jobs ishlov berildi.');
        }


        if ($this->confirm('Default admin malumotlarini kiritishni xohlaysizmi?')) {
            $this->info('Admin yaratilyapti...');
            $this->createAdmin();
            $this->info('Admin malumotlari kiritildi.');
        }
    }

    /**
     * Create default admin user.
     */
    protected function createAdmin()
    {
        // Admin ismini so'rash
        $name = $this->askWithValidation('Adminning ismini kiriting', function ($input) {
            return !empty($input) ? true : 'Ismni kiritishingiz kerak.';
        });

        // Admin emailini so'rash
        $email = $this->askWithValidation('Adminning emailini kiriting', function ($input) {
            if (empty($input)) {
                return 'Emailni kiritishingiz kerak.';
            }
            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                return 'Email manzil noto\'g\'ri formatda.';
            }
            return true;
        });

        // Admin parolini so'rash
        $password = $this->secret('Admin parolini kiriting');
        $confirmPassword = $this->secret('Admin parolini qayta kiriting');

        // Parollarni taqqoslash
        if ($password !== $confirmPassword) {
            $this->error('Parollar mos kelmadi. Iltimos, qayta urinib ko\'ring.');
            return;
        }

        \App\Models\User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Default admin yaratilgan.');
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
