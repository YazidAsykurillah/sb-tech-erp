<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(AclTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(VendorTableSeeder::class);
        //$this->call(BankAcountTableSeeder::class);
        //$this->call(PurchaseOrderCustomerTableSeeder::class);
        //$this->call(ProjectTablesSeeder::class);
        //$this->call(PurchaseRequestTableSeeder::class);
        //$this->call(InvoiceCustomerTableSeeder::class);
        //$this->call(InvoiceVendorTableSeeder::class);
        //$this->call(PurchaseOrderVendorTableSeeder::class);
        //$this->call(InternalRequestTableSeeder::class);
        //$this->call(CategoryTableSeeder::class);
        //$this->call(SubCategoryTableSeeder::class);
        //$this->call(QuotationCustomerTableSeeder::class);
        //$this->call(QuotationVendorTableSeeder::class);
        //$this->call(SettlementTableSeeder::class);
        //$this->call(CashbondTableSeeder::class);
        //$this->call(CashTableSeeder::class);
        //$this->call(BankAdministrationTableSeeder::class);
        //$this->call(TransactionTableSeeder::class);
        //$this->call(LockConfigurationTableSeeder::class);
        //$this->call(PeriodTableSeeder::class);
        //$this->call(TimeReportTableSeeder::class);
        //$this->call(ItemInvoiceCustomerTableSeeder::class);
        
    }
}
