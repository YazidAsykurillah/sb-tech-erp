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
        	['id'=>3, 'code'=>'FIN', 'name'=>'Finance', 'label'=>'User with this role will have full access to finance modules'],
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
            //project module
            [ 'slug'=>'index-project', 'description'=>'Access Project Index method'],
            [ 'slug'=>'show-project', 'description'=>'Show single project'],
            [ 'slug'=>'create-project', 'description'=>'Access Project Create method'],
            [ 'slug'=>'edit-project', 'description'=>'Access Project Edit method'],
            [ 'slug'=>'delete-project', 'description'=>'Access Project Delete method'],

            //quotation-customer module
            ['slug'=>'index-quotation-customer', 'description'=>'Access Quotation Customer Index method'],
            ['slug'=>'show-quotation-customer', 'description'=>'show single quotation-customer'],
            ['slug'=>'create-quotation-customer', 'description'=>'Access Quotation Customer Create method'],
            ['slug'=>'edit-quotation-customer', 'description'=>'Access Quotation Customer Edit method'],
            ['slug'=>'delete-quotation-customer', 'description'=>'Access Quotation Customer Delete method'],
            ['slug'=>'change-quotation-customer-status', 'description'=>'Change quotation customer status'],
            ['slug'=>'pending-quotation-customer', 'description'=>'Change quotation customer to pending'],
            ['slug'=>'submit-quotation-customer', 'description'=>'Change quotation customer to submitted'],
            ['slug'=>'reject-quotation-customer', 'description'=>'Change quotation customer to rejected'],

            //quotation-vendor module
            [ 'slug'=>'index-quotation-vendor', 'description'=>'Access quotation-vendor Index method'],
            [ 'slug'=>'show-quotation-vendor', 'description'=>'Access quotation-vendor show method'],
            [ 'slug'=>'create-quotation-vendor', 'description'=>'Access quotation-vendor Create method'],
            [ 'slug'=>'edit-quotation-vendor', 'description'=>'Access quotation-vendor Edit method'],
            [ 'slug'=>'delete-quotation-vendor', 'description'=>'Access quotation-vendor Delete method'],

            //purchase-request module
            [ 'slug'=>'index-purchase-request', 'description'=>'Access Purchase Request Index method'],
            [ 'slug'=>'show-purchase-request', 'description'=>'Access Purchase Request show method'],
            [ 'slug'=>'create-purchase-request', 'description'=>'Access Purchase Request Create method'],
            [ 'slug'=>'edit-purchase-request', 'description'=>'Access Purchase Request Edit method'],
            [ 'slug'=>'delete-purchase-request', 'description'=>'Access Purchase Request Delete method'],

            //purchase-order-customer module
            [ 'slug'=>'index-purchase-order-customer', 'description'=>'Access Purchase Order Customer Index method'],
            [ 'slug'=>'show-purchase-order-customer', 'description'=>'Access Purchase Order Customer show method'],
            [ 'slug'=>'create-purchase-order-customer', 'description'=>'Access Purchase Order Customer Create method'],
            [ 'slug'=>'edit-purchase-order-customer', 'description'=>'Access Purchase Order Customer Edit method'],
            [ 'slug'=>'delete-purchase-order-customer', 'description'=>'Access Purchase Order Customer Delete method'],

            //purchase-order-vendor module
            [ 'slug'=>'index-purchase-order-vendor', 'description'=>'Access Purchase Order Vendor Index method'],
            [ 'slug'=>'show-purchase-order-vendor', 'description'=>'Access Purchase Order Vendor show method'],
            [ 'slug'=>'create-purchase-order-vendor', 'description'=>'Access Purchase Order Vendor Create method'],
            [ 'slug'=>'edit-purchase-order-vendor', 'description'=>'Access Purchase Order Vendor Edit method'],
            [ 'slug'=>'delete-purchase-order-vendor', 'description'=>'Access Purchase Order Vendor Delete method'],

            //internal request module
            [ 'slug'=>'index-internal-request', 'description'=>'View all internal request'],
            [ 'slug'=>'show-internal-request', 'description'=>'View single internal request'],
            [ 'slug'=>'create-internal-request', 'description'=>'Create internal request'],
            [ 'slug'=>'edit-internal-request', 'description'=>'Edit internal request'],
            [ 'slug'=>'delete-internal-request', 'description'=>'Delete internal request'],
            [ 'slug'=>'create-internal-request-to-other', 'description'=>'Create internal request for other member'],
            [ 'slug'=>'change-status-internal-request', 'description'=>'Change status internal request'],
            [ 'slug'=>'check-internal-request', 'description'=>'Change internal request status to Checked'],
            [ 'slug'=>'approve-internal-request', 'description'=>'Change internal request status to Approved'],
            [ 'slug'=>'reject-internal-request', 'description'=>'Change internal request status to Rejected'],

            //Settlement
            [ 'slug'=>'index-settlement', 'description'=>'View all settlement'],
            [ 'slug'=>'show-settlement', 'description'=>'View single settlement'],
            [ 'slug'=>'create-settlement', 'description'=>'Create settlement'],
            [ 'slug'=>'edit-settlement', 'description'=>'Edit settlement'],
            [ 'slug'=>'delete-settlement', 'description'=>'Delete settlement'],

            //Cash module
            ['slug'=>'index-cash', 'description'=>'View All index cashes'],
            ['slug'=>'show-cash', 'description'=>'View single cash'],
            ['slug'=>'create-cash', 'description'=>'Create cash'],
            ['slug'=>'edit-cash', 'description'=>'Access Cash Edit method'],
            ['slug'=>'delete-cash', 'description'=>'Access Cash Delete method'],
            
            //Transfer Task
            ['slug'=>'transfer-task', 'description'=>'Access Transfer Task Module'],
            ['slug'=>'transfer-task-internal-request', 'description'=>'Access Transfer Task Internal Request Module'],
            ['slug'=>'transfer-task-invoice-vendor', 'description'=>'Access Transfer Task Invoice Vendor'],
            ['slug'=>'transfer-task-settlement', 'description'=>'Access Transfer Task Settlement module'],

            //invoice-customer module
            [ 'slug'=>'index-invoice-customer', 'description'=>'Access invoice-customer Index method'],
            [ 'slug'=>'show-invoice-customer', 'description'=>'Access invoice-customer show method'],
            [ 'slug'=>'create-invoice-customer', 'description'=>'Access invoice-customer Create method'],
            [ 'slug'=>'edit-invoice-customer', 'description'=>'Access invoice-customer Edit method'],
            [ 'slug'=>'delete-invoice-customer', 'description'=>'Access invoice-customer Delete method'],

            //invoice-vendor module
            [ 'slug'=>'index-invoice-vendor', 'description'=>'Access invoice-vendor Index method'],
            [ 'slug'=>'show-invoice-vendor', 'description'=>'Access invoice-vendor show method'],
            [ 'slug'=>'create-invoice-vendor', 'description'=>'Access invoice-vendor Create method'],
            [ 'slug'=>'edit-invoice-vendor', 'description'=>'Access invoice-vendor Edit method'],
            [ 'slug'=>'delete-invoice-vendor', 'description'=>'Access invoice-vendor Delete method'],
        	
            //Customer
            [ 'slug'=>'index-customer', 'description'=>'View all customer'],
            [ 'slug'=>'show-customer', 'description'=>'View single customer'],
            [ 'slug'=>'create-customer', 'description'=>'Create customer'],
            [ 'slug'=>'edit-customer', 'description'=>'Edit customer'],
            [ 'slug'=>'delete-customer', 'description'=>'Delete customer'],

            //vendor module
            [ 'slug'=>'index-vendor', 'description'=>'Access vendor Index method'],
            [ 'slug'=>'show-vendor', 'description'=>'Access vendor show method'],
            [ 'slug'=>'create-vendor', 'description'=>'Access vendor Create method'],
            [ 'slug'=>'edit-vendor', 'description'=>'Access vendor Edit method'],
            [ 'slug'=>'delete-vendor', 'description'=>'Access vendor Delete method'],

            //Bank Administration
            [ 'slug'=>'index-bank-administration', 'description'=>'View all bank-administration'],
            [ 'slug'=>'show-bank-administration', 'description'=>'View single bank-administration'],
            [ 'slug'=>'create-bank-administration', 'description'=>'Create bank-administration'],
            [ 'slug'=>'edit-bank-administration', 'description'=>'Edit bank-administration'],
            [ 'slug'=>'delete-bank-administration', 'description'=>'Delete bank-administration'],

            
            
            
            //The Vendor
            [ 'slug'=>'index-the-vendor', 'description'=>'View all the-vendor'],
            [ 'slug'=>'show-the-vendor', 'description'=>'View single the-vendor'],
            [ 'slug'=>'create-the-vendor', 'description'=>'Create the-vendor'],
            [ 'slug'=>'edit-the-vendor', 'description'=>'Edit the-vendor'],
            [ 'slug'=>'delete-the-vendor', 'description'=>'Delete the-vendor'],

            //Master Data
            [ 'slug'=>'access-master-data', 'description'=>'View Master Data Menu'],

            //Bank Account
            [ 'slug'=>'index-bank-account', 'description'=>'View all bank-account'],
            [ 'slug'=>'show-bank-account', 'description'=>'View single bank-account'],
            [ 'slug'=>'create-bank-account', 'description'=>'Create bank-account'],
            [ 'slug'=>'edit-bank-account', 'description'=>'Edit bank-account'],
            [ 'slug'=>'delete-bank-account', 'description'=>'Delete bank-account'],

            //User
            [ 'slug'=>'index-user', 'description'=>'View all user'],
            [ 'slug'=>'show-user', 'description'=>'View single user'],
            [ 'slug'=>'create-user', 'description'=>'Create user'],
            [ 'slug'=>'edit-user', 'description'=>'Edit user'],
            [ 'slug'=>'delete-user', 'description'=>'Delete user'],

            //Role
            [ 'slug'=>'index-role', 'description'=>'View all role'],
            [ 'slug'=>'show-role', 'description'=>'View single role'],
            [ 'slug'=>'create-role', 'description'=>'Create role'],
            [ 'slug'=>'edit-role', 'description'=>'Edit role'],
            [ 'slug'=>'delete-role', 'description'=>'Delete role'],

            //Permission
            [ 'slug'=>'index-permission', 'description'=>'View all permission'],
            [ 'slug'=>'show-permission', 'description'=>'View single permission'],
            [ 'slug'=>'create-permission', 'description'=>'Create permission'],
            [ 'slug'=>'edit-permission', 'description'=>'Edit permission'],
            [ 'slug'=>'delete-permission', 'description'=>'Delete permission'],

            //Cash Bond
            [ 'slug'=>'index-cash-bond', 'description'=>'View all cash-bond'],
            [ 'slug'=>'show-cash-bond', 'description'=>'View single cash-bond'],
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
