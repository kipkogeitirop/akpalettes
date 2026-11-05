<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() instanceof User && $this->user()->is_admin;
    }

    public function rules(): array
    {
        return [
            'home_intro_heading' => ['required', 'string', 'max:500'],
            'home_intro_copy' => ['required', 'string', 'max:1000'],
            'home_story_first' => ['required', 'string', 'max:1000'],
            'home_story_second' => ['required', 'string', 'max:1000'],
            'about_biography' => ['required', 'string', 'max:2000'],
            'about_influences' => ['required', 'string', 'max:2000'],
            'about_colour' => ['required', 'string', 'max:1000'],
            'contact_email' => ['required', 'email', 'max:255'],
            'whatsapp_number' => ['nullable', 'string', 'regex:/^[+0-9\s().-]{0,30}$/'],
            'instagram_handle' => ['nullable', 'string', 'max:30', 'regex:/^@?[A-Za-z0-9._]+$/'],
            'testimonial_quote' => ['nullable', 'string', 'max:600'],
            'testimonial_author' => ['nullable', 'required_with:testimonial_quote', 'string', 'max:120'],
            'testimonial_detail' => ['nullable', 'string', 'max:120'],
            'exhibitions' => ['nullable', 'string', 'max:3000'],
        ];
    }
}
