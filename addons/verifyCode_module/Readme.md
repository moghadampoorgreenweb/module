# Documenation


This Doc For Using Addon 'is customers'

# Config


```bash
Configuration/Configuration.php
```
The number of times a user can receive a token code.
```bash
const NUMBER_OFTOKENS_ALLOWED = 100;
```
Code expiration time.
```bash
const EXPIRED_TOKEN_MINUTE = 3;
```
Number of attempts to enter error code.
```bash
const TRIES_TOKEN = 3;
```
Module configuration data.
```bash
private static $data;     
```


# Send Code Verify To Email User


```bash
Url : index.php?m=is_customers&action=Campaign/register
```


# Create Token Code 


Method : Post


# Parameters


| parameters | Description |
|-----------------------|-----------------------------------|
|  email |required


------------


# Check Code

```bash
Url : index.php?m=is_customers&action=Campaign/checktoken
```


Method : Get


# Parameters


| parameters | Description |
|------------|-----------------------------------|
| email      |required
| code       |required
