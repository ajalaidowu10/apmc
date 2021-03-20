import Vue from 'vue';
import Router from 'vue-router';

import PrintBooking from './components/admin/booking/Print';
import ViewCheckin from './components/admin/booking/Checkin';
import ViewCheckout from './components/admin/booking/Checkout';
import UserLogin from './views/UserLogin';
import AdminLogin from './views/AdminLogin';
import Signup from './views/Signup';
import Terms from './views/Terms';
import WebAdmin from './views/WebAdmin';
import AddItem from './components/admin/item/Add';
import ViewItem from './components/admin/item/View';
import AddItemExp from './components/admin/itemexp/Add';
import ViewItemExp from './components/admin/itemexp/View';
import AddRoom from './components/admin/room/Add';
import ViewRoom from './components/admin/room/View';
import AddAccount from './components/admin/account/Add';
import ViewAccount from './components/admin/account/View';
import ViewInvoice from './components/admin/booking/Invoice';
import AddCashbank from './components/admin/cashbank/Add';
import ViewCashbank from './components/admin/cashbank/View';
import PrintCashbank from './components/admin/cashbank/Print';
import EditCashbank from './components/admin/cashbank/Edit';
import AddGroupRoom from './components/admin/roomgroup/Add';
import ViewGroupRoom from './components/admin/roomgroup/View';
import AddSales from './components/admin/sales/Add';
import ViewSales from './components/admin/sales/View';
import EditSales from './components/admin/sales/Edit';
import PrintSales from './components/admin/sales/Print';
import AddService from './components/admin/service/Add';
import ViewService from './components/admin/service/View';
import AddServiceOrder from './components/admin/serviceorder/Add';
import ViewServiceOrder from './components/admin/serviceorder/View';
import EditServiceOrder from './components/admin/serviceorder/Edit';
import PrintServiceOrder from './components/admin/serviceorder/Print';
import AddJournal from './components/admin/journal/Add';
import ViewJournal from './components/admin/journal/View';
import EditJournal from './components/admin/journal/Edit';
import ReportCashbank from './components/admin/report/Cashbank';
import PrintCashbankReport from './components/admin/report/print/Cashbank';
import ReportJournal from './components/admin/report/Journal';
import PrintJournalReport from './components/admin/report/print/Journal';
import ReportLedger from './components/admin/report/Ledger';
import PrintLedgerReport from './components/admin/report/print/Ledger';
import AdminDashboard from './components/admin/Dashboard';
import AddUser from './components/admin/user/Add';
import ViewUser from './components/admin/user/View';
import EditUser from './components/admin/user/Edit';
import Logout from './views/Logout';
import AcctBal from './components/admin/enquiry/AcctBal';
import PrintAcctBalReport from './components/admin/enquiry/print/AcctBal';
import AddAcctGroup from './components/admin/acctgroup/Add';
import ViewAcctGroup from './components/admin/acctgroup/View';
import AddArea from './components/admin/area/Add';
import ViewArea from './components/admin/area/View';
import AddNarration from './components/admin/narration/Add';
import ViewNarration from './components/admin/narration/View';


Vue.use(Router);

