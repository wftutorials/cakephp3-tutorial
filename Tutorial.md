# Getting started with Cake MVC PHP framework for programmers

> Disclaimer: I am learning this framework while writing this tutorial. So expect some noob errors.

Lets get started with the Cake framework. You can check out there website 
[here](https://book.cakephp.org/3.0/en/quickstart.html). 

Composer is required to run this application. So make sure you have this installed.

# Installation

You can view the installation guidelines on their site [here](https://book.cakephp.org/3.0/en/installation.html).

> You need to have the php extension **extension=php_intl.dll** installed to continue this is very important.

To install `php_intl.dll` I ran the following command. It might be different for you. **Use the correct php versions** 
for you.

```bash 
sudo apt-get install php7.0-intl
```

[cake_fig_install_command.png]

Once all the requirements are complete you can run the `composer` command to make the app.

```bash
composer create-project --prefer-dist cakephp/app cake-tutorial
```

[Comment]
# Errors in installing

I experience errors when trying to install. For one I didnt have `php_intl.dll` installed.
That means that when I ran the `composer` command to create the app I also have to run the
`composer install` command after I installed `php_intl.dll` because the required packages were not installed.

Also in the `config/app.default.php` file was changed to `config/app.php` so that the application works.
[/Comment]

> Be sure to create development domain name in your hosts file and add a special vhost configuration if you are using
XAMPP.

Once the `composer` command is successful you will have created your app.

[cake_fig_install_complete.png]

# Hello World App

Lets create a standard hello world app. First we create a new Controller called `DashboardController.php`. We create 
this file in the `src/Controller` folder. We add the code below.

```php
<?php


namespace App\Controller;


class DashboardController extends AppController
{

    public function home(){
        echo "Hello World";
    }
}
```

In our `config/routes.php` file we add a new route to show our hello world app.

```php
 $routes->connect('/dashboard/home', ['controller' => 'Dashboard', 'action' => 'home']);
```

Thats it. You can see the **hello world** at the top in the image below. The rest of the page has an error but that's
fine.

[cake_fig_hello_world.png]

# Directory Structure

Three folders we can note the `config` folder the `src` folder and the `webroot` folder. These are the main directory
listings. In the `src` folder we have more folders that are important.

```
/config - You config files
 app.php
 bootsrap.php
 routes.php - your routing file
/src
  controler/
    AppController.php
    DashboardController.php
  Model/
  Template/
  View/
/webroot/
   css/
   font/
   image/
   js/
   index.php
```

# Routing

Our routing file is located in the `config/routes.php` we can add routes to any function in our controller.
Lets try this out. Lets create a new function in our dashboard controller called `help`.

```php
public function help(){
    $this->viewBuilder()->setLayout(false);
    echo "a help page";
}
```

[Comment]
# Disabling the layout

The ` $this->autoRender = false;` allows us to stop the **auto rendering** for controllers.
In our **hello world** example we add some errors because no layout was found this is because
the auto render looks for the layout automatically. We can disable this feature so we 
wouldn't have this error.

If you want go back and try the hello world using the code

```php
public function home(){
    $this->autoRender = false;
    echo "hello world";
}
```
[\Comment]

If we create a function in dashboard like 
```php
public function faq(){
    $this->autoRender = false;
    echo "this is the faq";
}
```

We can access this using `http://dev.cakeapp.com/dashboard/faq`. Our base domain is `dev.cakeapp.com`.
This means that we dont need to add a route in the `routes.php` file. However we can add a route
```php
$routes->connect('/dashboard/questions', ['controller' => 'Dashboard', 'action' => 'faq']);
```

Above we map the `dashboard/questions` url to the `faq` function in `dashboard`.

Routing can do alot. You can learn more [here](https://book.cakephp.org/3.0/en/development/routing.html).


# Controllers

We have already worked with controllers.Lets continue. Controllers are the **C** in **MVC**.
In our `DashboardController.php` lets create another function called `logs`;

```php
public function logs( ){
    $this->autoRender = false;
    echo "this is the logs";
}
```

We can get data from our `url` in our controller lets try that. Lets pass and id to our `logs` function.

```php
public function logs( ){
    $this->autoRender = false;
    echo "this is the logs" . $_GET['id'];
}
```

Now we navigate to `http://dev.cakeapp.com/dashboard/logs?id=3` and we will see the proper message.

We can add more variables

```php
public function logs( $id, $type ){
    $this->autoRender = false;
    echo "this is the logs" . $id . ' ' . $type;
}
```

And navigate to `http://dev.cakeapp.com/dashboard/logs/3/errors` and we will see the proper message.

We can change this up. Add the code below

```php
public function logs( $id ){
    $this->autoRender = false;
    echo "this is the logs" . $id;
}
```

Now we can navigate to `http://dev.cakeapp.com/dashboard/logs/3` and we will see the proper message.

Lets create a `private` function called `users`. When we navigate to `http://dev.cakeapp.com/dashboard/users`

```php
private function users(){
    echo "users";
}
```

we get an error. We cant use `private` functions as `url` actions. The error page is shown below.

[cake_fig_private_users.png]


## Rendering Views

We can render views in our controllers by using the `$this->render()` function.
Templates for our views are located in the `src/Template/` directory.

Lets create a view for our users. In `src/Template/Dashboard` directory create a file called `users_view.ctp`
and add the code below. 

> If the `Dashboard` folder doesnt exists create it.

```php
<?php

echo "showing users";
```

Now make sure our `DashboardController.php` has the correct function
```php
public function users(){
    $this->viewBuilder()->setLayout(false);
    $this->render("users_view");
}
```

The `$this->viewBuilder()->setLayout(false)` removes any pre set templates. You can remove it to see how
the page will render without it.

[cake_fig_no_layout.png]

Lets create a members view. Add the code below to your controller.

```php
public function members(){

}
```

Now create the `members.ctp` file in `src/Template/Dashboard/members.ctp`. You can add the code below in the file

```php
<?php
echo "showing the members template";
```

If you navigate to `http://dev.cakeapp.com/dashboard/members` the contents of `members.ctp` will be rendered.
This happens automatically. We don't have to use the `$this->render()` function if our function is the same name
as the file to be rendered. Its suggested that we do though.

## Passing data from controller

If you want to pass data from the controller to the view/template you can use the 
`$this->set()` function.

```php
public function members(){
    $this->set('members',['wynton','james']);
    $this->render();
}
```

In our `members.ctp` file we display the `members` array using

```php
<?php
foreach($members as $member){
    echo $member .'<br>';
}
```
Lets try it a different way. We create a `data` array and then use the `set` function in our controller

```php
public function members(){
    $data = [
        'name' => 'Wynton',
        'age' => '23',
        'dob' => 'neveruary'
    ];
    $this->set($data);
    $this->render();
}
```

Now in our `members.ctp` we can add the following
```html
<h1>Welcome to a members view</h1>
<h2>enjoy your stay</h2>
<p>The member is <?= h($name) ?>  he is <?= h($age) ?> 
    years old and was born <?= h($dob) ?> </p>
```

So we can see the results. The `h()` function is used to escape user content.

[cake_fig_data_to_view.png]

# Layouts

Lets go to the `src/Layout` folder and copy the `default.ctp` and name the copied file `main.ctp`.
The main thing to do in `main.ctp` is to add an `h1` element as the page title.

```html
<?= $this->Flash->render() ?>
<h1><?= $pageTitle;?></h1>
<div class="container clearfix">
    <?= $this->fetch('content') ?>
</div>
```

Now in the `DashboardController.php` we can set the layout to be the `main.ctp`.

```php
public function members(){
    $this->viewBuilder()->setLayout('main');
    $data = [
        'name' => 'Wynton',
        'age' => '23',
        'dob' => 'neveruary',
    ];
    $this->set('pageTitle', "Page Title");
    $this->set($data);
    $this->render();
}
```

Notice our content is being pulled into the `main.ctp` layout using the
`<?= $this->fetch('content') ?>`. In between this we have the rest of our layout.

[cake_fig_layout_sample.png]

# Views

Views are are classes and the view templates are the `ctp` files that we created earlier.
Lets look at create a view template.

In the `DashboardController.php` we create a new view

```php
public function guide(){
    $this->render();
}
```

Then we create the view template in `src/Template/Dashboard/guide.ctp`.

```php
<?php

echo "hello to the guide";
```

What else can we do in a view template. Lets change our layout

```php
public function guide(){
    $this->viewBuilder()->setLayout('main');
    $this->render();
}
```

Now in our view we can change the `pageTitle`

```php
<?php

$this->set('pageTitle', "This is the guide page");
$guideTitle = "Hello to the guide";
echo "<h1>" . $guideTitle . "</h1>";

echo "hello to the guide";
```

[cake_fig_view_pagetitle.png]

# Database

In order to use our cake model easily cake has some conventions that we should follow.
You can check them out [here](https://book.cakephp.org/3/en/intro/conventions.html#model-and-database-conventions).

Lets create a table to play with.

```sql
CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(65) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

You can insert data from a datasource or get the csv file from [here](https://drive.google.com/open?id=13jFlMDHMEb5jS-35VwuRLk-6nyrK4bW8).

Now lets update our database configuration in `Cake`. Head to the `config/app.php` file.
Find the database configuration part and add the correct information.

[cake_fig_database_config.png]

Now lets get into our models.

# Models, Tables, Entity classes

With Cake we can use different methods to access our database tables.

## Table Registry Class

To use this class at the top of the controller we can add.

```php
use Cake\ORM\TableRegistry;
```

Now we create a new route to display our countries in `DashboardController.php`.

```php
public function countries(){
    $articles = TableRegistry::getTableLocator()->get('Countries');

    $query = $articles->find();
    $this->set('countries', $query);
    $this->render();
}
```
In the `countries.ctp` we add

```php
<?php
foreach ($countries as $row) {
    echo $row->country_name . '<br>';
}
```

[cake_fig_list_of_countries.png]

## Extend the TableRegistry

We can create an extension by create teh following code in `src/Model/Table`.
We create a `CountriesTable.php` class.

```php
<?php


namespace App\Model\Table;

use Cake\ORM\Table;

class CountriesTable extends Table
{

}
```

Now when we call ` $articles = TableRegistry::getTableLocator()->get('Countries')` we are getting and instance of
`CountriesTable`. You can test this yourself by making modifications to the `countries` function.

```php
public function countries(){
    $this->autoRender = false;
    $articles = TableRegistry::getTableLocator()->get('Countries');
    echo get_class($articles);
}
```

Learn more about tables [here](https://book.cakephp.org/3/en/orm/table-objects.html#basic-usage).

## Entity Classes

We can create an entity class by adding the following code in the `src/Model/Entity` folder.
We will name our class `Country.php`.

```php
<?php


namespace App\Model\Entity;


use Cake\ORM\Entity;

class Country extends Entity
{

}
```

Now in our `CoutriesTable.php` we need to tell it what `Entity` class to use. 
We add the `initialize` function and use the `setEntityClass` function in it.

```php
public function initialize(array $config)
{
    $this->setEntityClass('App\Model\Entity\Country');
    parent::initialize($config); // TODO: Change the autogenerated stub
}
```

Now we are using our entity class in our view (`countries.ctp`). The `$row` is an instance of `Country.php`.
```php
<?php
foreach ($countries as $row) {
    echo get_class($row) . '<br>';
}
```

We can create virtual fields in our entity class. Below we add the `_getCountrySpecialName` function

```php
public function _getCountrySpecialName(){
  return "The country name is: (" . $this->country_name . ")";
}
```

We can use this in our view like

```php
<?php
foreach ($countries as $row) {
    echo $row->get("countrySpecialName") . '<br>';
}
```

The output shows

[cake_fig_virutal_fields.png]

## Saving data

We can save a new entry to our `countries` table by using the `TableRegistry` class.

Lets create a `create` function in our `DashboardController.php`.

```php
public function create(){
    $this->autoRender = false;
    $countryTb = TableRegistry::getTableLocator()->get('Countries');
    $country = $countryTb->newEntity();
    $country->country_name = "Wynton Island";
    $countryTb->save($country);
    echo var_dump($country);

}
```

We use the `TableRegistry` to get and `Table` instance of `Countries`. We request a new entity
using `$countryTb->newEntity()`.

We then create a new country `$country->country_name`. And then we save it using

```php
$countryTb->save($country);
```

In the database we can see our results.

[cake_fig_database_countries_new.png]

## Updating a entity

Lets create an `update` function in our `DashboardController.php` and use it to update an entity.

```php
public function update(){
    $this->autoRender = false;
    $countryTb = TableRegistry::getTableLocator()->get('Countries');
    $country = $countryTb->get(1000);
    $country->country_name = "Wynton Updated Island";
    $countryTb->save($country);
    echo var_dump($country);
}
```

One of the important things to note in the above code is `$countryTb->get(1000)`. We use
the `get` function on the `TableRegistry` class to get result sets by the primary key.

[cake_fig_database_countries_updated.png]


## Getting data from the database

In the `DashboardController.php` lets create a `view` function and try to get results from 
the database using different methods.

### By Primary Key

We can get data via the primary key

```php
public function view(){
    $this->autoRender = false;
    $countryTb = TableRegistry::getTableLocator()->get('Countries');
    $country = $countryTb->get(1);
    echo $country->country_name;
}
```

### Find All with limit

Lets get all the countries with a limit.

```php
public function view(){
    $this->autoRender = false;
    $countryTb = TableRegistry::getTableLocator()->get('Countries');
    $countries = $countryTb->find("all")->limit(5);
    foreach ($countries as $country){
        echo $country->country_name . "<br>";
    }
}
```

[cake_fig_all_countries.png]

### Find all with like query

Lets get all the countries that begin with **a** limit 100.

```php
public function view(){
    $this->autoRender = false;
    $countryTb = TableRegistry::getTableLocator()->get('Countries');
    $countries = $countryTb->find("all",[
        'conditions' => 'Countries.country_name LIKE "a%"'
    ])->limit(100);
    foreach ($countries as $country){
        echo $country->country_name . "<br>";
    }
}
```

### Find by specific name

lets get the country trinidad. We use `$country = $countries->first()` to get the first result.

```php
public function view(){
    $this->autoRender = false;
    $countryTb = TableRegistry::getTableLocator()->get('Countries');
    $countries = $countryTb->find("all",[
        'conditions' => 'Countries.country_name = "Trinidad ( T&T)"'
    ])->limit(100);
    $country = $countries->first();
    echo $country->country_name . "<br>";
}
```

Learn more [here](https://book.cakephp.org/3/en/orm/retrieving-data-and-resultsets.html).

# Forms

Lets create a form. First we create a new route in the `DashboardController.php`

```php
public function form(){
    $this->autoRender = false;
    $countryTb = TableRegistry::getTableLocator()->get('Countries');
    $model = $countryTb->newEntity();
    $this->set('model',$model);
    $this->render();
}
```

In our view `form.ctp` we can start building the form using the model we passed.

```html
<div style="margin: 15px auto; max-width: 60%;">
<?php
echo $this->Form->create($model);
echo $this->Form->control('country_name', ['type' => 'text']);
echo $this->Form->button('Submit',['type'=>'submit']);
echo $this->Form->end();
?>
</div>
```

This will output the image below.

[cake_fig_form_view.png]

We can look at the generated `html` that the form creates

[cake_fig_form_html.png]

## Form submission

When we press the form submit button we submit the form back to the original route
at `/dashboard/form`. How do we handle this the code below show us

```php
public function form(){
    $this->autoRender = false;
    $countryTb = TableRegistry::getTableLocator()->get('Countries');
    if(isset($_POST['country_name'])){
        $model = $countryTb->newEntity();
        $model->country_name = $_POST['country_name'];
        $countryTb->save($model);
        echo "Country " . $model->country_name . " saved";
    }else{
        $model = $countryTb->newEntity();
        $this->set('model',$model);
        $this->render();
    }
}
```

We check if the form is submitted using `isset($_POST['country_name'])` function.
We then go on to save the new country `$countryTb->save($model);`.

If not form is submitted we just render the form as shown in the `else` section.
You can learn more about forms [here](https://book.cakephp.org/3/en/views/helpers/form.html#creating-form-controls).

# Conclusion

We looked at many different part of working with **Cake** the PHP framework. Be sure to checkout their cookbook
to [learn more](https://book.cakephp.org/3/en/index.html). This tutorial used the `Cake 3.8.5` version.
