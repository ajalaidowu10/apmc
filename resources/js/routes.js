import Vue from 'vue';
import Router from 'vue-router';

import AdminLogin from './views/AdminLogin';
import FinancialYear from './views/FinancialYear';
import WebAdmin from './views/WebAdmin';
import AddItem from './components/admin/item/Add';
import ViewItem from './components/admin/item/View';
import AddItemExp from './components/admin/itemexp/Add';
import ViewItemExp from './components/admin/itemexp/View';
import AddAccount from './components/admin/account/Add';
import ViewAccount from './components/admin/account/View';
import AddCashbank from './components/admin/cashbank/Add';
import ViewCashbank from './components/admin/cashbank/View';
import PrintCashbank from './components/admin/cashbank/Print';
import EditCashbank from './components/admin/cashbank/Edit';
import AddSales from './components/admin/sales/Add';
import ViewSales from './components/admin/sales/View';
import EditSales from './components/admin/sales/Edit';
import PrintSales from './components/admin/sales/Print';
import AddPurchase from './components/admin/purchase/Add';
import ViewPurchase from './components/admin/purchase/View';
import EditPurchase from './components/admin/purchase/Edit';
import PrintPurchase from './components/admin/purchase/Print';
import AddJournal from './components/admin/journal/Add';
import ViewJournal from './components/admin/journal/View';
import EditJournal from './components/admin/journal/Edit';
import ReportCashbank from './components/admin/report/Cashbank';
import PrintCashbankReport from './components/admin/report/print/Cashbank';
import ReportJournal from './components/admin/report/Journal';
import PrintJournalReport from './components/admin/report/print/Journal';
import ReportTrialbal from './components/admin/report/Trialbal';
import PrintTrialbalReport from './components/admin/report/print/Trialbal';
import ReportBalsheet from './components/admin/report/Balsheet';
import PrintBalsheetReport from './components/admin/report/print/Balsheet'
import ReportLedger from './components/admin/report/Ledger';
import PrintLedgerReport from './components/admin/report/print/Ledger';
import ReportSchedule from './components/admin/report/Schedule';
import PrintScheduleReport from './components/admin/report/print/Schedule';
import AdminDashboard from './components/admin/Dashboard';
import AddUser from './components/admin/user/Add';
import ViewUser from './components/admin/user/View';
import EditUser from './components/admin/user/Edit';
import Logout from './views/Logout';
import AcctBal from './components/admin/enquiry/AcctBal';
import PrintAcctBalReport from './components/admin/enquiry/print/AcctBal';
import Stock from './components/admin/enquiry/Stock';
import PrintStockReport from './components/admin/enquiry/print/Stock';
import AddAcctGroup from './components/admin/acctgroup/Add';
import ViewAcctGroup from './components/admin/acctgroup/View';
import AddArea from './components/admin/area/Add';
import ViewArea from './components/admin/area/View';
import AddNarration from './components/admin/narration/Add';
import ViewNarration from './components/admin/narration/View';
import ReportPurchase from './components/admin/report/Purchase';
import PrintPurchaseReport from './components/admin/report/print/Purchase';
import ReportSales from './components/admin/report/Sales';
import PrintSalesReport from './components/admin/report/print/Sales';
import AddCompany from './components/admin/company/Add';
import ViewCompany from './components/admin/company/View';
import AddFinYear from './components/admin/finyear/Add';
import ViewFinYear from './components/admin/finyear/View';



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
				      path: '/report/print/trialbal/:dateFrom/:dateTo',
				      name: 'print-trialbal-report',
				      component: PrintTrialbalReport,
				      props: true,
				    },
				    {
				      path: '/report/print/balsheet/:dateTo',
				      name: 'print-balsheet-report',
				      component: PrintBalsheetReport,
				      props: true,
				    },
				    {
				      path: '/purchase/print/report/:dateFrom/:dateTo/:acctId',
				      name: 'print-purchase-report',
				      component: PrintPurchaseReport,
				      props: true,
				    },
				    {
				      path: '/sales/print/report/:dateFrom/:dateTo/:acctId',
				      name: 'print-sales-report',
				      component: PrintSalesReport,
				      props: true,
				    },
				    {
				      path: '/ledger/print/report/:dateFrom/:dateTo/:acctId',
				      name: 'print-ledger-report',
				      component: PrintLedgerReport,
				      props: true,
				    },
				    {
				      path: '/schedule/print/report/:dateFrom/:dateTo/:groupcodeId',
				      name: 'print-schedule-report',
				      component: PrintScheduleReport,
				      props: true,
				    },
				    {
				      path: '/acctbal/print/report/:acctId/:dateTo',
				      name: 'print-acctbal-report',
				      component: PrintAcctBalReport,
				      props: true,
				    },
				    {
				      path: '/report/print/stock/:dateTo/:itemId',
				      name: 'print-stock-report',
				      component: PrintStockReport,
				      props: true,
				    },
				    {
				      path: '/sales/invoice/:id',
				      name: 'print-sales',
				      component: PrintSales,
				      props: true,
				    },
				    {
				      path: '/purchase/invoice/:id',
				      name: 'print-purchase',
				      component: PrintPurchase,
				      props: true,
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
				      		path:'company',
				      		name: 'add-company',
				      		component: AddCompany,
				      	},
				      	{
				      		path:'company',
				      		name: 'view-company',
				      		component: ViewCompany,
				      	},
				      	{
				      		path:'finyear',
				      		name: 'add-finyear',
				      		component: AddFinYear,
				      	},
				      	{
				      		path:'finyear',
				      		name: 'view-finyear',
				      		component: ViewFinYear,
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
				      		path:'purchase',
				      		name: 'add-purchase',
				      		component: AddPurchase,
				      	},
				      	{
				      		path:'purchase',
				      		name: 'view-purchase',
				      		component: ViewPurchase,
				      	},
				      	{
				      		path:'purchase',
				      		name: 'edit-purchase',
				      		component: EditPurchase,
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
				      		path:'report/trailbal',
				      		name: 'report-trailbal',
				      		component: ReportTrialbal,
				      	},
				      	{
				      		path:'report/balsheet',
				      		name: 'report-balsheet',
				      		component: ReportBalsheet,
				      	},
				      	{
				      		path:'report/purchase',
				      		name: 'report-purchase',
				      		component: ReportPurchase,
				      	},
				      	{
				      		path:'report/sales',
				      		name: 'report-sales',
				      		component: ReportSales,
				      	},
				      	{
				      		path:'report/ledger',
				      		name: 'report-ledger',
				      		component: ReportLedger,
				      	},
				      	{
				      		path:'report/schedule',
				      		name: 'report-schedule',
				      		component: ReportSchedule,
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
				      		path:'enquiry/stock',
				      		name: 'enquiry-stock',
				      		component: Stock,
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
				      path: '/web-admin/financial-year',
				      name: 'financial-year',
				      component: FinancialYear,
				    },
				    {
				      path: '/logout',
				      name: 'logout',
				      component: Logout,
				    },

				    
				]
});

export default router;