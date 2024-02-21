
// CONTEXT MENUS - ITEM MASTER.



// itemMaster MANAGEMENT FUNCTIONS IN NODE.JS/EXPRESS.

// 1. Add itemMaster Item:
// File: routes/itemMaster.js
const express = require('express');
const itemMasterItem = require('../models/itemmaster'); // Adjust path as necessary
const router = express.Router();

// POST /itemMaster/add
router.post('/add', async (req, res) => {
  try {
    const itemDetails = req.body;
    const newItem = await itemMasterItem.create(itemDetails);
    return res.status(201).json(newItem);
  } catch (error) {
    return res.status(400).json({ error: error.message });
  }
});

// 2. Update itemMaster Item:
// PUT /itemMaster/update/:itemId
router.put('/update/:itemId', async (req, res) => {
    try {
      const { itemId } = req.params;
      const updatedDetails = req.body;
      const item = await itemMasterItem.findByPk(itemId);
      if (!item) {
        return res.status(404).json({ error: 'Item not found' });
      }
      const updatedItem = await item.update(updatedDetails);
      return res.json(updatedItem);
    } catch (error) {
      return res.status(400).json({ error: error.message });
    }
  });

// 3. Delete itemMaster Item
// DELETE /itemMaster/delete/:itemId
router.delete('/delete/:itemId', async (req, res) => {
    try {
      const { itemId } = req.params;
      const item = await itemMasterItem.findByPk(itemId);
      if (!item) {
        return res.status(404).json({ error: 'Item not found' });
      }
      await item.destroy();
      return res.json({ message: 'Item deleted successfully' });
    } catch (error) {
      return res.status(400).json({ error: error.message });
    }
  });

// 4. Get itemMaster List
// GET /itemMaster/list
router.get('/list', async (req, res) => {
    try {
      const filterParams = req.query;
      const items = await itemMasterItem.findAll({
        where: filterParams,
      });
      return res.json(items);
    } catch (error) {
      return res.status(400).json({ error: error.message });
    }
  });



              // PURCHASE ORDER PROCESSING FUNCTIONS IN NODE.JS/EXPRESS

  // File: models/Order.js
const { Model, DataTypes } = require('sequelize');
const sequelize = require('../config/database'); // Adjust as per your setup

class Order extends Model {}

Order.init({
  orderName: DataTypes.STRING,
  vendorId: DataTypes.INTEGER,
  startDate: DataTypes.DATE,
  endDate: DataTypes.DATE,
  budget: DataTypes.DECIMAL(10, 2),
  status: DataTypes.STRING,
  // Add additional fields as necessary (perhpas a Project Manager field?)
}, { sequelize, modelName: 'Order' });

module.exports = Order;

// 1. Create Order
// File: routes/order.js
const express = require('express');
const { Order } = require('../models'); // Assuming your Sequelize models are exported from a /models directory
const orderRouter = express.Router();

// POST /orders/create - Create a new order
router.post('/create', async (req, res) => {
  try {
    const { orderName, vendorId, startDate, endDate, budget, projectManager } = req.body;
    const newOrder = await Order.create({
      orderName,
      vendorId,
      startDate,
      endDate,
      budget,
      projectManager,
      status: 'Pending' // Assuming new orders start with a 'Pending' status
    });
    res.status(201).json(newOrder);
  } catch (error) {
    console.error('Order creation failed:', error);
    res.status(500).json({ message: 'Failed to create order', error: error.message });
  }
});

//2. Update Order Status
// PUT /orders/update/:orderId - Update order status
router.put('/update/:orderId', async (req, res) => {
    try {
      const { orderId } = req.params;
      const { status } = req.body;
      const order = await Order.findByPk(orderId);
      if (!order) {
        return res.status(404).json({ message: 'Order not found' });
      }
      await order.update({ status });
      res.json({ message: 'Order status updated successfully', order });
    } catch (error) {
      console.error('Failed to update order status:', error);
      res.status(500).json({ message: 'Failed to update order status', error: error.message });
    }
  });

//3. Get Order Details
// GET /orders/:orderId - Get order details
router.get('/:orderId', async (req, res) => {
    try {
      const { orderId } = req.params;
      const order = await Order.findByPk(orderId);
      if (!order) {
        return res.status(404).json({ message: 'Order not found' });
      }
      res.json(order);
    } catch (error) {
      console.error('Failed to retrieve order details:', error);
      res.status(500).json({ message: 'Failed to retrieve order details', error: error.message });
    }
  });

