<?php

namespace App\Services;

use Illuminate\Support\Facades\Schema;

class TranslationService
{
    private $class;
    public array $fields;

    public function __construct($class)
    {
        $this->class = new $class();

        $this->getAllFields();

        $this->translatableFields();
    }

    private function getAllFields()
    {
        $this->fields = Schema::getColumnListing($this->class->getTable());
    }

    private function translatableFields()
    {
        $translatable = $this->class->getTranslatableAttributes();

        foreach ($this->fields as &$field) {
            if (in_array($field, $translatable)) {
                $field = $field . '->' . app()->getLocale() . ' as ' . $field;
            }
        }
    }
}
