<?php declare(strict_types=1);

namespace App\Model;

use ApiPlatform\Core\Annotation\ApiProperty;
use App\Entity\Subscription;
use App\Validator\Cost;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use function count;

/**
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
class SubscriptionRow
{
    #[Assert\NotNull]
    #[Length(max: 255)]
    #[Groups([Subscription::GROUP_READ, Subscription::GROUP_WRITE])]
    public ?string $key = null;

    #[Assert\NotNull]
    #[Length(max: 255)]
    #[Groups([Subscription::GROUP_READ, Subscription::GROUP_WRITE])]
    public ?string $value = null;

    #[Assert\GreaterThan(.0)]
    #[Cost]
    #[ApiProperty(description: 'Either fill the cost or add rows.')]
    #[Groups([Subscription::GROUP_READ, Subscription::GROUP_WRITE])]
    public ?float $cost = null;

    /** @var array<SubscriptionSubRow> */
    #[Assert\Valid]
    #[Groups([Subscription::GROUP_READ, Subscription::GROUP_WRITE])]
    public ?array $rows = [];

    #[Assert\Callback]
    public function assertIsValid(ExecutionContextInterface $context): void
    {
        if (
            (null === $this->cost && 0 === count($this->rows)) ||
            (null !== $this->cost && 0 !== count($this->rows))
        ) {
            $context
                ->buildViolation('Either fill the cost or add rows.')
                ->atPath('cost')
                ->setCode('@todo')
                ->addViolation();
        }
    }
}
