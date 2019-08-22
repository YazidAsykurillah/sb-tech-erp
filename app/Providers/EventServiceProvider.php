<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\TransferInvoiceVendor' => [
            'App\Listeners\SynchronizePurchaseOrderStatus',
        ],
        'App\Events\InvoiceCustomerWasPaid' => [
            'App\Listeners\RegisterTransactionFromInvoiceCustomer',
        ],
        'App\Events\PayrollIsDeleted' => [
            'App\Listeners\DeleteAllowanceParameters',
            'App\Listeners\DeleteExtraPayrollPayment',
            'App\Listeners\DeleteIncentiveWeekDay',
            'App\Listeners\DeleteIncentiveWeekEnd',
            'App\Listeners\DeleteBpjsKesehatan',
            'App\Listeners\DeleteBpjsKetenagakerjaan',
            'App\Listeners\DeleteSettlementPayroll',
        ],
        'App\Events\PayrollIsCreated' => [
            'App\Listeners\RegisterWokshopAllowance',
            'App\Listeners\RegisterCompetencyAllowance',
            'App\Listeners\RegisterBpjsKesehatan',
            'App\Listeners\RegisterBpjsKetenagakerjaan',
            'App\Listeners\RegisterSettlementPayroll',
        ],
        'App\Events\ItemPurchaseRequestIsReceived'=>[
            'App\Listeners\RegisterItemPurchaseRequestToProduct',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
