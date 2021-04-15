<?php

use Illuminate\Database\Seeder;
use App\Module;
use App\Role;
use App\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $module_master = Module::where('name','Master')->first();
      $module_data_entry = Module::where('name','Data Entry')->first();
      $module_report = Module::where('name','Reports')->first();
      $module_printing = Module::where('name','Printing')->first();
      $module_enquiry = Module::where('name','Enquiry')->first();
      $module_utility = Module::where('name','Utility')->first();
      $module_dashboard = Module::where('name','Dashboard')->first();

      
      $new_permission = new Permission();
      $new_permission->module()->associate($module_dashboard);
      $new_permission->slug = 'dashboard';
      $new_permission->name = 'Dashboard';
      $new_permission->link = '/web-admin/dashboard';
      $new_permission->icon = 'mdi-view-dashboard';

      $new_permission->save();


      $new_permission = new Permission();
      $new_permission->module()->associate($module_utility);
      $new_permission->slug = 'user';
      $new_permission->name = 'User';
      $new_permission->link = '/web-admin/user';
      $new_permission->icon = 'mdi-account-tie';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_utility);
      $new_permission->slug = 'backup-restore';
      $new_permission->name = 'Backup/Restore';
      $new_permission->link = '/web-admin/backup';
      $new_permission->icon = 'mdi-backup-restore';
      $new_permission->save();


      $new_permission = new Permission();
      $new_permission->module()->associate($module_master);
      $new_permission->slug = 'account';
      $new_permission->name = 'Account';
      $new_permission->icon = 'mdi-account-cog';
      $new_permission->link = '/web-admin/account';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_master);
      $new_permission->slug = 'area';
      $new_permission->name = 'Area';
      $new_permission->icon = 'mdi-air-horn';
      $new_permission->link = '/web-admin/area';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_master);
      $new_permission->slug = 'narration';
      $new_permission->name = 'Narration';
      $new_permission->icon = 'mdi-message-text';
      $new_permission->link = '/web-admin/narration';
      $new_permission->save();

      
      $new_permission = new Permission();
      $new_permission->module()->associate($module_master);
      $new_permission->slug = 'item';
      $new_permission->name = 'Item';
      $new_permission->icon = 'mdi-star';
      $new_permission->link = '/web-admin/item';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_master);
      $new_permission->slug = 'item-exp';
      $new_permission->name = 'Item Expense';
      $new_permission->icon = 'mdi-star-cog';
      $new_permission->link = '/web-admin/itemexp';
      $new_permission->save();


      $new_permission = new Permission();
      $new_permission->module()->associate($module_master);
      $new_permission->slug = 'account-group';
      $new_permission->name = 'Account Group';
      $new_permission->icon = 'mdi-account-network';
      $new_permission->link = '/web-admin/acctgroup';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_master);
      $new_permission->slug = 'company';
      $new_permission->name = 'Company';
      $new_permission->icon = 'mdi-account-supervisor-circle';
      $new_permission->link = '/web-admin/company';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_master);
      $new_permission->slug = 'fin-year';
      $new_permission->name = 'Financial Year';
      $new_permission->icon = 'mdi-bullseye-arrow';
      $new_permission->link = '/web-admin/finyear';
      $new_permission->save();


      $new_permission = new Permission();
      $new_permission->module()->associate($module_data_entry);
      $new_permission->slug = 'purchase-entry';
      $new_permission->name = 'Purchase Entry';
      $new_permission->link = '/web-admin/purchase';
      $new_permission->icon = 'mdi-alpha-p-box';
      $new_permission->save();


      $new_permission = new Permission();
      $new_permission->module()->associate($module_data_entry);
      $new_permission->slug = 'sales-entry';
      $new_permission->name = 'Sales Entry';
      $new_permission->link = '/web-admin/sales';
      $new_permission->icon = 'mdi-alpha-s-box';
      $new_permission->save();


      $new_permission = new Permission();
      $new_permission->module()->associate($module_printing);
      $new_permission->slug = 'purchase-printing';
      $new_permission->name = 'Purchase Bill';
      $new_permission->link = '/web-admin/printing/purchasebill';
      $new_permission->icon = 'mdi-alpha-p-box';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_printing);
      $new_permission->slug = 'sales-printing';
      $new_permission->name = 'Sales Bill';
      $new_permission->link = '/web-admin/printing/salesbill';
      $new_permission->icon = 'mdi-alpha-s-box';
      $new_permission->save();




      

      $new_permission = new Permission();
      $new_permission->module()->associate($module_data_entry);
      $new_permission->slug = 'cash-bank';
      $new_permission->name = 'Cash Bank';
      $new_permission->link = '/web-admin/cashbank';
      $new_permission->icon = 'mdi-bank';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_data_entry);
      $new_permission->slug = 'journal';
      $new_permission->name = 'Journal';
      $new_permission->link = '/web-admin/journal';
      $new_permission->icon = 'mdi-notebook-multiple';
      $new_permission->save();


      

      $new_permission = new Permission();
      $new_permission->module()->associate($module_report);
      $new_permission->slug = 'cashbank-report';
      $new_permission->name = 'Cash Bank';
      $new_permission->link = '/web-admin/report/cashbank';
      $new_permission->icon = 'mdi-bank';
      $new_permission->save();


      $new_permission = new Permission();
      $new_permission->module()->associate($module_report);
      $new_permission->slug = 'journal-report';
      $new_permission->name = 'Journal';
      $new_permission->link = '/web-admin/report/journal';
      $new_permission->icon = 'mdi-notebook-multiple';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_report);
      $new_permission->slug = 'purchase-report';
      $new_permission->name = 'Purchase';
      $new_permission->link = '/web-admin/report/purchase';
      $new_permission->icon = 'mdi-alpha-p-box';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_report);
      $new_permission->slug = 'sales-report';
      $new_permission->name = 'Sales';
      $new_permission->link = '/web-admin/report/sales';
      $new_permission->icon = 'mdi-alpha-s-box';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_report);
      $new_permission->slug = 'ledger-report';
      $new_permission->name = 'Ledger';
      $new_permission->link = '/web-admin/report/ledger';
      $new_permission->icon = 'mdi-file-document-multiple-outline';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_report);
      $new_permission->slug = 'trialbal-report';
      $new_permission->name = 'Trial Balance';
      $new_permission->link = '/web-admin/report/trialbal';
      $new_permission->icon = 'mdi-table-large';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_report);
      $new_permission->slug = 'balsheet-report';
      $new_permission->name = 'Balance Sheet';
      $new_permission->link = '/web-admin/report/balsheet';
      $new_permission->icon = 'mdi-scale-balance';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_report);
      $new_permission->slug = 'ploss-report';
      $new_permission->name = 'Proft & Loss';
      $new_permission->link = '/web-admin/report/ploss';
      $new_permission->icon = 'mdi-cash-plus';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_report);
      $new_permission->slug = 'schedule-report';
      $new_permission->name = 'Schedule';
      $new_permission->link = '/web-admin/report/schedule';
      $new_permission->icon = 'mdi-book-open-outline';
      $new_permission->save();

      


      $new_permission = new Permission();
      $new_permission->module()->associate($module_enquiry);
      $new_permission->slug = 'account-bal';
      $new_permission->link = '/web-admin/enquiry/acctbal';
      $new_permission->name = 'Account Balance';
      $new_permission->icon = 'mdi-cash-multiple';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_enquiry);
      $new_permission->slug = 'stock-report';
      $new_permission->link = '/web-admin/enquiry/stock';   
      $new_permission->name = 'Stock Report';
      $new_permission->icon = 'mdi-card-bulleted';
      $new_permission->save();

      
        
    }
}
