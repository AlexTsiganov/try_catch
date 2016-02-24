### Test project developed by team Try_catch based on Silex php framework + MySQL

# [Try catch](http://www.rt.codewell.ru/)

## [Try catch (development)](http://www.test-rt.codewell.ru/)

## Silex framework

Silex is based on the Symfony2 components, just like the Symfony2 framework is. As such, it can be considered an alternative user interface to the components (the user being a web developer).Since they use the same basis, migration between them should be relatively easy.
Just like Symfony2, Silex is mostly a controller framework. It provides you with some structure, but the model and view parts are handled by third-party libraries (such as Twig or Doctrine).Since your business logic should not be in your controllers anyway, if you separate that code out and keep your controllers light, the limiting factor in terms of project size will only be the amount of routes you have.

1.  Use php composer with composer.json: `php composer install`
2.  Apache setup public folder with js & css and index.html
3.  Configurate MySQL database and debug mode in `src\code\config\config.php`

***

### simple API methods(dev):

1. Get last data from order tables: `GET api/maxDate`
2. Get services: `GET api/services`
3. Get seller statistic for charts: `GET api/statistic-seller?start_date='Y-m-d H:i:s'%end_date='Y-m-d H:i:s'%saler_id={id}`

***
