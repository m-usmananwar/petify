# Petify

## Requirements 

If you want to run the project locally. You need to have the following packages installed in your system
| Package      |
|--------------|
| Composer     |
| PHP ^8.0     |
| Apache/Nginx |
| MYSQL        |

### 1.Install PHP dependencies
```bash
composer install
```

### 2. Database setup
If you're running application for the first time you should run the migrations first set database credential in .env file

```bash
php artisan migrate:fresh --seed
```

### 3. Run the server

```bash
php artisan serve
```


## Project Rules

### Branching and committing

Please make sure that you have created branch for your feature.
Proposed branch name:

```diff
feature/PTF-<short-description>
feature/PTF-users-subscriptions
```

### Pull requests

Please make sure that you have created pull request for your feature. Don't commit directly into master/develop branch.
