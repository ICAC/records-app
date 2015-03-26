<?php

namespace AppBundle\Services\Security;

use AppBundle\Entity\Person;
use AppBundle\Entity\Score;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class ScoreVoter implements VoterInterface
{
    const EDIT = 'EDIT';
    const DELETE = 'DELETE';

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::EDIT,
            self::DELETE,
        ));
    }

    public function supportsClass($class)
    {
        $supportedClass = 'AppBundle\Entity\Score';

        return $supportedClass === $class || is_subclass_of($class, $supportedClass);
    }

    public function vote(TokenInterface $token, $score, array $attributes)
    {
        if (!$this->supportsClass(get_class($score))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        /** @var Score $score */

        if (count($attributes) != 1) {
            throw new \InvalidArgumentException('Only one attribute is allowed');
        }

        $user = $token->getUser();
        if (!$user instanceof Person) {
            return VoterInterface::ACCESS_DENIED;
        }

        switch ($attributes[0]) {
            case self::EDIT:
                if (in_array('ROLE_ADMIN', $user->getRoles())) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                if ($score->getPerson()->getId() == $user->getId()) {
                    if (!$score->getDateAccepted()) {
                        return VoterInterface::ACCESS_GRANTED;
                    }
                }

                break;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}