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
            ['id'=>1, 'slug'=>'view-quotation-customer', 'description'=>'View Quotation Customer'],
            ['id'=>2, 'slug'=>'create-quotation-customer', 'description'=>'Access Quotation Customer Create method'],
            ['id'=>3, 'slug'=>'edit-quotation-customer', 'description'=>'Access Quotation Customer Edit method'],
            ['id'=>4, 'slug'=>'delete-quotation-customer', 'description'=>'Access Quotation Customer Delete method'],
            ['id'=>5, 'slug'=>'change-quotation-customer-status', 'description'=>'Change quotation customer status'],
            ['id'=>6, 'slug'=>'pending-quotation-customer', 'description'=>'Change quotation customer to pending'],
            ['id'=>7, 'slug'=>'submit-quotation-customer', 'description'=>'Change quotation customer to submitted'],
            ['id'=>8, 'slug'=>'reject-quotation-customer', 'description'=>'Change quotation customer to rejected'],

            //quotation-vendor module
            ['id'=>9, 'slug'=>'view-quotation-vendor', 'description'=>'View Quotation Vendor'],
            ['id'=>10, 'slug'=>'create-quotation-vendor', 'description'=>'Access Quotation Vendor Create method'],
            ['id'=>11, 'slug'=>'edit-quotation-vendor', 'description'=>'Access Quotation Vendor Edit method'],
            ['id'=>12, 'slug'=>'delete-quotation-vendor', 'description'=>'Access Quotation Vendor Delete method'],

            

            //purchase-order-customer module
            ['id'=>13, 'slug'=>'view-purchase-order-customer', 'description'=>'View Purchase Order Customer'],
            ['id'=>14, 'slug'=>'create-purchase-order-customer', 'description'=>'Access Purchase Order Customer Create method'],
            ['id'=>15, 'slug'=>'edit-purchase-order-customer', 'description'=>'Access Purchase Order Customer Edit method'],
            ['id'=>16, 'slug'=>'delete-purchase-order-customer', 'description'=>'Access Purchase Order Customer Delete method'],

            //purchase-order-vendor module
            ['id'=>17, 'slug'=>'view-purchase-order-vendor', 'description'=>'View Purchase Order Vendor'],
            ['id'=>18, 'slug'=>'create-purchase-order-vendor', 'description'=>'Access Purchase Order Vendor Create method'],
            ['id'=>19, 'slug'=>'edit-purchase-order-vendor', 'description'=>'Access Purchase Order Vendor Edit method'],
            ['id'=>20, 'slug'=>'delete-purchase-order-vendor', 'description'=>'Access Purchase Order Vendor Delete method'],

            //purchase-request module
            ['id'=>21, 'slug'=>'view-purchase-request', 'description'=>'View Purchase Request'],
            ['id'=>22, 'slug'=>'create-purchase-request', 'description'=>'Access Purchase Request Create method'],
            ['id'=>23, 'slug'=>'edit-purchase-request', 'description'=>'Access Purchase Request Edit method'],
            ['id'=>24, 'slug'=>'delete-purchase-request', 'description'=>'Access Purchase Request Delete method'],

            //internal request module
            ['id'=>25, 'slug'=>'view-internal-request', 'description'=>'View Internal request'],
            ['id'=>26, 'slug'=>'create-internal-request', 'description'=>'Create internal request'],
            ['id'=>27, 'slug'=>'edit-internal-request', 'description'=>'Edit internal request'],
            ['id'=>28, 'slug'=>'delete-internal-request', 'description'=>'Delete internal request'],
            ['id'=>29, 'slug'=>'create-internal-request-to-other', 'description'=>'Create internal request for other member'],
            ['id'=>30, 'slug'=>'change-status-internal-request', 'description'=>'Change status internal request'],
            ['id'=>31, 'slug'=>'check-internal-request', 'description'=>'Change internal request status to Checked'],
            ['id'=>32, 'slug'=>'approve-internal-request', 'description'=>'Change internal request status to Approved'],
            ['id'=>33, 'slug'=>'reject-internal-request', 'description'=>'Change internal request status to Rejected'],

            //Settlement
            ['id'=>34, 'slug'=>'view-settlement', 'description'=>'View settlement'],
            ['id'=>35, 'slug'=>'create-settlement', 'description'=>'Create settlement'],
            ['id'=>36, 'slug'=>'edit-settlement', 'description'=>'Edit settlement'],
            ['id'=>37, 'slug'=>'delete-settlement', 'description'=>'Delete settlement'],

            //project module
            ['id'=>38, 'slug'=>'view-project', 'description'=>'View project'],
            ['id'=>39, 'slug'=>'create-project', 'description'=>'Access Project Create method'],
            ['id'=>40, 'slug'=>'edit-project', 'description'=>'Access Project Edit method'],
            ['id'=>41, 'slug'=>'delete-project', 'description'=>'Access Project Delete method'],

            //Transfer Task
            ['id'=>42, 'slug'=>'transfer-task', 'description'=>'Access Transfer Task Module'],
            ['id'=>43, 'slug'=>'transfer-task-internal-request', 'description'=>'Access Transfer Task Internal Request Module'],
            ['id'=>44, 'slug'=>'transfer-task-invoice-vendor', 'description'=>'Access Transfer Task Invoice Vendor'],
            ['id'=>45, 'slug'=>'transfer-task-settlement', 'description'=>'Access Transfer Task Settlement module'],

            //invoice-customer module
            ['id'=>46, 'slug'=>'view-invoice-customer', 'description'=>'View Invoice Customer'],
            ['id'=>47, 'slug'=>'create-invoice-customer', 'description'=>'Access invoice-customer Create method'],
            ['id'=>48, 'slug'=>'edit-invoice-customer', 'description'=>'Access invoice-customer Edit method'],
            ['id'=>49, 'slug'=>'delete-invoice-customer', 'description'=>'Access invoice-customer Delete method'],

            //invoice-vendor module
            ['id'=>50, 'slug'=>'view-invoice-vendor', 'description'=>'View Invoice Vendor'],
            ['id'=>51, 'slug'=>'create-invoice-vendor', 'description'=>'Access invoice-vendor Create method'],
            ['id'=>52, 'slug'=>'edit-invoice-vendor', 'description'=>'Access invoice-vendor Edit method'],
            ['id'=>53, 'slug'=>'delete-invoice-vendor', 'description'=>'Access invoice-vendor Delete method'],

            //Cash module
            ['id'=>54, 'slug'=>'view-cash', 'description'=>'View cash'],
            ['id'=>55, 'slug'=>'create-cash', 'description'=>'Create cash'],
            ['id'=>56, 'slug'=>'edit-cash', 'description'=>'Edit Cash'],
            ['id'=>57, 'slug'=>'delete-cash', 'description'=>'Delete Cash'],
                	
            //Customer
            ['id'=>58, 'slug'=>'view-customer', 'description'=>'View customer'],
            ['id'=>59, 'slug'=>'create-customer', 'description'=>'Create customer'],
            ['id'=>60, 'slug'=>'edit-customer', 'description'=>'Edit customer'],
            ['id'=>61, 'slug'=>'delete-customer', 'description'=>'Delete customer'],

            //The Vendor
            ['id'=>62, 'slug'=>'view-the-vendor', 'description'=>'View Vendor'],
            ['id'=>63, 'slug'=>'create-the-vendor', 'description'=>'Create the-vendor'],
            ['id'=>64, 'slug'=>'edit-the-vendor', 'description'=>'Edit the-vendor'],
            ['id'=>65, 'slug'=>'delete-the-vendor', 'description'=>'Delete the-vendor'],
            

            //Master Data
            ['id'=>66, 'slug'=>'access-master-data', 'description'=>'View Master Data Menu'],

            //Bank Account
            ['id'=>67, 'slug'=>'view-bank-account', 'description'=>'View Member Bank Account'],
            ['id'=>68, 'slug'=>'create-bank-account', 'description'=>'Create Member Bank Account'],
            ['id'=>69, 'slug'=>'edit-bank-account', 'description'=>'Edit Member Bank Account'],
            ['id'=>70, 'slug'=>'delete-bank-account', 'description'=>'Delete Member Bank Account'],

            //User
            ['id'=>71, 'slug'=>'view-user', 'description'=>'View User'],
            ['id'=>72, 'slug'=>'create-user', 'description'=>'Create user'],
            ['id'=>73, 'slug'=>'edit-user', 'description'=>'Edit user'],
            ['id'=>74, 'slug'=>'delete-user', 'description'=>'Delete user'],

            //Role
            ['id'=>75, 'slug'=>'view-role', 'description'=>'View Role'],
            ['id'=>76, 'slug'=>'create-role', 'description'=>'Create role'],
            ['id'=>77, 'slug'=>'edit-role', 'description'=>'Edit role'],
            ['id'=>78, 'slug'=>'delete-role', 'description'=>'Delete role'],

            //Permission
            ['id'=>79, 'slug'=>'view-permission', 'description'=>'View Permission'],
            ['id'=>80, 'slug'=>'create-permission', 'description'=>'Create permission'],
            ['id'=>81, 'slug'=>'edit-permission', 'description'=>'Edit permission'],
            ['id'=>82, 'slug'=>'delete-permission', 'description'=>'Delete permission'],

            //Cash Bond
            ['id'=>83, 'slug'=>'view-cash-bond', 'description'=>'View Cashbonnd'],
            ['id'=>84, 'slug'=>'create-cash-bond', 'description'=>'Create cash-bond'],
            ['id'=>85, 'slug'=>'edit-cash-bond', 'description'=>'Edit cash-bond'],
            ['id'=>86, 'slug'=>'delete-cash-bond', 'description'=>'Delete cash-bond'],
            ['id'=>87, 'slug'=>'change-cash-bond-status', 'description'=>'Change cashbond status'],

            //Period
            ['id'=>88, 'slug'=>'index-period', 'description'=>'View all period'],
            ['id'=>89, 'slug'=>'show-period', 'description'=>'View single period'],
            ['id'=>90, 'slug'=>'create-period', 'description'=>'Create period'],
            ['id'=>91, 'slug'=>'edit-period', 'description'=>'Edit period'],
            ['id'=>92, 'slug'=>'delete-period', 'description'=>'Delete period'],
            
            //Finance Statistic
            ['id'=>93, 'slug'=>'access-finance-statistic', 'description'=>'View Master Finance Statistic menu']
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
