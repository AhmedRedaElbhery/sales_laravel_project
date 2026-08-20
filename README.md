# Sales Management System

A web-based Sales Management System built with **PHP, Laravel, and MySQL**.

The system is designed to manage the main operations of a sales and inventory business, including customers, suppliers, products, invoices, returns, accounts, treasuries, and inventory movements.

The project was developed with a focus on clean backend architecture, business logic organization, database relationships, validation, and maintainable Laravel code.

---

## About The Project

The Sales Management System provides a centralized platform for managing daily business operations.

It handles different parts of the business such as:

-   Customer management
-   Supplier management
-   Product and item management
-   Sales invoices
-   Purchase invoices
-   Sales returns
-   Purchase returns
-   Inventory and stock movements
-   Customer accounts
-   Supplier accounts
-   Treasury management
-   Treasury branches
-   Delegate management
-   Account balances
-   Invoice printing
-   User management
-   Arabic and RTL interface

The system also contains business rules for handling balances, transactions, inventory quantities, invoice approval, and related accounting operations.

---

## Main Features

### Customers

The system provides customer management functionality including:

-   Create customers
-   Edit customer information
-   Activate and deactivate customers
-   Manage customer opening balances
-   Manage customer accounts
-   Track current balances
-   Associate customers with accounting records

### Suppliers

Supplier management includes:

-   Create suppliers
-   Edit suppliers
-   Activate and deactivate suppliers
-   Manage supplier opening balances
-   Manage supplier accounts
-   Track supplier balances
-   Associate suppliers with accounting records

### Inventory Management

The system manages products and inventory through:

-   Item management
-   Item quantities
-   Main and retail units
-   Unit conversions
-   Stock movements
-   Purchase inventory operations
-   Sales inventory operations
-   Return operations
-   Batch-related inventory operations

The system supports different units for products and handles conversions between Main and retail units.

### Sales Invoices

Sales operations include:

-   Creating sales invoices
-   Adding invoice items
-   Calculating quantities and prices
-   Applying discounts
-   Managing invoice totals
-   Updating inventory
-   Updating customer accounts
-   Processing invoice approval
-   Printing invoices

### Purchase Invoices

Purchase operations include:

-   Creating purchase invoices
-   Adding purchased items
-   Managing supplier information
-   Updating inventory
-   Managing purchase prices
-   Updating supplier accounts
-   Processing invoice approval

### Returns

The system supports return operations for both sales and purchases.

Returns can affect:

-   Inventory quantities
-   Customer accounts
-   Supplier accounts
-   Invoice information
-   Stock movements

### Treasury Management

Treasury functionality includes:

-   Creating treasuries
-   Master treasury management
-   Treasury activation
-   Treasury branches
-   Treasury delivery relationships
-   Treasury transactions

The system prevents multiple master treasuries from being created for the same company.

### Accounting

The system includes accounting-related functionality for:

-   Customer accounts
-   Supplier accounts
-   Treasury accounts
-   Opening balances
-   Current balances
-   Debit and credit balances
-   Master account relationships
-   Account types

---

## Architecture

The project follows the Laravel MVC architecture and uses Laravel features to separate application responsibilities.

### Models

Eloquent models are used to communicate with the database and represent the application's main entities.

Examples include:

-   Customers
-   Suppliers
-   Items
-   Accounts
-   Treasuries
-   Invoices
-   Invoice details
-   Inventory movements

### Controllers

Controllers handle HTTP requests and coordinate the application flow.

Business logic is gradually being separated from controllers into dedicated services where appropriate.

### Form Requests

Laravel Form Request classes are used for validation.

This keeps validation rules separated from controller logic and helps keep controllers cleaner.

### Services

Service classes are used to move reusable or complex business logic away from controllers.

This helps keep controllers smaller and easier to maintain.

### Enums

PHP Enums are used for fixed business values instead of using unexplained numeric values throughout the application.

Examples include:

-   Account types
-   Balance statuses
-   Order types
-   Bill types

For example:

```php
AccountTypes::Customer->value
```
