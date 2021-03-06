<?php
namespace BrZend\Validator;

use Zend\Validator\AbstractValidator;
/**
 *
 * @author igor
 *        
 */
class CPF extends AbstractValidator
{
    const LENGTH = 'length';
    const CPF  = 'CPF';
    
    protected $messageTemplates = array(
        self::CPF => "'%value%' não é CPF válido", 
        self::LENGTH => "'%value%' precisa ter o tamanho de 11 caracteres sem ponto ou traço", 
    );

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\Validator\ValidatorInterface::isValid()
     *
     */
    public function isValid($value)
    { 
        $isValid = false;
        $numbers = preg_replace("/[^0-9]/", "", $value);
        $final = explode('-',$value);
        $dig1 = $this->getDigitOne($numbers);
        $dig2 = $this->getDigitTwo($numbers);
        $digits = $dig1 . $dig2;
        if ($digits == $final[1]) {
            $isValid = true;
        }
        else {
            $this->error(self::CPF);
        }
        return $isValid;
    }

    protected function getDigitOne($value)
    {
        $total = 0;
        $vef1 = array(
            10,
            9,
            8,
            7,
            6,
            5,
            4,
            3,
            2
        );
        $count = count($vef1);
       
        for ($i = 0; $i < $count; $i ++) {
            $total += $vef1[$i] * $value[$i];
        }
        $vef1 = (($total % 11) < 2) ? 0 : (int) (11 - ($total % 11));
        return $vef1;
    }

    protected function getDigitTwo($value)
    {
        $total = 0;
        $vef2 = array(
            11,
            10,
            9,
            8,
            7,
            6,
            5,
            4,
            3,
            2
        );
        $count = count($vef2);
        $total = 0;
        for ($i = 0; $i < $count; $i ++) {
            $total += $vef2[$i] * $value[$i];
        }
        $vef2 = (($total % 11) < 2) ? 0 : (int) (11 - ($total % 11));
        
        return $vef2;
    }
}
