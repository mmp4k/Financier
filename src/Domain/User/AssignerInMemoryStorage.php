<?php

namespace Domain\User;

use Ramsey\Uuid\UuidInterface;

class AssignerInMemoryStorage implements AssignerStorage, FinderStorage
{
    /**
     * @var UserResource[]
     */
    protected $data = [];

    public function assign(UserResource $resource)
    {
        $this->data[] = $resource;
    }

    /**
     * @param string $type
     *
     * @return array|UuidInterface[]
     */
    public function findByType(string $type): array
    {
        $found = [];
        foreach ($this->data as $userResource) {
            if ($userResource->resourceType() !== $type) {
                continue;
            }

            $found[] = $userResource->id();
        }

        return $found;
    }

    /**
     * @param string $type
     * @param User $user
     *
     * @return array|UuidInterface[]
     */
    public function findByTypeAndUser(string $type, User $user): array
    {
        $found = [];
        foreach ($this->data as $userResource) {
            if ($userResource->resourceType() !== $type) {
                continue;
            }

            if (!$userResource->user()->id()->equals($user->id())) {
                continue;
            }

            $found[] = $userResource->id();
        }

        return $found;
    }

    public function findByTypeAndResource(string $type, UuidInterface $idResource): ?User
    {
        foreach ($this->data as $userResource) {
            if ($userResource->resourceType() !== $type) {
                continue;
            }

            if (!$userResource->id()->equals($idResource)) {
                continue;
            }

            return $userResource->user();
        }

        return null;
    }
}