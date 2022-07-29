
## About this project pay

This project is made with laravel version 9 and php version 8. This is a simple project to calculate withdraw and deposit commissions based on CSV file format 

## How to Run?

### Dependencies

1. PHP 8
2. Laravel 9

### Installation

Clone the repository using git bash or terminal 

```
git clone https://github.com/nadimsajib/pay.git
```

Switch to the repo folder

```
cd pay
```

Install all the dependencies using composer

```
composer install
```

If you change the repo directory name then edit `.env` file and change `APP_URL=http://localhost/{your directory name}/public`

And then run the project in browser with this `http://localhost/pay/public`

Then you need to upload a CSV file as like format below 
```$xslt
2014-12-31,4,private,withdraw,1200.00,EUR
2015-01-01,4,private,withdraw,1000.00,EUR
2016-01-05,4,private,withdraw,1000.00,EUR
2016-01-05,1,private,deposit,200.00,EUR
2016-01-06,2,business,withdraw,300.00,EUR
2016-01-06,1,private,withdraw,30000,JPY
2016-01-07,1,private,withdraw,1000.00,EUR
2016-01-07,1,private,withdraw,100.00,USD
2016-01-10,1,private,withdraw,100.00,EUR
2016-01-10,2,business,deposit,10000.00,EUR
2016-01-10,3,private,withdraw,1000.00,EUR
2016-02-15,1,private,withdraw,300.00,EUR
2016-02-19,5,private,withdraw,3000000,JPY
```
After that click `Calculate` button and you will see the result like below: 

```$xslt
0.6
3
0
0.06
1.5
0
0.69
0.27
0.3
3
0
0
65.77
successfully calculate commissions
```

So that's It.

### Automation testing

You may test this simple data using automation test using `laravel dusk`

At first make sure that your `composer.json` has `"laravel/dusk": "^6.25"` in `"require-dev"` section .
Then run below code in terminal where your composer.json is allocated

```$xslt
php artisan dusk:install
```
After installation successfully please run below command

```$xslt
php artisan dusk
```
If the output is ``OK (1 test, 1 assertion)`` then testing is Ok 

If you do not have `"laravel/dusk": "^6.25"` in `composer.json` file you can install it via below commands 

```$xslt
composer require --dev laravel/dusk
composer install
```