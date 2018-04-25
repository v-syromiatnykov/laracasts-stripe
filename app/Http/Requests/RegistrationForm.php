<?php

namespace App\Http\Requests;

use App\Plan;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! ! $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stripeEmail' => 'required|email',
            'stripeToken' => 'required',
            'plan'        => 'required|in:1,2'
        ];
    }

    public function save()
    {
        $plan = Plan::findOrFail($this->plan);

        $this->user()->subscription()->create($plan, $this->stripeToken);

    }
}
