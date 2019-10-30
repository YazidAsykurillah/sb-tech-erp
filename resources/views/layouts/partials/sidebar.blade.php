<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        @if(Auth::user()->profile_picture != NULL)
          <?php $user_profile = \Auth::user()->profile_picture; ?>
          {!! Html::image('img/user/thumb_'.$user_profile, 'User Image', ['class'=>'img-circle']) !!}
        @else
          {!! Html::image('img/admin-lte/user2-160x160.jpg', 'User Image', ['class'=>'img-circle']) !!}
        @endif

      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i>Online</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">NAVIGATION</li>
      <li {{{ (Request::is('home') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('home') }}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      @if(\Auth::user()->can('transfer-task'))
      <li class="treeview {{{ (Request::is('transfer-task*') ? 'active':'') }}}">
        <a href="#">
          <i class="fa fa-bookmark-o"></i>
          <span>Transfer Task</span>
        </a>
        <ul class="treeview-menu">
          @if(\Auth::user()->can('transfer-task-internal-request'))
            <li class="{{{ (Request::is('transfer-task/internal-request*') ? 'active':'') }}}"><a href="{{ URL::to('transfer-task/internal-request') }}"><i class="fa fa-circle-o"></i> Internal Request</a></li>
          @endif
          @if(\Auth::user()->can('transfer-task-invoice-vendor'))
            <li class="{{{ (Request::is('transfer-task/invoice-vendor*') ? 'active':'') }}}"><a href="{{ URL::to('transfer-task/invoice-vendor') }}"><i class="fa fa-circle-o"></i> Invoice Vendor</a></li>
          @endif
          @if(\Auth::user()->can('transfer-task-settlement'))
            <li class="{{{ (Request::is('transfer-task/settlement*') ? 'active':'') }}}"><a href="{{ URL::to('transfer-task/settlement') }}"><i class="fa fa-circle-o"></i> Settlement</a></li>
          @endif
          @if(\Auth::user()->can('transfer-task-cashbond'))
            <li class="{{{ (Request::is('transfer-task/cashbond*') ? 'active':'') }}}"><a href="{{ URL::to('transfer-task/cashbond') }}"><i class="fa fa-circle-o"></i> Cashbond</a></li>
          @endif
          <li class="{{{ (Request::is('transfer-task/payroll*') ? 'active':'') }}}">
            <a href="{{ URL::to('transfer-task/payroll') }}"><i class="fa fa-circle-o"></i> Payroll</a>
          </li>
        </ul>
      </li>
      @endif

      @if(\Auth::user()->can('tax-list'))
      <li class="treeview {{{ (Request::is('*-tax') ? 'active':'') }}}">
        <a href="#">
          <i class="fa fa-money"></i>
          <span>Tax Lists</span>
        </a>
        <ul class="treeview-menu">
          @if(\Auth::user()->can('tax-list-invoice-customer'))
            <li class="{{{ (Request::is('invoice-customer-tax*') ? 'active':'') }}}"><a href="{{ URL::to('invoice-customer-tax') }}"><i class="fa fa-circle-o"></i> Invoice Customer</a></li>
          @endif
          @if(\Auth::user()->can('tax-list-invoice-vendor'))
            <li class="{{{ (Request::is('invoice-vendor-tax*') ? 'active':'') }}}"><a href="{{ URL::to('invoice-vendor-tax') }}"><i class="fa fa-circle-o"></i> Invoice Vendor</a></li>
          @endif          
            <li class="{{{ (Request::is('comparation-invoice-tax*') ? 'active':'') }}}"><a href="{{ URL::to('comparation-invoice-tax') }}"><i class="fa fa-circle-o"></i> Comparation</a></li>
        </ul>
      </li>
      @endif

      @if(\Auth::user()->can('access-finance-statistic'))
      <li {{{ (Request::is('finance-statistic*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('finance-statistic') }}">
          <i class="fa fa-line-chart"></i> <span>Statistik Keuangan</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('access-cash-flow'))
      <li {{{ (Request::is('cash-flow*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('cash-flow') }}">
          <i class="fa fa-line-chart"></i> <span>Cash Flow</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('index-quotation-customer') && \Auth::user()->can('index-quotation-vendor'))
      <li class="treeview {{{ (Request::is('quotation*') ? 'active':'') }}}">
        <a href="#">
          <i class="fa fa-archive"></i>
          <span>Quotation</span>
        </a>
        <ul class="treeview-menu">
          
          <li class="{{{ (Request::is('quotation-customer*') ? 'active':'') }}}"><a href="{{ URL::to('quotation-customer') }}"><i class="fa fa-circle-o"></i> Quotation Customer</a></li>  
          <li class="{{{ (Request::is('quotation-vendor*') ? 'active':'') }}}"><a href="{{ url('quotation-vendor') }}"><i class="fa fa-circle-o"></i> Quotation Vendor</a></li>
        </ul>
      </li>
      @endif

      @if(\Auth::user()->can('index-purchase-request'))
      <li {{{ (Request::is('purchase-request*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('purchase-request') }}">
          <i class="fa fa-tag"></i> <span>Purchase Request</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('index-project'))
      <li {{{ (Request::is('project*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('project') }}">
          <i class="fa fa-legal"></i> <span>Project</span>
        </a>
      </li>
      @endif
      
      
      <li class="treeview {{{ (Request::is('purchase-order*') ? 'active':'') }}}">
        <a href="#">
          <i class="fa fa-bookmark-o"></i>
          <span>Purchase Order</span>
        </a>
        <ul class="treeview-menu">
          @if(\Auth::user()->can('index-purchase-order-customer') && \Auth::user()->can('index-purchase-order-vendor'))
          <li class="{{{ (Request::is('purchase-order-customer*') ? 'active':'') }}}">
            <a href="{{ URL::to('purchase-order-customer') }}"><i class="fa fa-circle-o"></i> PO Customer</a>
          </li>
          <li class="{{{ (Request::is('purchase-order-vendor*') ? 'active':'') }}}">
            <a href="{{ url('purchase-order-vendor') }}"><i class="fa fa-circle-o"></i> PO Vendor</a>
          </li>
          @elseif(\Auth::user()->can('index-purchase-order-vendor')))
          <li class="{{{ (Request::is('purchase-order-vendor*') ? 'active':'') }}}">
            <a href="{{ url('purchase-order-vendor') }}"><i class="fa fa-circle-o"></i> PO Vendor</a>
          </li>
          @endif
        </ul>
      </li>
      

      @if(\Auth::user()->can('access-delivery-order'))
      <li {{{ (Request::is('delivery-order*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('delivery-order') }}">
          <i class="fa fa-truck"></i> <span>Delivery Order</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('access-migo'))
      <li {{{ (Request::is('migo*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('migo') }}">
          <i class="fa fa-book"></i> <span>Migo</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('index-invoice-customer') && \Auth::user()->can('index-invoice-vendor'))
      <li class="treeview {{{ (Request::is('invoice*') ? 'active':'') }}}">
        <a href="#">
          <i class="fa fa-credit-card"></i>
          <span>Invoice</span>
        </a>
        <ul class="treeview-menu">
          <li {{{ (Request::is('invoice-customer*') ? 'class=active' : '') }}}><a href="{{ url('invoice-customer') }}"><i class="fa fa-circle-o"></i> Invoice Customer</a></li>
          <li {{{ (Request::is('invoice-vendor*') ? 'class=active' : '') }}}><a href="{{ url('invoice-vendor') }}"><i class="fa fa-circle-o"></i> Invoice Vendor</a></li>
        </ul>
      </li>
      @endif

      @if(\Auth::user()->can('index-internal-request'))
      <li {{{ (Request::is('internal-request*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('internal-request') }}">
          <i class="fa fa-tag"></i> <span>Internal Request</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('index-settlement'))
      <li {{{ (Request::is('settlement*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('settlement') }}">
          <i class="fa fa-retweet"></i> <span>Settlement</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('access-cash'))
      <li {{{ (Request::is('cash*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('cash') }}">
          <i class="fa fa-cube"></i> <span>Cash</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('index-bank-administration'))
      <li {{{ (Request::is('bank-administration*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('bank-administration') }}">
          <i class="fa fa-book"></i> <span>Bank Administration</span>
        </a>
      </li>
      @endif
      
      @if(\Auth::user()->can('index-bank-account'))
      <li {{{ (Request::is('bank-account*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('bank-account') }}">
          <i class="fa fa-building"></i> <span>Member Bank Accounts</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('index-customer'))
      <li {{{ (Request::is('customer*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('customer') }}">
          <i class="fa fa-briefcase"></i> <span>Customer</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('index-the-vendor'))
      <li {{{ (Request::is('the-vendor*') ? 'class=active' : '') }}} >
        <a href="{{ URL::to('the-vendor') }}">
          <i class="fa fa-child"></i> <span>The Vendor</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('index-user'))
      <li class="treeview {{{ (Request::is('user*') ? 'active':'') }}}" >
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Human Resource</span>
        </a>
        <ul class="treeview-menu">
          <li {{{ (Request::is('user/*') ? 'class=active' : '') }}}><a href="{{ url('user/') }}"><i class="fa fa-circle-o"></i>Employee</a></li>
          @if(\Auth::user()->can('access-payroll'))
          <li {{{ (Request::is('payroll/') ? 'class=active' : '') }}}><a href="{{ url('payroll/') }}"><i class="fa fa-circle-o"></i>Payroll</a></li>
          @endif
        </ul>
      </li>
      
      @endif

      
      @if(\Auth::user()->can('index-cash-bond'))
      <li {{{ (Request::is('cash-bond*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('cash-bond') }}">
          <i class="fa fa-money"></i> <span>Cash Bond</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('index-cash-bond-site'))
      <li {{{ (Request::is('cash-bond-site*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('cash-bond-site') }}">
          <i class="fa fa-money"></i> <span>Cash Bond Site</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('index-period'))
      <li {{{ (Request::is('period*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('period') }}">
          <i class="fa fa-clock-o"></i> <span>Period</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->roles->first()->code == 'SUP' || \Auth::user()->roles->first()->code == 'FIN')
      <li class="treeview {{{ (Request::is('master-data/*') ? 'class=active' : '') }}} ">
        <a href="#">
          <i class="fa fa-database"></i>
          <span>Master Data</span>
        </a>
        <ul class="treeview-menu">
          <li {{{ (Request::is('master-data/category') ? 'class=active' : '') }}}>
            <a href="{{ url('master-data/category') }}"><i class="fa fa-circle-o"></i> Category</a>
          </li>
          
          <li {{{ (Request::is('master-data/estimated-cost-margin-limit') ? 'class=active' : '') }}}>
            <a href="{{ url('master-data/estimated-cost-margin-limit') }}"><i class="fa fa-circle-o"></i> Estimated Cost Margin Limit</a>
          </li>
          <li {{{ (Request::is('master-data/accounting-expense') ? 'class=active' : '') }}}>
            <a href="{{ url('master-data/accounting-expense') }}"><i class="fa fa-circle-o"></i> Accounting Expenses</a>
          </li>
          <li {{{ (Request::is('master-data/asset-category') ? 'class=active' : '') }}}>
            <a href="{{ url('master-data/asset-category') }}"><i class="fa fa-circle-o"></i> Asset Category</a>
          </li>
          <li {{{ (Request::is('master-data/asset') ? 'class=active' : '') }}}>
            <a href="{{ url('master-data/asset') }}"><i class="fa fa-circle-o"></i> Asset</a>
          </li>
        </ul>
      </li>
      @endif

      @if(\Auth::user()->can('index-role') && \Auth::user()->can('index-permission'))
      <li class="treeview">
        <a href="#">
          <i class="fa fa-lock"></i>
          <span>Role and Permission</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('role') }}"><i class="fa fa-circle-o"></i> Role</a></li>
          <li><a href="{{ url('permission') }}"><i class="fa fa-circle-o"></i> Permission</a></li>
        </ul>
      </li>
      @endif

      <li {{{ (Request::is('templates*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('templates') }}">
          <i class="fa fa-server"></i> <span>Template</span>
        </a>
      </li>
      
      @if(\Auth::user()->can('run-maintenance'))
      <li class="treeview">
        <a href="#">
          <i class="fa fa-cogs"></i>
          <span>Maintenance</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('maintenance/db/export') }}"><i class="fa fa-circle-o"></i> DB Export</a></li>
          <li><a href="{{ url('maintenance/db/backup') }}"><i class="fa fa-circle-o"></i> DB Backup</a></li>
        </ul>
      </li>
      @endif

      @if(\Auth::user()->can('access-report'))
      <li class="treeview">
        <a href="#">
          <i class="fa fa-book"></i>
          <span>Report</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('report/ppn') }}"><i class="fa fa-circle-o"></i> PPN</a></li>
        </ul>
        <ul class="treeview-menu">
          <li>
            <a href="{{ url('report/tax-flow') }}">
              <i class="fa fa-circle-o"></i> Tax Flow
            </a>
          </li>
        </ul>
        <ul class="treeview-menu">
          <li>
            <a href="{{ url('report/cash-flow') }}">
              <i class="fa fa-circle-o"></i> Cash Flow
            </a>
          </li>
        </ul>
        <ul class="treeview-menu">
          <li><a href="{{ url('report/project') }}"><i class="fa fa-circle-o"></i> Project</a></li>
        </ul>
      </li>
      @endif

      @if(\Auth::user()->can('access-product-category'))
      <li {{{ (Request::is('product-category/*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('product-category') }}">
          <i class="fa fa-cubes"></i> <span>Product Category</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('access-product'))
      <li {{{ (Request::is('product*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('product') }}">
          <i class="fa fa-cube"></i> <span>Product</span>
        </a>
      </li>
      @endif

      @if(\Auth::user()->can('access-ets'))
      <li class="treeview">
        <a href="#">
          <i class="fa fa-book"></i>
          <span>ETS</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('ets/site') }}"><i class="fa fa-circle-o"></i> ETS Site</a></li>
        </ul>
        <ul class="treeview-menu">
          <li><a href="{{ url('ets/office') }}"><i class="fa fa-circle-o"></i> ETS Office</a></li>
        </ul>
      </li>
      @endif

      <li {{{ (Request::is('ets/my-ets') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('ets/my-ets') }}">
          <i class="fa fa-book"></i> <span>My ETS</span>
        </a>
      </li>
      @if(\Auth::user()->can('access-task'))
      <li {{{ (Request::is('task/*') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('task') }}">
          <i class="fa fa-list"></i> <span>Task</span>
        </a>
      </li>
      @endif
    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
