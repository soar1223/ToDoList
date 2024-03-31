<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Task; // 名前空間を修正
use Illuminate\Validation\Rule;

class EditTask extends FormRequest
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
        // $rule = parent::rules(); // FormRequestにはデフォルトでrulesメソッドがないため、この行は削除します。

        $status_rule = Rule::in(array_keys(Task::STATUS));

        return [
            'status' => 'required|' . $status_rule,
        ];
    }

    public function attributes()
    {
        // $attributes = parent::attributes(); // ここも同様に、基底クラスから継承する属性がないため、修正します。
        return [
            'status' => '状態',
        ];
    }

    public function messages()
    {
        // $messages = parent::messages(); // 基底クラスからのメッセージがないので、この行も削除します。
        
        $status_labels = array_map(function($item) {
            return $item['label'];
        }, Task::STATUS);

        $status_labels = implode('、', $status_labels);

        return [
            'status.in' => ':attribute には ' . $status_labels. ' のいずれかを指定してください。',
        ];
    }
}
