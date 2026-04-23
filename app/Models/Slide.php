<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $fillable = [
        'vendor_id',
        'image',
        'title_ar',
        'title_en',
        'subtitle_ar',
        'subtitle_en',
        'description_ar',
        'description_en',
        'button_text_ar',
        'button_text_en',
        'link',
        'order',
        'active',
    ];

    public function getTitleAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getSubtitleAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->subtitle_ar : $this->subtitle_en;
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->description_ar : $this->description_en;
    }

    public function getButtonTextAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->button_text_ar : $this->button_text_en;
    }}
