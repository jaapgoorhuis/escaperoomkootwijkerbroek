<?php

namespace App\Models;

// use Illuminate\Contracts\auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MenuItems extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'menu';

    protected $fillable = [
        'title',
        'page_id',
        'order_id',
        'parent_id',
        'is_dropdown_parent',
        'show_footer',
        'show_header',
        'show_menu',
    ];


    public function page(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->HasOne(Page::class, 'id', 'page_id');
    }
}
