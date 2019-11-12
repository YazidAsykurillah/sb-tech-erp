<?php

use Illuminate\Database\Seeder;

class AclTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Block table roles
	    DB::table('roles')->delete();
        $roles = [
        	['id'=>1, 'code'=>'SUP', 'name'=>'Super Admin', 'label'=>'User with this role will have full access to apllication'],
        	['id'=>2, 'code'=>'ADM', 'name'=>'Administrator', 'label'=>'User with this role will have semi-full access to apllication'],
        	['id'=>3, 'code'=>'HRD', 'name'=>'Human Resource Development', 'label'=>'User with this role will have full access to HRD modules'],
        	['id'=>4, 'code'=>'WRH', 'name'=>'Warehouse', 'label'=>'User with this role will have full access to warehouse modules'],
            ['id'=>5, 'code'=>'MKT', 'name'=>'Marketing', 'label'=>'User with this role will have full access to marketing modules'],
            ['id'=>6, 'code'=>'SAL', 'name'=>'Sales', 'label'=>'User with this role will have full access to sales modules'],
            ['id'=>7, 'code'=>'ENG', 'name'=>'Engineer', 'label'=>'User with this role will have full access to engineer modules'],
        ];
        DB::table('roles')->insert($roles);
	    //ENDBlock table roles

        //Block table role_user
	    DB::table('role_user')->delete();
        $role_user = [
        	['role_id'=>1, 'user_id'=>1],
        	['role_id'=>2, 'user_id'=>2],
            ['role_id'=>3, 'user_id'=>3],
            ['role_id'=>4, 'user_id'=>4],
            ['role_id'=>5, 'user_id'=>5],
            ['role_id'=>6, 'user_id'=>6],
            ['role_id'=>7, 'user_id'=>7],
            ['role_id'=>7, 'user_id'=>8],
            ['role_id'=>7, 'user_id'=>9],
            ['role_id'=>7, 'user_id'=>10],
            ['role_id'=>7, 'user_id'=>11],
            ['role_id'=>7, 'user_id'=>12],

        ];
        DB::table('role_user')->insert($role_user);
        //ENDBlock table role_user

        //Block table permissions
        DB::table('permissions')->delete();
        $permissions = [
            //quotation-customer module
            ['slug'=>'view-quotation-customer', 'description'=>'View Quotation Customer'],
            ['slug'=>'create-quotation-customer', 'description'=>'Access Quotation Customer Create method'],
            ['slug'=>'edit-quotation-customer', 'description'=>'Access Quotation Customer Edit method'],
            ['slug'=>'delete-quotation-customer', 'description'=>'Access Quotation Customer Delete method'],
            ['slug'=>'change-quotation-customer-status', 'description'=>'Change quotation customer status'],
            ['slug'=>'pending-quotation-customer', 'description'=>'Change quotation customer to pending'],
            ['slug'=>'submit-quotation-customer', 'description'=>'Change quotation customer to submitted'],
            ['slug'=>'reject-quotation-customer', 'description'=>'Change quotation customer to rejected'],

            //quotation-vendor module
            [ 'slug'=>'view-quotation-vendor', 'description'=>'View Quotation Vendor'],
            [ 'slug'=>'create-quotation-vendor', 'description'=>'Access Quotation Vendor Create method'],
            [ 'slug'=>'edit-quotation-vendor', 'description'=>'Access Quotation Vendor Edit method'],
            [ 'slug'=>'delete-quotation-vendor', 'description'=>'Access Quotation Vendor Delete method'],

            

            //purchase-order-customer module
            [ 'slug'=>'view-purchase-order-customer', 'description'=>'View Purchase Order Customer'],
            [ 'slug'=>'create-purchase-order-customer', 'description'=>'Access Purchase Order Customer Create method'],
            [ 'slug'=>'edit-purchase-order-customer', 'description'=>'Access Purchase Order Customer Edit method'],
            [ 'slug'=>'delete-purchase-order-customer', 'description'=>'Access Purchase Order Customer Delete method'],

            //purchase-order-vendor module
            [ 'slug'=>'view-purchase-order-vendor', 'description'=>'View Purchase Order Vendor'],
            [ 'slug'=>'create-purchase-order-vendor', 'description'=>'Access Purchase Order Vendor Create method'],
            [ 'slug'=>'edit-purchase-order-vendor', 'description'=>'Access Purchase Order Vendor Edit method'],
            [ 'slug'=>'delete-purchase-order-vendor', 'description'=>'Access Purchase Order Vendor Delete method'],

            //purchase-request module
            [ 'slug'=>'view-purchase-request', 'description'=>'View Purchase Request'],
            [ 'slug'=>'create-purchase-request', 'description'=>'Access Purchase Request Create method'],
            [ 'slug'=>'edit-purchase-request', 'description'=>'Access Purchase Request Edit method'],
            [ 'slug'=>'delete-purchase-request', 'description'=>'Access Purchase Request Delete method'],

            //internal request module
            [ 'slug'=>'view-internal-request', 'description'=>'View Internal request'],
            [ 'slug'=>'create-internal-request', 'description'=>'Create internal request'],
            [ 'slug'=>'edit-internal-request', 'description'=>'Edit internal request'],
            [ 'slug'=>'delete-internal-request', 'description'=>'Delete internal request'],
            [ 'slug'=>'create-internal-request-to-other', 'description'=>'Create internal request for other member'],
            [ 'slug'=>'change-status-internal-request', 'description'=>'Change status internal request'],
            [ 'slug'=>'check-internal-request', 'description'=>'Change internal request status to Checked'],
            [ 'slug'=>'approve-internal-request', 'description'=>'Change internal request status to Approved'],
            [ 'slug'=>'reject-internal-request', 'description'=>'Change internal request status to Rejected'],

            //Settlement
            [ 'slug'=>'view-settlement', 'description'=>'View settlement'],
            [ 'slug'=>'create-settlement', 'description'=>'Create settlement'],
            [ 'slug'=>'edit-settlement', 'description'=>'Edit settlement'],
            [ 'slug'=>'delete-settlement', 'description'=>'Delete settlement'],

            //project module
            [ 'slug'=>'view-project', 'description'=>'View project'],
            [ 'slug'=>'create-project', 'description'=>'Access Project Create method'],
            [ 'slug'=>'edit-project', 'description'=>'Access Project Edit method'],
            [ 'slug'=>'delete-project', 'description'=>'Access Project Delete method'],

            //Transfer Task
            ['slug'=>'transfer-task', 'description'=>'Access Transfer Task Module'],
            ['slug'=>'transfer-task-internal-request', 'description'=>'Access Transfer Task Internal Request Module'],
            ['slug'=>'transfer-task-invoice-vendor', 'description'=>'Access Transfer Task Invoice Vendor'],
            ['slug'=>'transfer-task-settlement', 'description'=>'Access Transfer Task Settlement module'],

            //invoice-customer module
            [ 'slug'=>'view-invoice-customer', 'description'=>'View Invoice Customer'],
            [ 'slug'=>'create-invoice-customer', 'description'=>'Access invoice-customer Create method'],
            [ 'slug'=>'edit-invoice-customer', 'description'=>'Access invoice-customer Edit method'],
            [ 'slug'=>'delete-invoice-customer', 'description'=>'Access invoice-customer Delete method'],

            //invoice-vendor module
            [ 'slug'=>'view-invoice-vendor', 'description'=>'View Invoice Vendor'],
            [ 'slug'=>'create-invoice-vendor', 'description'=>'Access invoice-vendor Create method'],
            [ 'slug'=>'edit-invoice-vendor', 'description'=>'Access invoice-vendor Edit method'],
            [ 'slug'=>'delete-invoice-vendor', 'description'=>'Access invoice-vendor Delete method'],

            //Cash module
            ['slug'=>'view-cash', 'description'=>'View cash'],
            ['slug'=>'create-cash', 'description'=>'Create cash'],
            ['slug'=>'edit-cash', 'description'=>'Edit Cash'],
            ['slug'=>'delete-cash', 'description'=>'Delete Cash'],
                	
            //Customer
            [ 'slug'=>'view-customer', 'description'=>'View customer'],
            [ 'slug'=>'create-customer', 'description'=>'Create customer'],
            [ 'slug'=>'edit-customer', 'description'=>'Edit customer'],
            [ 'slug'=>'delete-customer', 'description'=>'Delete customer'],

            //The Vendor
            [ 'slug'=>'view-the-vendor', 'description'=>'View Vendor'],
            [ 'slug'=>'create-the-vendor', 'description'=>'Create the-vendor'],
            [ 'slug'=>'edit-the-vendor', 'description'=>'Edit the-vendor'],
            [ 'slug'=>'delete-the-vendor', 'description'=>'Delete the-vendor'],
            

            //Master Data
            [ 'slug'=>'access-master-data', 'description'=>'View Master Data Menu'],

            //Bank Account
            [ 'slug'=>'view-bank-account', 'description'=>'View Member Bank Account'],
            [ 'slug'=>'create-bank-account', 'description'=>'Create Member Bank Account'],
            [ 'slug'=>'edit-bank-account', 'description'=>'Edit Member Bank Account'],
            [ 'slug'=>'delete-bank-account', 'description'=>'Delete Member Bank Account'],

            //User
            [ 'slug'=>'view-user', 'description'=>'View User'],
            [ 'slug'=>'create-user', 'description'=>'Create user'],
            [ 'slug'=>'edit-user', 'description'=>'Edit user'],
            [ 'slug'=>'delete-user', 'description'=>'Delete user'],

            //Role
            [ 'slug'=>'view-role', 'description'=>'View Role'],
            [ 'slug'=>'create-role', 'description'=>'Create role'],
            [ 'slug'=>'edit-role', 'description'=>'Edit role'],
            [ 'slug'=>'delete-role', 'description'=>'Delete role'],

            //Permission
            [ 'slug'=>'view-permission', 'description'=>'View Permission'],
            [ 'slug'=>'create-permission', 'description'=>'Create permission'],
            [ 'slug'=>'edit-permission', 'description'=>'Edit permission'],
            [ 'slug'=>'delete-permission', 'description'=>'Delete permission'],

            //Cash Bond
            [ 'slug'=>'view-cash-bond', 'description'=>'View Cashbonnd'],
            [ 'slug'=>'create-cash-bond', 'description'=>'Create cash-bond'],
            [ 'slug'=>'edit-cash-bond', 'description'=>'Edit cash-bond'],
            [ 'slug'=>'delete-cash-bond', 'description'=>'Delete cash-bond'],
            [ 'slug'=>'change-cash-bond-status', 'description'=>'Change cashbond status'],

            //Period
            [ 'slug'=>'index-period', 'description'=>'View all period'],
            [ 'slug'=>'show-period', 'description'=>'View single period'],
            [ 'slug'=>'create-period', 'description'=>'Create period'],
            [ 'slug'=>'edit-period', 'description'=>'Edit period'],
            [ 'slug'=>'delete-period', 'description'=>'Delete period'],

            

            

            //Finance Statistic
            [ 'slug'=>'access-finance-statistic', 'description'=>'View Master Finance Statistic menu']
        ];
        DB::table('permissions')->insert($permissions);
        //ENDBlock table permissions

        //Block table permission_role
        DB::table('permission_role')->delete();
        $permission_role = [
        	//Administrator privilleges
        	['permission_id'=>1, 'role_id'=>2],
        	['permission_id'=>2, 'role_id'=>2],
        	['permission_id'=>3, 'role_id'=>2],
        	['permission_id'=>4, 'role_id'=>2],
        ];
        DB::table('permission_role')->insert($permission_role);
        //ENDBlock table permission_role
    }
}
