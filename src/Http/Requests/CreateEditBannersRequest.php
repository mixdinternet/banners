<?php
namespace Mixdinternet\Banners\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEditBannersRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required'
            , 'star' => 'required|integer'
            , 'name' => 'required|max:150'
            , 'published_at' => 'required|date_format:d/m/Y H:i'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}