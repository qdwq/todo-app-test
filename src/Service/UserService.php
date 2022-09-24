<?php

/**
 * UserService.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserService.
 */
class UserService
{
    private UserRepository $userRepository;

    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * UserService constructor.
     *
     * @param UserRepository               $userRepository  UserRepository
     * @param UserPasswordEncoderInterface $passwordEncoder passwordEncoder
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Save.
     *
     * @param User        $user
     * @param string|null $plainPassword
     */
    public function save(User $user, ?string $plainPassword): void
    {
        if ($plainPassword) {
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $plainPassword
                )
            );
        }
        $this->userRepository->save($user);
    }
}
