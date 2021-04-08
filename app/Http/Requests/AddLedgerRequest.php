<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLedgerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'type' => 'required|in:income,expense,adjustment',
            'id' => 'required|integer',
            'amount' => 'required|numeric',
            'description' => 'required',
            'ledger_category_id' => 'required|exists:App\LedgerCategory,id',
            'date' => 'required|date'
        ];
        return $rules;
    }
}
