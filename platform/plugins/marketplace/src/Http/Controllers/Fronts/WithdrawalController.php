<?php

namespace Botble\Marketplace\Http\Controllers\Fronts;

use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Marketplace\Enums\WithdrawalStatusEnum;
use Botble\Marketplace\Events\WithdrawalRequested;
use Botble\Marketplace\Forms\VendorWithdrawalForm;
use Botble\Marketplace\Http\Requests\VendorEditWithdrawalRequest;
use Botble\Marketplace\Http\Requests\VendorWithdrawalRequest;
use Botble\Marketplace\Repositories\Interfaces\WithdrawalInterface;
use Botble\Marketplace\Tables\VendorWithdrawalTable;
use Exception;
use Illuminate\Support\Facades\DB;
use Botble\Marketplace\Facades\MarketplaceHelper;
use Throwable;

class WithdrawalController
{
    public function __construct(protected WithdrawalInterface $withdrawalRepository)
    {
    }

    public function index(VendorWithdrawalTable $table)
    {
        PageTitle::setTitle(__('Withdrawals'));

        return $table->render(MarketplaceHelper::viewPath('dashboard.table.base'));
    }

    public function create(FormBuilder $formBuilder, BaseHttpResponse $response)
    {
        $user = auth('customer')->user();
        $fee = MarketplaceHelper::getSetting('fee_withdrawal', 0);

        if ($user->balance <= $fee || ! $user->bank_info) {
            return $response
                ->setError()
                ->setNextUrl(route('marketplace.vendor.withdrawals.index'))
                ->setMessage(__('Insufficient balance or no bank information'));
        }

        PageTitle::setTitle(__('Withdrawal request'));

        return $formBuilder->create(VendorWithdrawalForm::class)->renderForm();
    }

    public function store(VendorWithdrawalRequest $request, BaseHttpResponse $response)
    {
        $fee = MarketplaceHelper::getSetting('fee_withdrawal', 0);
        $vendor = auth('customer')->user();
        $vendorInfo = $vendor->vendorInfo;

        try {
            DB::beginTransaction();

            $withdrawal = $this->withdrawalRepository->create([
                'fee' => $fee,
                'amount' => $request->input('amount'),
                'customer_id' => $vendor->getKey(),
                'currency' => get_application_currency()->title,
                'bank_info' => $vendorInfo->bank_info,
                'description' => $request->input('description'),
                'current_balance' => $vendorInfo->balance,
                'payment_channel' => $vendorInfo->payout_payment_method,
            ]);

            $vendorInfo->balance -= $request->input('amount') + $fee;
            $vendorInfo->save();

            event(new WithdrawalRequested($vendor, $withdrawal));

            DB::commit();
        } catch (Throwable | Exception $th) {
            DB::rollBack();

            return $response
                ->setError()
                ->setMessage($th->getMessage());
        }

        return $response
            ->setPreviousUrl(route('marketplace.vendor.withdrawals.index'))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(int|string $id, FormBuilder $formBuilder)
    {
        $withdrawal = $this->withdrawalRepository->getFirstBy([
            'id' => $id,
            'customer_id' => auth('customer')->id(),
            'status' => WithdrawalStatusEnum::PENDING,
        ]);

        if (! $withdrawal) {
            abort(404);
        }

        PageTitle::setTitle(__('Update withdrawal request #' . $id));

        return $formBuilder->create(VendorWithdrawalForm::class, ['model' => $withdrawal])->renderForm();
    }

    public function update(int|string $id, VendorEditWithdrawalRequest $request, BaseHttpResponse $response)
    {
        $withdrawal = $this->withdrawalRepository->getFirstBy([
            'id' => $id,
            'customer_id' => auth('customer')->id(),
            'status' => WithdrawalStatusEnum::PENDING,
        ]);

        if (! $withdrawal) {
            abort(404);
        }

        $status = WithdrawalStatusEnum::PENDING;
        if ($request->input('cancel')) {
            $status = WithdrawalStatusEnum::CANCELED;
            $response->setNextUrl(route('marketplace.vendor.withdrawals.show', $withdrawal->id));
        }

        $withdrawal->fill([
            'status' => $status,
            'description' => $request->input('description'),
        ]);

        $this->withdrawalRepository->createOrUpdate($withdrawal);

        return $response
            ->setPreviousUrl(route('marketplace.vendor.withdrawals.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function show(int|string $id, FormBuilder $formBuilder)
    {
        $withdrawal = $this->withdrawalRepository
            ->getFirstBy([
                ['id', '=', $id],
                ['customer_id', '=', auth('customer')->id()],
                ['status', '!=', WithdrawalStatusEnum::PENDING],
            ]);

        if (! $withdrawal) {
            abort(404);
        }

        PageTitle::setTitle(__('View withdrawal request #' . $id));

        return $formBuilder->create(VendorWithdrawalForm::class, ['model' => $withdrawal])->renderForm();
    }
}
