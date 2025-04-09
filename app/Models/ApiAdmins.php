<?php

namespace App\Models;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ApiAdmins extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'image',
        'phone',
        'email',
        'password',
        'is_admin'
    ];




    public static function getAdminNameById($id)
    {
        $admin = self::find($id);
        return $admin ? $admin->name : 'Noma’lum';
    }


    public function getFormattedCreatedAtAttribute(): string
    {
        return Carbon::parse($this->created_at)
            ->setTimezone('Asia/Tashkent')
            ->format('M d, Y H:i:s');
    }


    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }




}
