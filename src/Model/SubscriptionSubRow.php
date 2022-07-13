<?php declare(strict_types=1);

namespace App\Model;

use App\Entity\Subscription;
use App\Validator\Cost;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
class SubscriptionSubRow
{
    #[Assert\NotNull]
    #[Length(max: 255)]
    #[Groups([Subscription::GROUP_READ, Subscription::GROUP_WRITE])]
    public ?string $key = null;

    #[Assert\NotNull]
    #[Length(max: 255)]
    #[Groups([Subscription::GROUP_READ, Subscription::GROUP_WRITE])]
    public ?string $value = null;

    #[Assert\NotNull]
    #[Length(max: 255)]
    #[Groups([Subscription::GROUP_READ, Subscription::GROUP_WRITE])]
    public ?string $unit = null;

    #[Assert\NotNull]
    #[Assert\GreaterThan(.0)]
    #[Cost]
    #[Groups([Subscription::GROUP_READ, Subscription::GROUP_WRITE])]
    public ?float $cost = null;
}
