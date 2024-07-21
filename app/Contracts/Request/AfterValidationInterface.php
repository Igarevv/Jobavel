<?php

namespace App\Contracts\Request;

interface AfterValidationInterface
{
    /**
     * Process data after validation.
     *
     * Implement the necessary logic to transform or mutate the data as needed.
     * The keys in `$data` will be those available after validation,
     * but they must be same as you define in 'rules' method
     *
     * @param  array  $data  The data array with keys validated.
     *
     * @return void
     */
    public function makeCastAndMutatorsAfterValidation(array &$data): void;
}