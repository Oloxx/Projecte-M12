<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'cognoms' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
    // This will be removed when we add i18n (translations)
    public function messages()
    {
        return [
            'name.max' => 'El camp de nom no ha de tenir més de 255 caràcters.',
            'cognoms.max' => 'El camp de cognoms no ha de tenir més de 255 caràcters.',
            'email.max' => 'El camp de correu electrònic no ha de tenir més de 255 caràcters.',
            'name.string' => 'El camp de nom ha de ser de tipus string.',
            'cognoms.string' => 'El camp de cognoms ha de ser de tipus string.',
            'email.email' => 'El camp de correu electrònic ha de ser una adreça electrònica vàlida.'
        ];
    }
}
