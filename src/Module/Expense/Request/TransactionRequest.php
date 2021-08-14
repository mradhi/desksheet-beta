<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\Expense\Request;

use DateTimeInterface;
use Desksheet\Module\Expense\Enum\TransactionTypeEnum;
use Desksheet\Module\Expense\Model\AccountInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Currency;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class TransactionRequest
{
    #[NotBlank]
    public ?AccountInterface $account = null;

    #[NotBlank]
    #[Choice([TransactionTypeEnum::CREDIT, TransactionTypeEnum::DEBIT])]
    public ?int $type = null;

    #[NotBlank]
    #[Currency]
    public ?string $currency = null;

    #[NotBlank]
    #[Positive]
    public ?float $amount = null;

    #[DateTime]
    public ?DateTimeInterface $effectiveDate = null;

    public ?string $description = null;

    public function __construct(?AccountInterface $account = null)
    {
        // Set default effective date to now.
        $this->effectiveDate = new \DateTime();

        if (null !== $account) {
            // Set default currency to the default account currency.
            $this->currency = $account->getCurrency();
        }

        $this->account = $account;
    }
}
