<?php declare(strict_types=1);

namespace App;

use App\Helpers\Arr;
use DomainException;

final class Cpf
{
    private string $cpf;

    public function __construct(string $cpf)
    {
        if(!$this->validate($cpf)) {
            throw new DomainException("Invalid CPF");
        }

        $this->cpf = $cpf;
    }

    private function calculateVerifyingDigit(string $digits): int
    {   
        $multiplier = strlen($digits) + 1;
        $digitsArray = str_split($digits);
        $digitsMultiplied = array_map(
            fn($digit, $key): int => ($multiplier - $key) * (int)$digit, 
            $digitsArray, 
            array_keys($digitsArray)
        );
        $sum = array_reduce($digitsMultiplied, fn($acc, $digit) => $acc + $digit, 0);
        $rest = $sum % 11;
        return ($rest < 2) ? 0 : 11 - $rest;
    }
    
    private function normalize(string $cpf): string
    {
        if(!is_string($cpf)) return '';
        return preg_replace('/\D/', '', $cpf);
    }
    
    private function validate(string $cpf): bool
    {
        $cpf = $this->normalize($cpf);
        if(empty($cpf)) return false;
        if(strlen($cpf) !== 11) return false;
        
        $allDigitsEqual = Arr::every(str_split($cpf), fn($value): bool => $value === $cpf[0]);
        if($allDigitsEqual) return false;
    
        $firstVerifyingDigit = 0;
        $secondVerifyingDigit = 0;  
        list($firstNineDigits, $verifyingDigits) = str_split($cpf, 9);
        $firstVerifyingDigit = $this->calculateVerifyingDigit($firstNineDigits);
        $firstTenDigits = $firstNineDigits.$firstVerifyingDigit;
        $secondVerifyingDigit = $this->calculateVerifyingDigit($firstTenDigits); 
        $calculatedDigits = $firstVerifyingDigit.$secondVerifyingDigit;  
        return $verifyingDigits == $calculatedDigits;
    }

    public function getCpf()
    {
        return $this->cpf;
    }
}