const router = new Router({
  mode: 'history',
  base: process.env.APP_URL,
  hash: false,
  scrollBehavior (to, from, savedPosition) {
      return { x: 0, y: 0 };
  },
  routes: [
				    {
				      path: '/cashbank/receipt/:id',
				      name: 'print-cashbank',
				      component: PrintCashbank,
				      props: true,
				    },
				    {
				      path: '/cashbank/print/report/:dateFrom/:dateTo/:acctId',
				      name: 'print-cashbank-report',
				      component: PrintCashbankReport,
				      props: true,
				    },
				    {
				      path: '/journal/print/report/:dateFrom/:dateTo/:acctId',
				      name: 'print-journal-report',
				      component: PrintJournalReport,
				      props: true,
				    },
				    {
				      path: '/ledger/print/report/:dateFrom/:dateTo/:acctId',
				      name: 'print-ledger-report',
				      component: PrintLedgerReport,
				      props: true,
				    },
				    {
				      path: '/acctbal/print/report/:acctId/:dateTo',
				      name: 'print-acctbal-report',
				      component: PrintAcctBalReport,
				      props: true,
				    },
				    {
				      path: '/sales/invoice/:id',
				      name: 'print-sales',
				      component: PrintSales,
				      props: true,
				    },
				    {
				      path: '/serviceorder/invoice/:id',
				      name: 'print-serviceorder',
				      component: PrintServiceOrder,
				      props: true,
				    },
				    {
				      path: '/booking/invocie/:id',
				      name: 'print-booking',
				      component: PrintBooking,
				      props: true,
				    },
				    {
				      path: '/login',
				      name: 'login',
				      component: UserLogin,
				    },
				    {
				      path: '/signup',
				      name: 'signup',
				      component: Signup,
				    },
				    {
				      path: '/web-admin',
				      name: 'web-admin',
				      component: WebAdmin,
				    },
				    {
				      path: '/web-admin',
				      name: 'web-admin-booking',
				      component: WebAdmin,
				      children: [
				      	{
				      		path:'item',
				      		name: 'add-item',
				      		component: AddItem,
				      	},
				      	{
				      		path:'item',
				      		name: 'view-item',
				      		component: ViewItem,
				      	},
				      	{
				      		path:'itemexp',
				      		name: 'add-itemexp',
				      		component: AddItemExp,
				      	},
				      	{
				      		path:'itemexp',
				      		name: 'view-itemexp',
				      		component: ViewItemExp,
				      	},
				      	{
				      		path:'service',
				      		name: 'add-service',
				      		component: AddService,
				      	},
				      	{
				      		path:'service',
				      		name: 'view-service',
				      		component: ViewService,
				      	},
				      	{
				      	  path: 'checkin',
				      	  name: 'view-checkin',
				      	  component: ViewCheckin,
				      	},
				      	{
				      	  path: 'invoice',
				      	  name: 'view-invoice',
				      	  component: ViewInvoice,
				      	},
				      	{
				      	  path: 'checkout',
				      	  name: 'checkout',
				      	  component: ViewCheckout,
				      	},
				      	{
				      		path:'roomgroup',
				      		name: 'add-roomgroup',
				      		component: AddGroupRoom,
				      	},
				      	{
				      		path:'roomgroup',
				      		name: 'view-roomgroup',
				      		component: ViewGroupRoom,
				      	},
				      	{
				      		path:'room',
				      		name: 'add-room',
				      		component: AddRoom,
				      	},
				      	{
				      		path:'room',
				      		name: 'view-room',
				      		component: ViewRoom,
				      	},
				      	{
				      		path:'account',
				      		name: 'add-account',
				      		component: AddAccount,
				      	},
				      	{
				      		path:'account',
				      		name: 'view-account',
				      		component: ViewAccount,
				      	},
				      	{
				      		path:'cashbank',
				      		name: 'add-cashbank',
				      		component: AddCashbank,
				      	},
				      	{
				      		path:'cashbank',
				      		name: 'view-cashbank',
				      		component: ViewCashbank,
				      	},
				      	{
				      		path:'cashbank',
				      		name: 'edit-cashbank',
				      		component: EditCashbank,
				      	},
				      	{
				      		path:'sales',
				      		name: 'add-sales',
				      		component: AddSales,
				      	},
				      	{
				      		path:'sales',
				      		name: 'view-sales',
				      		component: ViewSales,
				      	},
				      	{
				      		path:'sales',
				      		name: 'edit-sales',
				      		component: EditSales,
				      	},
				      	{
				      		path:'serviceorder',
				      		name: 'add-serviceorder',
				      		component: AddServiceOrder,
				      	},
				      	{
				      		path:'serviceorder',
				      		name: 'view-serviceorder',
				      		component: ViewServiceOrder,
				      	},
				      	{
				      		path:'serviceorder',
				      		name: 'edit-serviceorder',
				      		component: EditServiceOrder,
				      	},
				      	{
				      		path:'journal',
				      		name: 'add-journal',
				      		component: AddJournal,
				      	},
				      	{
				      		path:'journal',
				      		name: 'view-journal',
				      		component: ViewJournal,
				      	},
				      	{
				      		path:'journal',
				      		name: 'edit-journal',
				      		component: EditJournal,
				      	},
				      	{
				      		path:'report/cashbank',
				      		name: 'report-cashbank',
				      		component: ReportCashbank,
				      	},
				      	{
				      		path:'report/journal',
				      		name: 'report-journal',
				      		component: ReportJournal,
				      	},
				      	{
				      		path:'report/ledger',
				      		name: 'report-ledger',
				      		component: ReportLedger,
				      	},
				      	{
				      		path:'dashboard',
				      		name: 'admin-dashboard',
				      		component: AdminDashboard,
				      	},
				      	{
				      		path:'user',
				      		name: 'add-user',
				      		component: AddUser,
				      	},
				      	{
				      		path:'user',
				      		name: 'view-user',
				      		component: ViewUser,
				      	},
				      	{
				      		path:'user',
				      		name: 'edit-user',
				      		component: EditUser,
				      	},
				      	{
				      		path:'enquiry/acctbal',
				      		name: 'enquiry-acctbal',
				      		component: AcctBal,
				      	},
				      	{
				      		path:'acctgroup',
				      		name: 'add-acctgroup',
				      		component: AddAcctGroup,
				      	},
				      	{
				      		path:'acctgroup',
				      		name: 'view-acctgroup',
				      		component: ViewAcctGroup,
				      	},
				      	{
				      		path:'area',
				      		name: 'add-area',
				      		component: AddArea,
				      	},
				      	{
				      		path:'area',
				      		name: 'view-area',
				      		component: ViewArea,
				      	},
				      	{
				      		path:'narration',
				      		name: 'add-narration',
				      		component: AddNarration,
				      	},
				      	{
				      		path:'narration',
				      		name: 'view-narration',
				      		component: ViewNarration,
				      	},

				      ]
				    },
				    {
				      path: '/web-admin/login',
				      name: 'admin-login',
				      component: AdminLogin,
				    },
				    {
				      path: '/logout',
				      name: 'logout',
				      component: Logout,
				    },

				    
				]
});

export default router;