//4. List Orders by Vendor
// GET /orders/by-vendor/:vendorId - List orders for a specific vendor
router.get('/by-vendor/:vendorId', async (req, res) => {
    try {
      const { vendorId } = req.params;
      const orders = await Order.findAll({
        where: { vendorId }
      });
      if(orders.length === 0) {
        return res.status(404).json({ message: 'No orders found for this vendor' });
      }
      res.json(orders);
    } catch (error) {
      console.error('Failed to list orders for vendor:', error);
      res.status(500).json({ message: 'Failed to list orders', error: error.message });
    }
  });


                // CLIENT MANAGEMENT FUNCTIONS IN NODE.JS/EXPRESS

// File: models/Client.js
const { Model, DataTypes } = require('sequelize');
const sequelize = require('../config/database');

class Client extends Model {}

Client.init({
    name: DataTypes.STRING,
    email: DataTypes.STRING,
    // Add other relevant fields
}, { sequelize, modelName: 'Client' });

module.exports = Client;

// 1. Add Client
// Assuming Express Router setup as router
router.post('/clients/add', async (req, res) => {
    try {
      const client = await Client.create(req.body);
      res.status(201).json(client);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  });

// 2. Update Client
router.put('/clients/update/:clientId', async (req, res) => {
    try {
      const client = await Client.findByPk(req.params.clientId);
      if (!client) {
        return res.status(404).json({ message: 'Client not found' });
      }
      await client.update(req.body);
      res.json(client);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  });

// 3. Delete Client
router.delete('/clients/delete/:clientId', async (req, res) => {
    try {
      const client = await Client.findByPk(req.params.clientId);
      if (!client) {
        return res.status(404).json({ message: 'Client not found' });
      }
      await client.destroy();
      res.json({ message: 'Client deleted successfully' });
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });

// 4. Get Client List
router.get('/clients', async (req, res) => {
    try {
      const clients = await Client.findAll();
      res.json(clients);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });


                // VENDOR MANAGEMENT FUNCTIONS IN NODE.JS/EXPRESS

// File: models/Vendor.js
const { Model, DataTypes } = require('sequelize');
const sequelize = require('../config/database'); // Adjust this path as per your project structure

class Vendor extends Model {}

Vendor.init({
  name: DataTypes.STRING,
  service: DataTypes.STRING,
  // Add other vendor-specific fields as necessary
}, { sequelize, modelName: 'Vendor' });

module.exports = Vendor;

// 1. Add Vendor
router.post('/vendors/add', async (req, res) => {
    try {
      const vendor = await Vendor.create(req.body);
      res.status(201).json(vendor);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  });

// 2. Update Vendor
router.put('/vendors/update/:vendorId', async (req, res) => {
    try {
      const vendor = await Vendor.findByPk(req.params.vendorId);
      if (!vendor) {
        return res.status(404).json({ message: 'Vendor not found' });
      }
      await vendor.update(req.body);
      res.json(vendor);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  });

// 3. Delete Vendor
router.delete('/vendors/delete/:vendorId', async (req, res) => {
    try {
      const vendor = await Vendor.findByPk(req.params.vendorId);
      if (!vendor) {
        return res.status(404).json({ message: 'Vendor not found' });
      }
      await vendor.destroy();
      res.json({ message: 'Vendor deleted successfully' });
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });

// 4. Get Vendor List
router.get('/vendors', async (req, res) => {
    try {
      const vendors = await Vendor.findAll();
      res.json(vendors);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });


                  // FABRICATION MANAGEMENT FUNCTIONS IN NODE.JS/EXPRESS

// File: models/FabricationPlan.js
const { Model, DataTypes } = require('sequelize');
const sequelize = require('../config/database');

class FabricationPlan extends Model {}

FabricationPlan.init({
  planName: DataTypes.STRING,
  startDate: DataTypes.DATE,
  endDate: DataTypes.DATE,
  budget: DataTypes.DECIMAL(10, 2),
  status: DataTypes.STRING,
  projectManagerId: DataTypes.INTEGER, // Assuming there's a relation to a ProjectManager model
}, { sequelize, modelName: 'FabricationPlan' });

module.exports = FabricationPlan;

// 1. Schedule Fabrication
// File: routes/fabricationRoutes.js
const express = require('express');
const { FabricationPlan } = require('../models');
const fabricationRouter = express.Router();

// POST /fabrication/schedule - Schedule a new fabrication plan
router.post('/schedule', async (req, res) => {
  try {
    const fabricationDetails = req.body;
    const newPlan = await FabricationPlan.create(fabricationDetails);
    res.status(201).json(newPlan);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

//2. Update Fabrication Schedule
// PUT /fabrication/update/:planId - Update an existing fabrication plan
router.put('/update/:planId', async (req, res) => {
    try {
      const { planId } = req.params;
      const updatedDetails = req.body;
      const plan = await FabricationPlan.findByPk(planId);
      if (!plan) {
        return res.status(404).json({ message: 'Fabrication plan not found' });
      }
      const updatedPlan = await plan.update(updatedDetails);
      res.json(updatedPlan);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  });

// 3. Cancel Fabrication
// DELETE /fabrication/cancel/:planId - Cancel a scheduled fabrication plan
router.delete('/cancel/:planId', async (req, res) => {
    try {
      const { planId } = req.params;
      const plan = await FabricationPlan.findByPk(planId);
      if (!plan) {
        return res.status(404).json({ message: 'Fabrication plan not found' });
      }
      await plan.destroy();
      res.json({ message: 'Fabrication plan cancelled successfully' });
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });

// 4. Get Fabrication Schedule
// GET /fabrication/schedule - Retrieve fabrication schedules, optionally filtered
router.get('/schedule', async (req, res) => {
    try {
      const filterParams = req.query;
      const plans = await FabricationPlan.findAll({
        where: filterParams,
      });
      res.json(plans);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });


                  // QUALITY CONTROL FUNCTIONS IN NODE.JS/EXPRESS

// File: models/QualityCheck.js
const { Model, DataTypes } = require('sequelize');
const sequelize = require('../config/database');

class QualityCheck extends Model {}

QualityCheck.init({
  batchId: DataTypes.INTEGER,
  checkDate: DataTypes.DATE,
  status: DataTypes.STRING, // e.g., 'Passed', 'Failed'
  comments: DataTypes.TEXT,
  // Consider including additional fields as necessary, such as checkType, inspectorId, etc.
}, { sequelize, modelName: 'QualityCheck' });

module.exports = QualityCheck;

// 1. Record Quality Check
// File: routes/qualityControlRoutes.js
const express = require('express');
const { QualityCheck } = require('../models');
const qualityRouter = express.Router();

// POST /quality-checks/record - Record a new quality check
router.post('/record', async (req, res) => {
  try {
    const checkDetails = req.body;
    const newCheck = await QualityCheck.create(checkDetails);
    res.status(201).json(newCheck);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// 2. Update Qaulity Check
// PUT /quality-checks/update/:checkId - Update details of a recorded quality check
router.put('/update/:checkId', async (req, res) => {
    try {
      const { checkId } = req.params;
      const updatedDetails = req.body;
      const check = await QualityCheck.findByPk(checkId);
      if (!check) {
        return res.status(404).json({ message: 'Quality check not found' });
      }
      const updatedCheck = await check.update(updatedDetails);
      res.json(updatedCheck);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  });

// 3. List Quality Checks by Batch
// GET /quality-checks/by-batch/:batchId - List all quality checks for a specific batch
router.get('/by-batch/:batchId', async (req, res) => {
    try {
      const { batchId } = req.params;
      const checks = await QualityCheck.findAll({
        where: { batchId }
      });
      res.json(checks);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });

// 4. Get Quality Check Failures
// GET /quality-checks/failures - Retrieve quality checks that resulted in failures, optionally filtered
router.get('/failures', async (req, res) => {
    try {
      const filterParams = req.query;
      const failures = await QualityCheck.findAll({
        where: { ...filterParams, status: 'Failed' }
      });
      res.json(failures);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });


                    // FINANCE AND ACCOUNTING FUNCTIONS IN NODE.JS/EXPRESS

// File: models/FinancialTransaction.js
const { Model, DataTypes } = require('sequelize');
const sequelize = require('../config/database');

class FinancialTransaction extends Model {}

FinancialTransaction.init({
  transactionType: DataTypes.STRING, // e.g., 'Income', 'Expense'
  amount: DataTypes.DECIMAL(10, 2),
  date: DataTypes.DATE,
  description: DataTypes.TEXT,
  // Add other relevant fields as necessary
}, { sequelize, modelName: 'FinancialTransaction' });

module.exports = FinancialTransaction;


// File: models/Budget.js
const { Model, DataTypes } = require('sequelize');
const sequelize = require('../config/database');

class Budget extends Model {}

Budget.init({
  category: DataTypes.STRING,
  budgetedAmount: DataTypes.DECIMAL(10, 2),
  startDate: DataTypes.DATE,
  endDate: DataTypes.DATE,
  // Optionally, relate to specific projects or departments
}, { sequelize, modelName: 'Budget' });

module.exports = Budget;

// 1. Record Transaction
// File: routes/financeRoutes.js
const express = require('express');
const { FinancialTransaction } = require('../models');
const financeialTransactionRouter = express.Router();

// POST /finance/transactions/record - Record a new financial transaction
router.post('/transactions/record', async (req, res) => {
  try {
    const transactionDetails = req.body;
    const newTransaction = await FinancialTransaction.create(transactionDetails);
    res.status(201).json(newTransaction);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// 2. Update Transaction
// PUT /finance/transactions/update/:transactionId - Update a financial transaction
router.put('/transactions/update/:transactionId', async (req, res) => {
    try {
      const { transactionId } = req.params;
      const updatedDetails = req.body;
      const transaction = await FinancialTransaction.findByPk(transactionId);
      if (!transaction) {
        return res.status(404).json({ message: 'Transaction not found' });
      }
      const updatedTransaction = await transaction.update(updatedDetails);
      res.json(updatedTransaction);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  });

// 3. Generate Financial Report
// GET /finance/reports/generate
router.get('/reports/generate', async (req, res) => {
    try {
      const { startDate, endDate } = req.query;
      const transactions = await FinancialTransaction.findAll({
        where: {
          date: {
            [Sequelize.Op.between]: [new Date(startDate), new Date(endDate)]
          }
        }
      });
      // Process transactions to generate report details (e.g., totals by type)
      const report = generateReportFromTransactions(transactions); // Assume this is a custom function you'll implement
      res.json(report);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });

// 4. Calculate Budget Variance
// GET /finance/reports/budget-variance
router.get('/reports/budget-variance', async (req, res) => {
    try {
      const { budgetId } = req.query;
      const budget = await Budget.findByPk(budgetId);
      if (!budget) {
        return res.status(404).json({ message: 'Budget not found' });
      }
      
      const transactions = await FinancialTransaction.findAll({
        where: {
          category: budget.category, // Assuming transactions are categorized similarly
          date: {
            [Sequelize.Op.between]: [budget.startDate, budget.endDate]
          }
        }
      });
      
      const actualSpending = transactions.reduce((total, transaction) => total + parseFloat(transaction.amount), 0);
      const variance = parseFloat(budget.budgetedAmount) - actualSpending;
  
      res.json({
        budgetId: budget.id,
        budgetedAmount: budget.budgetedAmount,
        actualSpending: actualSpending.toFixed(2),
        variance: variance.toFixed(2)
      });
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });


                    // HUMAN RESOURCES FUNCTIONS IN NODE.JS/EXPRESS

// File: models/Employee.js
const { Model, DataTypes } = require('sequelize');
const sequelize = require('../config/database');

class Employee extends Model {}

Employee.init({
  name: DataTypes.STRING,
  position: DataTypes.STRING,
  department: DataTypes.STRING,
  email: DataTypes.STRING,
  // Consider including additional fields as necessary, such as hireDate, status, etc.
}, { sequelize, modelName: 'Employee' });

module.exports = Employee;

// 1. Add Employee
// File: routes/hrRoutes.js
const express = require('express');
const { Employee } = require('../models');
const employeeRouter = express.Router();

// POST /hr/employees/add - Add a new employee
router.post('/employees/add', async (req, res) => {
  try {
    const employeeDetails = req.body;
    const newEmployee = await Employee.create(employeeDetails);
    res.status(201).json(newEmployee);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// 2. Update Employee
// PUT /hr/employees/update/:employeeId - Update an employee's details
router.put('/employees/update/:employeeId', async (req, res) => {
    try {
      const { employeeId } = req.params;
      const updatedDetails = req.body;
      const employee = await Employee.findByPk(employeeId);
      if (!employee) {
        return res.status(404).json({ message: 'Employee not found' });
      }
      const updatedEmployee = await employee.update(updatedDetails);
      res.json(updatedEmployee);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  });

// 3. Delete Employee
// DELETE /hr/employees/delete/:employeeId - Remove an employee from the system
router.delete('/employees/delete/:employeeId', async (req, res) => {
    try {
      const { employeeId } = req.params;
      const employee = await Employee.findByPk(employeeId);
      if (!employee) {
        return res.status(404).json({ message: 'Employee not found' });
      }
      await employee.destroy();
      res.json({ message: 'Employee deleted successfully' });
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });

// 4. List Employee (with optional filtering)
// GET /hr/employees - Retrieve a list of employees, optionally filtered
router.get('/employees', async (req, res) => {
    try {
      const filterParams = req.query;
      const employees = await Employee.findAll({
        where: filterParams,
      });
      res.json(employees);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });


                    // PROJECT MANAGEMENT FUNCTIONS IN NODE.JS/EXPRESS

// File: models/Project.js
const { Model, DataTypes } = require('sequelize');
const sequelize = require('../config/database'); // Adjust as per your project setup

class Project extends Model {}

Project.init({
  projectName: DataTypes.STRING,
  startDate: DataTypes.DATE,
  endDate: DataTypes.DATE,
  budget: DataTypes.DECIMAL(10, 2),
  status: DataTypes.STRING, // e.g., 'Active', 'Completed', 'On Hold', 'Closed'
  projectManagerId: DataTypes.INTEGER, // Assuming a foreign key to an Employee model
  forecastEndDate: DataTypes.DATE, // Additional field for forecasted end date
  forecastBudget: DataTypes.DECIMAL(10, 2), // Additional field for forecasted budget
// Consider adding other fields relevant to forecasting or project management
}, { sequelize, modelName: 'Project' });

module.exports = Project;

// 1. Create Project
// File: routes/projectRoutes.js
const express = require('express');
const { Project } = require('../models');
const projectRouter = express.Router();

// POST /projects/create - Create a new project
router.post('/create', async (req, res) => {
  try {
    const projectDetails = req.body;
    const newProject = await Project.create(projectDetails);
    res.status(201).json(newProject);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// 2. Close Project
// PUT /projects/:projectId/close - Close a project
router.put('/:projectId/close', async (req, res) => {
    try {
      const { projectId } = req.params;
      const project = await Project.findByPk(projectId);
      if (!project) {
        return res.status(404).json({ message: 'Project not found' });
      }
      await project.update({ status: 'Closed' });
      res.json({ message: 'Project closed successfully' });
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  });


// 3. Edit/Forecast
// PUT /projects/:projectId/edit-forecast - Edit project details or forecast
router.put('/:projectId/edit-forecast', async (req, res) => {
    try {
      const { projectId } = req.params;
      const forecastDetails = req.body; // This could include budget, endDate, etc.
      const project = await Project.findByPk(projectId);
      if (!project) {
        return res.status(404).json({ message: 'Project not found' });
      }
      await project.update(forecastDetails);
      res.json({ message: 'Project forecast updated successfully', project });
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  });

                      // EMPLOYEE LOOKUP FUNCTIONS IN NODE.JS/EXPRESS
const express = require('express');
const mysql = require('mysql');

const app = express();
const port = 3030;

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'username',
  password: 'password',
  database: 'your_database'
});

// Endpoint for employee lookup by name
app.get('/api/employees/:name', (req, res) => {
  const name = req.params.name;
  const query = `SELECT * FROM Employees WHERE CONCAT(first_name, ' ', last_name) LIKE '%${name}%'`;
  connection.query(query, (error, results) => {
    if (error) {
      console.error('Error:', error);
      res.status(500).json({ error: 'Internal Server Error' });
    } else {
      res.status(200).json(results);
    }
  });
});

app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
