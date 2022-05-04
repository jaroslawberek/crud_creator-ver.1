<?php
//<*<date_create>*>
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class <*<request>*> extends FormRequest {

    public $my_rules = [<*<request_rules>*>];
    public $messages = [<*<request_messages>*>];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
       
      return $this->my_rules;
        
    }

    public function messages() {
       
        return $this->messages;
        
    }

}
