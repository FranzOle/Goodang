<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'sidebar_theme',       
        'overall_theme',       
        'font',                
        'terms_and_conditions',
        'terms_file',          
        'admin_phone',        
        'company_logo',       
    ];

    public static function availableThemes(): array
    {
        return ['primary', 'success', 'info', 'warning', 'danger'];
    }

    public static function defaultSettings(): array
    {
        return [
            'sidebar_theme' => 'primary',
            'overall_theme' => 'primary',
            'font' => 'default',
            'terms_and_conditions' => null,
            'terms_file' => null,
            'admin_phone' => null,
            'company_logo' => null,
        ];
    }
}
