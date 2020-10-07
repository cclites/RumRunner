#### INTRODUCTION

Rum Runner is a package for quickly generating boilerplate by harnessing Artisan and some quick and dirty string manipulation.

One of the requirements is to add a placeholder to app.js where you want to register components. 

************************************************

#### USE:

**Command File Name:** app.Console.Commands.Factory

**Command:**  factory:build {file} {directory}

**Example Use:** php artisan factory:build Invoice Read

**Requirements:** A placeholder must be placed in the app.js file.

**Placeholder:** //------- CONTENT -------//
    
************************************************

#### FUNCTIONS:

**addVueComponent(useListView)** - Adds one of two types of vue components. One is a list view component for viewing collections with table and internal variables all pre-populated. One is an component with just place holders.

**registerComponent(useListView)** - Registers a vue component by adding an entry to app.js. There are two types of vue registrations. One is for list view, and one is just a regular component.

**addRoute(method, action)** - Adds a route given a method and action.

**addController** - Add a controller class

**addTableMigration** - Add a migration

**addBlade** - Add a blade component

**addClass** - Add a model class

**addRequest(update)** - Adds a request object, either to access records, or update records.

**generateRoutes** - Generates routes for all CRUD operations

**generateSingleResponsibilityRoutes** - Generates single responsibility routes for single responsibility controllers.

**generateSingleResponsibilityControllers** - Generates single responsibility controllers.

**toString** - displays a list of globals in the console.

************************************************

TODO:: Add counter and pagination components to js/components. When list view is generated, copy those files over to the project.

TODO:: Add sample flow

TODO:: Move BaseCommand functions into service class

TODO:: Restore report specific components

TODO:: Add testing

Updated: 5/30/2020
