<?php

namespace App\Traits;

use Illuminate\Validation\Validator;

trait AfterValidation
{

    protected function getValidatorInstance(): \Illuminate\Contracts\Validation\Validator
    {
        return parent::getValidatorInstance()->after(function (Validator $validator) {
            $this->processAfterValidation($validator);
        });
    }

    protected function processAfterValidation(Validator $validator): void
    {
        $data = $validator->getData();

        if (method_exists($this, 'makeCastAndMutatorsAfterValidation')) {
            $this->makeCastAndMutatorsAfterValidation($data);
        }

        $validator->setData($data);
    }
}