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
      $new_permission->module()->associate($module_master);
      $new_permission->slug = 'account';
      $new_permission->name = 'Account';
      $new_permission->icon = 'mdi-account-cog';
      $new_permission->link = '/web-admin/account';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_master);
      $new_permission->slug = 'item';
      $new_permission->name = 'Item';
      $new_permission->icon = 'mdi-food-variant';
      $new_permission->link = '/web-admin/item';
      $new_permission->save();


      $new_permission = new Permission();
      $new_permission->module()->associate($module_master);
      $new_permission->slug = 'room-group';
      $new_permission->name = 'Room Group';
      $new_permission->link = '/web-admin/roomgroup';
      $new_permission->icon = 'mdi-android-auto';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_master);
      $new_permission->slug = 'room';
      $new_permission->name = 'Room';
      $new_permission->link = '/web-admin/room';
      $new_permission->icon = 'mdi-home-thermometer';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_master);
      $new_permission->slug = 'service';
      $new_permission->name = 'Service';
      $new_permission->link = '/web-admin/service';
      $new_permission->icon = 'mdi-hail';
      $new_permission->save();

      

      $new_permission = new Permission();
      $new_permission->module()->associate($module_data_entry);
      $new_permission->slug = 'booking';
      $new_permission->name = 'Booking';
      $new_permission->icon = 'mdi-notebook-check-outline';
      $new_permission->link = '/web-admin/booking';
      $new_permission->save();

      
      $new_permission = new Permission();
      $new_permission->module()->associate($module_data_entry);
      $new_permission->slug = 'check-in';
      $new_permission->name = 'Checkin';
      $new_permission->link = '/web-admin/checkin';
      $new_permission->icon = 'mdi-home-import-outline';

      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_data_entry);
      $new_permission->slug = 'check-out';
      $new_permission->name = 'Checkout';
      $new_permission->link = '/web-admin/checkout';
      $new_permission->icon = 'mdi-home-export-outline';
      $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_data_entry);
      $new_permission->slug = 'invoice-report';
      $new_permission->name = 'Invoice';
      $new_permission->link = '/web-admin/invoice';
      $new_permission->icon = 'mdi-note-text';
      $new_permission->save();


      $new_permission = new Permission();
      $new_permission->module()->associate($module_data_entry);
      $new_permission->slug = 'restuarant-sales';
      $new_permission->name = 'Restuarant';
      $new_permission->link = '/web-admin/sales';
      $new_permission->icon = 'mdi-food-fork-drink';
      $new_permission->save();


      $new_permission = new Permission();
      $new_permission->module()->associate($module_data_entry);
      $new_permission->slug = 'service-order';
      $new_permission->name = 'Service Order';
      $new_permission->link = '/web-admin/serviceorder';
      $new_permission->icon = 'mdi-hail';
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
      $new_permission->slug = 'ledger-report';
      $new_permission->name = 'Ledger';
      $new_permission->link = '/web-admin/report/ledger';
      $new_permission->icon = 'mdi-file-document-multiple-outline';
      $new_permission->save();

      // $new_permission = new Permission();
      // $new_permission->module()->associate($module_enquiry);
      // $new_permission->slug = 'room-report';
      // $new_permission->link = '/web-admin/enquiry/room';   
      // $new_permission->name = 'Room Report';
      // $new_permission->icon = 'mdi-home-variant-outline';
      // $new_permission->save();

      $new_permission = new Permission();
      $new_permission->module()->associate($module_enquiry);
      $new_permission->slug = 'account-bal';
      $new_permission->link = '/web-admin/enquiry/acctbal';
      $new_permission->name = 'Account Balance';
      $new_permission->icon = 'mdi-cash-multiple';
      $new_permission->save();

      
        
    }
}
