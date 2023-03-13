#UniteTest
------------------
```shell
#all test
php artisan make:test Models\UserTest

php artisan test
#test phpunit
vendor/bin/phpunit tests/Unit/Projectors/MatchProjectorTest.php
#other way
phpunit tests/Unit/Projectors/MatchProjectorTest.php
```
---------------------
##concepts
- We test unit (Method or Function) of our code
- in real, live document
- we write the test for checking functionality of method and logic production code
- for averaging, execute with about 100 ms. we must execute many times and always was correct
- it isn't orderly in execution
- TDD  : test driven development 
  - Before I was written production code you write test code
  - contain 3 rules:
    - don't write new test when you have unsuccessful test
    - don't write new code when you have unsuccessful test
    - don't write code overload for testing
- BrownField (old code - legacy) , GreenField (clean code)
- Fake:( Mock - Stub) : for testing dependency
- You must not write th test for database
- you must not test dependency
- It is code coverage tool for checking unit test.
- It must not depend on machine and always was correct.
- 