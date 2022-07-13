<?php declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Subscription;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use function in_array;

/**
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
class SubscriptionVoter extends Voter
{
    public const CREATE = 'ROLE_SUBSCRIPTION_CREATE';
    public const DELETE = 'ROLE_SUBSCRIPTION_DELETE';
    public const INDEX = 'ROLE_SUBSCRIPTION_INDEX';
    public const READ = 'ROLE_SUBSCRIPTION_READ';
    public const UPDATE = 'ROLE_SUBSCRIPTION_UPDATE';

    protected function supports(string $attribute, $subject): bool
    {
        return
            (self::INDEX === $attribute && null === $subject) ||
            (in_array($attribute, [self::CREATE, self::READ, self::UPDATE, self::DELETE], true) && $subject instanceof Subscription);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        // @todo

        return true;
    }
}
