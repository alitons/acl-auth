<?php

namespace Acl\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Acl\Auth\Http\Services\AutenticacaoService;

class AutenticacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    /**
     * Manipulate the request before validation.
     */
    public function passedValidation()
    {
        if($this->has('callback')) {
            AutenticacaoService::getData($this->callback);
        }
    }
}
