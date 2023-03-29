<?php

namespace App\Validator\User;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;

/**
 * Combined requirements for password strength.
 */
#[\Attribute]
class PasswordRequirements extends Compound
{
    /**
     * @param array <mixed> $options
     *
     * @return Constraint []
     */
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\NotBlank(),
            new Assert\Type('string'),
            new Assert\Length([
                'min' => 8,
                'minMessage' => 'Heslo musí být minimálně {{ limit }} znaků dlouhé',
            ]),
            new Assert\Regex([
                'pattern' => '#[0-9]+#',
                'message' => 'Heslo musí obsahovatel alespoň jednu číslici',
            ]),
            new Assert\Regex([
                'pattern' => '#[A-Z]+#',
                'message' => 'Heslo musí obsahovatel alespoň jedno velké písmeno',
            ]),
            new Assert\Regex([
                'pattern' => '#[a-z]+#',
                'message' => 'Heslo musí obsahovatel alespoň jedno malé písmeno',
            ]),
        ];
    }
}