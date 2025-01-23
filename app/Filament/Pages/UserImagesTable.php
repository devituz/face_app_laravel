<?php


namespace App\Filament\Pages;

use App\Models\ApiAdmins;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Http;

class UserImagesTable extends Page
{
    public $admins = []; // Adminlar ro'yxati

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static string $view = 'filament.pages.user-images-page';
    protected static ?string $navigationLabel = 'Delete';
    protected static ?string $label = 'Delete';



    public function mount()
    {
        // Barcha adminlarni olish
        $this->admins = ApiAdmins::all();  // Barcha adminlarni olish

    }

}
