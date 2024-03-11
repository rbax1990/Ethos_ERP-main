document.addEventListener('DOMContentLoaded', () => {
  const navbarContainer = document.getElementById('navbar');
  navbarContainer.innerHTML = `
    <div class="navbar">
      <div class="navbar-info"></div>
      <div class="navbar-info"></div>
      <a class="button-btn" href="/Ethos_ERP-main/dashboard/index.php">Dashboard</a>
      <a class="button-btn" href="/Ethos_ERP-main/dashboard/index.php">Dashboard</a>
      
      <div class="dropdown">
        <button class="dropdown-btn">Project Mgmt</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/project_mgmt/scopeControl.php">Scope Control</a>
        </div>
      </div>
  
      <div class="dropdown">
        <button class="dropdown-btn">Purchasing</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/purchasing/itemMaster.php">Item Master</a>
          <a href="/Ethos_ERP-main/purchasing/itemMaster.php">Item Master</a>
          <a href="/Ethos_ERP-main/purchasing/reqs.php">Requisitions</a>       
          <a href="/Ethos_ERP-main/purchasing/purchaseOrders.php">Purchase Orders</a>
          <a href="/Ethos_ERP-main/purchasing/rentals.php">Rentals</a>
          <a href="/Ethos_ERP-main/purchasing/kits.php">Kits</a>
        </div>
      </div>
  
      <div class="dropdown">
        <button class="dropdown-btn">Finance</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/finance/GeneralLedger.php">General Ledger</a>       
          <a href="/Ethos_ERP-main/finance/Forecasting.php">Forecasting</a>
          <a href="/Ethos_ERP-main/finance/Accounting.php">Accounting</a>
          <a href="/Ethos_ERP-main/finance/invoicing.html">Invoicing</a>
        </div>
      </div>

      <div class="dropdown">
        <button class="dropdown-btn">Fabrication</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/fabrication/WorkPackages.php">Work Packages</a>   
          <a href="/Ethos_ERP-main/fabrication/Quality.php">Quality Control</a>
          <a href="/Ethos_ERP-main/fabrication/Inventory.php">Inventory Mgmt</a>
          <a href="/Ethos_ERP-main/fabrication/Production.php">Production Tracking</a>
          <a href="/Ethos_ERP-main/fabrication/boms.php">BOM's</a>
        </div>
      </div>
    
      <div class="dropdown">
        <button class="dropdown-btn">HR</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/hr/employeeSetup.html">Employee Setup</a>       
        </div>
      </div>
  
      <div class="dropdown">
        <button class="dropdown-btn">Admin</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/admin/profiles.php">Profiles</a>
          <a href="/Ethos_ERP-main/admin/preferences.php">Preferences</a>      
        </div>
      </div>
  
      <div class="dropdown">
        <button class="dropdown-btn">Help</button>
        <div class="dropdown-content">
          <a href="/Ethos_ERP-main/help/Help.php">Help</a>       
        </div>
      </div>
    </div>
  
    </div>
    <!-- Company Logo in the upper right-hand corner -->
    <div class="company-logo">
      <img src="/public/images/Ethos_Mech_Logo_Small.png" alt="Ethos Mechanical Logo">
    </div>


  `;
});



