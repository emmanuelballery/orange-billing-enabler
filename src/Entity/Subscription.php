<?php declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Doctrine\Enum\TableEnum;
use App\Enum\PeriodicityEnum;
use App\Model\SubscriptionRow;
use App\Security\Voter\SubscriptionVoter;
use App\Validator\Cost;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use function count;

/**
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
#[ORM\Entity]
#[ORM\Table(TableEnum::SUBSCRIPTION)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    collectionOperations: [
        'get' => ['security' => 'is_granted("' . SubscriptionVoter::INDEX . '")'],
        'post' => ['security_post_denormalize' => 'is_granted("' . SubscriptionVoter::CREATE . '", object)'],
    ],
    itemOperations: [
        'get' => ['security' => 'is_granted("' . SubscriptionVoter::READ . '", object)'],
        'put' => ['security' => 'is_granted("' . SubscriptionVoter::UPDATE . '", object)'],
        'delete' => ['security' => 'is_granted("' . SubscriptionVoter::DELETE . '", object)'],
    ],
    denormalizationContext: ['groups' => [self::GROUP_WRITE], 'disable_type_enforcement' => true, 'swagger_definition_name' => 'Write'],
    normalizationContext: ['groups' => [self::GROUP_READ], 'swagger_definition_name' => 'Read'],
    order: ['created' => 'DESC']
)]
#[ApiFilter(SearchFilter::class, properties: ['subscriptionId' => 'partial', 'key' => 'partial', 'value' => 'partial', 'periodicity'])]
#[ApiFilter(NumericFilter::class, properties: ['cost'])]
#[ApiFilter(DateFilter::class, properties: ['created', 'updated', 'start', 'end'])]
class Subscription
{
    public const GROUP_READ = 'Subscription:Read';
    public const GROUP_WRITE = 'Subscription:Write';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups([self::GROUP_READ])]
    public ?Uuid $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([self::GROUP_READ])]
    public ?DateTime $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups([self::GROUP_READ])]
    public ?DateTime $updated = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\Length(max: 255)]
    #[Groups([self::GROUP_READ, self::GROUP_WRITE])]
    public ?string $subscriptionId = null;

    #[ORM\Column(name: 'subscription_key')]
    #[Assert\NotNull]
    #[Assert\Length(max: 255)]
    #[Groups([self::GROUP_READ, self::GROUP_WRITE])]
    public ?string $key = null;

    #[ORM\Column(name: 'subscription_value')]
    #[Assert\NotNull]
    #[Assert\Length(max: 255)]
    #[Groups([self::GROUP_READ, self::GROUP_WRITE])]
    public ?string $value = null;

    #[ORM\Column(name: 'subscription_cost', nullable: true)]
    #[Assert\GreaterThan(.0)]
    #[Cost]
    #[ApiProperty(description: 'Either fill the cost or add rows.')]
    #[Groups([self::GROUP_READ, self::GROUP_WRITE])]
    public ?float $cost = null;

    #[ORM\Column(name: 'subscription_start', type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    #[Groups([self::GROUP_READ, self::GROUP_WRITE])]
    public ?DateTime $start = null;

    #[ORM\Column(name: 'subscription_end', type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\GreaterThan(propertyPath: 'start')]
    #[Groups([self::GROUP_READ, self::GROUP_WRITE])]
    public ?DateTime $end = null;

    #[ORM\Column(name: 'subscription_periodicity')]
    #[Assert\NotNull]
    #[Assert\Choice(choices: PeriodicityEnum::ALL)]
    #[ApiProperty(openapiContext: ['enum' => PeriodicityEnum::ALL])]
    #[Groups([self::GROUP_READ, self::GROUP_WRITE])]
    public ?string $periodicity = null;

    /** @var array<SubscriptionRow> */
    #[ORM\Column(name: 'subscription_rows', type: 'json_document')]
    #[Assert\Valid]
    #[Groups([self::GROUP_READ, self::GROUP_WRITE])]
    public array $rows = [];

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

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->created = new DateTime();
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updated = new DateTime();
    }
}
