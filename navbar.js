document.addEventListener('DOMContentLoaded', () => {
  const navbarContainer = document.getElementById('navbar');
  navbarContainer.innerHTML = `
    <div class="navbar">
      <div class="navbar-info"></div>
      <div class="navbar-info"></div>
      <<a class="button-btn" href="/Ethos_ERP-main/dashboard/index.html">Dashboard</a>
      
      <div class="dropdown">
        <button class="dropdown-btn">Project Mgmt</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/project_mgmt/scopeControl.html">Scope Control</a>
        </div>
      </div>
  
      <div class="dropdown">
        <button class="dropdown-btn">Purchasing</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/purchasing/reqs.html">Requisitions</a>       
          <a href="/Ethos_ERP-main/purchasing/purchaseOrders.html">Purchase Orders</a>
          <a href="/Ethos_ERP-main/purchasing/itemMaster.html">Item Master</a>
          <a href="/Ethos_ERP-main/purchasing/rentals.html">Rentals</a>
          <a href="/Ethos_ERP-main/purchasing/kits.html">Kits</a>
        </div>
      </div>
  
      <div class="dropdown">
        <button class="dropdown-btn">Finance</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/finance/GeneralLedger.html">General Ledger</a>       
          <a href="/Ethos_ERP-main/finance/Forecasting.html">Forecasting</a>
          <a href="/Ethos_ERP-main/finance/Accounting.html">Accounting</a>
          <a href="/Ethos_ERP-main/finance/Invoicing.html">Invoicing</a>
        </div>
      </div>

      <div class="dropdown">
        <button class="dropdown-btn">Fabrication</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/fabrication/WorkPackages.html">Work Packages</a>   
          <a href="/Ethos_ERP-main/fabrication/Quality.html">Quality Control</a>
          <a href="/Ethos_ERP-main/fabrication/Inventory.html">Inventory Mgmt</a>
          <a href="/Ethos_ERP-main/fabrication/Production.html">Production Tracking</a>
          <a href="/Ethos_ERP-main/fabrication/boms.html">BOM's</a>
        </div>
      </div>
    
      <div class="dropdown">
        <button class="dropdown-btn">HR</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/hr/employee-setup.html">Employee Setup</a>       
        </div>
      </div>
  
      <div class="dropdown">
        <button class="dropdown-btn">Admin</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/admin/profiles.html">Profiles</a>
          <a href="/Ethos_ERP-main/admin/preferences.html">Preferences</a>      
        </div>
      </div>
  
      <div class="dropdown">
        <button class="dropdown-btn">Help</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/help/Help.html">Help</a>       
        </div>
      </div>
    </div>
  `;
});
