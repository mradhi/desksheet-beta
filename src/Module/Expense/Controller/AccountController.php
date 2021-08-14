<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\Expense\Controller;

use Desksheet\Module\Expense\Form\AccountType;
use Desksheet\Module\Expense\Model\Account;
use Desksheet\Module\Expense\Model\Transaction;
use Desksheet\Module\Expense\Request\TransactionRequest;
use Desksheet\Module\Expense\Service\AccountService;
use Desksheet\Module\Expense\Voter\AccountVoter;
use Desksheet\System\Controller\AbstractController;
use Desksheet\System\DataTransfer\DataTransferHandlerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/expense/accounts')]
class AccountController extends AbstractController
{
    public function __construct(private AccountService $accountService)
    {
    }

    #[Route('/', name: 'expense_account_index')]
    public function index(DataTransferHandlerInterface $handler): Response
    {
        $foo = new TransactionRequest();
        $handler->transfer(new Transaction(), $foo);

        return $this->render('expense/account/index.html.twig', [
            'accounts' => $this->accountService->findByUser($this->getUser())
        ]);
    }

    #[Route('/create', name: 'expense_account_create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(AccountType::class, $account = $this->accountService->newAccount($this->getUser()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->accountService->update($account);

            return $this->redirectToRoute('expense_account_index');
        }

        return $this->render('expense/account/create_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{account}/edit', name: 'expense_account_edit')]
    #[IsGranted(AccountVoter::EDIT, 'account')]
    public function edit(Account $account, Request $request): Response
    {
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->accountService->update($account);

            return $this->redirectToRoute('expense_account_index');
        }

        return $this->render('expense/account/create_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{account}/delete', name: 'expense_account_delete', methods: ['POST'])]
    #[IsGranted(AccountVoter::DELETE, 'account')]
    public function delete(Account $account, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete_account', $request->request->get('_csrf_token'))) {
            $this->accountService->remove($account);
        }

        return $this->redirectToRoute('expense_account_index');
    }
}
