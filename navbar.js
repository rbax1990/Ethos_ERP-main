document.addEventListener('DOMContentLoaded', () => {
  const navbarContainer = document.getElementById('navbar'); // Make sure this ID matches the placeholder in your HTML
  navbarContainer.innerHTML = `
    <div class="navbar">
      <div class="navbar-info"></div>

      <div class="navbar-info"></div>
      <a class="button-btn" href="index.html">Dashboard</a>
      
      <div class="dropdown">
        <button class="dropdown-btn">Project Mgmt</button>
        <div class="dropdown-content">
          <a href="scopeCtrl.html">Scope Control</a>
        </div>
      </div>
  
      <div class="dropdown">
        <button class="dropdown-btn">Purchasing</button>
        <div class="dropdown-content">
          <a href="reqs.html">Requisitions</a>       
          <a href="pos.html">Purchase Orders</a>
          <a href="itemMaster.html">Item Master</a>
          <a href="rentals.html">Rentals</a>
          <a href="kits.html">Kits</a>
        </div>
      </div>
  
      <div class="dropdown">
        <button class="dropdown-btn">Finance</button>
        <div class="dropdown-content">
          <a href="#GeneralLedger.html">General Ledger</a>       
          <a href="#Forecasting.html">Forecasting</a>
          <a href="#Accounting.html">Accounting</a>
          <a href="#Invoicing.html">Invoicing</a>
        </div>
      </div>

      <div class="dropdown">
      <button class="dropdown-btn">Fabrication</button>
      <div class="dropdown-content">
        <a href="#WorkPackages.html">Work Packages</a>   
        <a href="#Quality.html">Quality Control</a>
        <a href="#Inventory.html">Inventory Mgmt</a>
        <a href="#Production.html">Production Tracking</a>
        <a href="boms.html">BOM's</a>
 
      </div>
    </div>
    
      <div class="dropdown">
        <button class="dropdown-btn">HR</button>
        <div class="dropdown-content">
          <a href="#employee-setup.html">Employee Setup</a>       
        </div>
      </div>
  
      <div class="dropdown">
        <button class="dropdown-btn">Admin</button>
        <div class="dropdown-content">
          <a href="#profiles.html">Profiles</a>
          <a href="#preferences.html">Preferences</a>      
        </div>
      </div>
  
      <div class="dropdown">
        <button class="dropdown-btn">Help</button>
        <div class="dropdown-content">
          <a href="#Help">Help</a>       
        </div>
      </div>
    </div>
  `;
});
