<h1 align="center">AKU Project</h1>

## Introduction
<p align="justify">
You may wonder, what the hell is AKU stands for, well it stands for
nothing, we just can't explain it because its an inside jokes. it took 12 years of internet exploration to understand this term.

<p align="justify">

</p>
</p>


## You may ask what the hell is this
<p align="justify">
    Made by two teenagers who have only learned 5 days worth of laravel before starting this project. It's a basic Laravel CRUD with quite the features.
    <p align="justify">
    This project can handle CRUD operations through random methods, some use ajax, some I dont even know how I made it but it works.
    </p>
    <p align="justify">
    The tables support sorting, pagination, or search data on the table, and you also could import and export the table as excel files.
    </p>
</p>


## Before Installing This Project

<p align="justify">
    You need to make sure that you're using PHP 8.1 for the minimum version, then you will need to install some other tools like, Git for cloning this project into your local server directory, Composer for managing php package and installing some others package that will be needed. Also, you should make sure that you have enabled the following php extension in php.ini configuration file, such as:
</p>

- php_zip
- php_xml
- php_gd2
- php_iconv
- php_simplexml
- php_xmlreader
- php_zlib

## Installation Instruction

1. Clone this project and `cd` into the cloned project by using this following this command:
   
   ```shell
    git clone https://github.com/viernism/aku_crud.git && cd aku_crud
   ```

2. After that, you'll need to copy `.env.example` into `.env` file and installing components from `composer` by using this following command:

    ```shell
    cp .env.example .env && composer install
    ```

3. Now, after that installing components from `composer` completed, you need to generate key by using this following command:
   
   ```bash
    php artisan key:generate
   ```

4. Now, you will need to set up your database. It's better to use database engine like PostgreSQL or MySQL. You can change it on your `.env` file, for example we are using MySQL. then, you can configure it like this, but remember to configure it based on your server settings.

    <img src="https://raw.githubusercontent.com/rhnnnn/mulmed-sheet/main/Screenshot_20230417_103526.png">


5. Before migrating the tables, you will need to set up an admin user in user seeder


6. Run this following command to migrate all needed table.
   
   ```bash
   php artisan migrate --seed
   ```


7. Don't forget to run this command, so the profile picture upload and other things can work.

    ```bash
    php artisan storage:link
    ```

## F A Q

1.  Q: Why is the methods so inconsistent?
    <br>A: 🤓
    
2.  Q: Why is the code so messy?
    <br>A: 🤓

3.  Q: Why is the database so ass?
    <br>A: 🤓

4.  Q: ...
    <br>A: 🤓

5. Q: Why this isnt working?
    <br>A: Br0, dont be lazy. we make it open so you can fork it and fix it. I'm not a king, I'm not a God, I am -rhnn

### okay serious answer

1. Q: Why is the code so messy?
    <br>A: heck yeah, we are newbie and managing code is hard -rhnn

2. Q: Why is the database is so unorganized?
    <br>A: Well, you can organize it yourself if you want to, by separating the database for each function, like auth database, tables database and etc. But, since i'm a bit lazy to do that, so i just let it like this. -rhnn

3. Q: Why i cant add more tables from the page?
    <br>A: Because it's only a basic CRUD app and have several hard things to do without changing the backend and things by yourself. I mean like, it has a lot of junkie tables relation, laravel-excel method and etc. Also it's because we use SQL databases not NoSQL like MongoDB. - rhnn

4.  Q: Why don't you actually uses the email to verify the user
    <br>A: because it costs money -viernism

5.  Q: Why is the Javascript so messy
    <br>A: hey i dont even know how i actually finish this project -viernism

6.  Q:Roti O Stasiun Lempuyangan
    <br>A: 😋😋😋 -both of us

7.  Q: what does libir stands for?
    <br>A: I PUT NEW FORGIS ON THE JEEP


(this is rly rude im really sorry...)
