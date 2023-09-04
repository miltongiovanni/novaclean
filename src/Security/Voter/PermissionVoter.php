<?php

namespace App\Security\Voter;

use App\Repository\PermissionRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PermissionVoter implements VoterInterface
{
    private PermissionRepository $permissionRepository;
    // this vote() method is the only required method of VoterInterface
    // it should return ACCESS_ABSTAIN (i.e. not supported),
    // ACCESS_GRANTED or ACCESS_DENIED.
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function vote(TokenInterface $token, $subject, array $attributes): int
    {
        $attribute = $attributes[0];
        $user = $token->getUser();
        // find all stored permissions for this attribute and subject
        $permissions = $this->permissionRepository->findBy([
            'atributo' => $attribute,
            'modulo' => $subject,
            'activo' => 1
        ]);

        // do not deny/grant if there is no permission for this
        // attribute and subject
        if (0 === count($permissions)) {
            return self::ACCESS_ABSTAIN;
        }
        foreach ($permissions as $permission) {
            if (!in_array($permission->getPerfil()->getCode(), $user->getRoles())) {
                continue;
            }
            return self::ACCESS_GRANTED;
        }

        // in any other case, deny access
        return self::ACCESS_DENIED;
    }
}
