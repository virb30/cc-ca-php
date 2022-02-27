<?php declare(strict_types=1);

namespace App\Domain\Entity;

use App\Support\Arr;
use DomainException;

final class Cpf
{
    const FACTOR_DIGIT_1 = 10;
    const FACTOR_DIGIT_2 = 11;

    private string $value;

    public function __construct(string $value)
    {
        if(!$this->validate($value)) {
            throw new DomainException("Invalid CPF");
        }
        $this->value = $value;
    }

    private function validate(string $cpf): bool
    {
        $cpf = $this->cleanCpf($cpf);
        if(empty($cpf)) return false;
        if(!$this->isValidLength($cpf)) return false;
        if($this->hasAllDigitsEqual($cpf)) return false;
        $digit1 = $this->calculateVerifyingDigit($cpf, 10);
        $digit2 = $this->calculateVerifyingDigit($cpf, 11); 
        $calculatedDigits = $digit1.$digit2;  
        $verifyingDigits = $this->extractVerifyingDigits($cpf);
        return $verifyingDigits == $calculatedDigits;
    }

    private function cleanCpf(string $cpf): string
    {
        if(!is_string($cpf)) return '';
        return preg_replace('/\D/', '', $cpf);
    }

    private function isValidLength(string $cpf): bool
    {
        return strlen($cpf) === 11;
    }

    private function hasAllDigitsEqual(string $cpf): bool
    {
        $firstDigit = $cpf[0];
        return Arr::every(str_split($cpf), fn($digit): bool => $digit === $firstDigit);
    }
    
    private function calculateVerifyingDigit(string $digits, int $factor): int
    {   
        $total = 0;
        $digits = str_split($digits);
        foreach ($digits as $digit) {
            if ($factor > 1) $total += (int)$digit * $factor--;
        }
        $rest = $total % 11;
        return ($rest < 2) ? 0 : 11 - $rest;
    }
    
    private function extractVerifyingDigits(string $cpf): string
    {
        return substr($cpf, -2);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
