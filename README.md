# Description

It is a very simple RPN calculator implementation, which represents a calculator, process manager and console input/output implementation. The design is pretty flexible, so it allows to add new operations, different input/outputs, even different calculators. In real life application there would be a little bit more test cases (most of all is covered, but didn't have time to cover 100%), there might be another abstraction which allows to replace communication strings with some translations/different values.

Example Input/Output
--------------------

    > 5 
    5
    > 8
    8
    > +
    13

For running a test console calculator, do:
```console
$ php console_example.php 
```
