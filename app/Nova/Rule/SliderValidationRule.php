<?php

namespace App\Nova\Rule;

use App\Exceptions\SliderNova;
use Illuminate\Contracts\Validation\Rule;

class SliderValidationRule implements Rule
{
    /**
     * A list of the inputs
     *
     * @var string
     */
    protected $slider_name = '';

    /**
     * A list of the inputs
     *
     * @var integer
     */
    protected $slider_count = null;

    /**
     * Create a new rule instance.
     *
     * @param $name
     * @param $count
     */
    public function __construct($name,$count)
    {
        $this->slider_name = $name;
        $this->slider_count = $count;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws SliderNova
     */
    public function passes($attribute, $value)
    {
        if(count(explode(",", trim($value, '[]'))) <= $this->slider_count){
            return true;
        }else{

            throw new SliderNova("\"".$this->slider_name."\" блок не должен содержать более ".$this->slider_count." фоток",'0',null);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->slider_name." блок не должен содержать более ".$this->slider_count." фоток";
    }
}
