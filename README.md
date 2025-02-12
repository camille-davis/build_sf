# Build/SF

Portfolio website for a construction contractor featuring a custom CMS built with Laravel.

## Local Development

### Requirements

* Docker

### Installation

```
git clone git@github.com:camille-davis/buildsf.git
cd build_sf
```

Create .env file from template:
```
cp .env.example .env
```

In .env, set the database variables:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

Install dependencies:
```
composer install
npm install
npm run build
```

Generate app key:
```
artisan key:generate
```

Start the containers:
```
./vendor/bin/sail up -d
```

Import db:
```
./vendor/bin/sail mysql < buildsf_db.sql
```

App will be available at `localhost`.

### Enabling XDebug

Add to .env:
```
SAIL_XDEBUG_MODE=develop,debug,coverage
SAIL_XDEBUG_CONFIG="client_host=host.docker.internal start_with_request=yes discover_client_host=true"
```

#### VSCode

In .env append ```idekey=VSCODE``` to ```SAIL_XDEBUG_CONFIG```.

Create .vscode/launch.json and add:
```
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen for Xdebug",
      "type": "php",
      "request": "launch",
      "port": 9003,
      "pathMappings": {
          "/var/www/html": "${workspaceFolder}"
      },
      "hostname": "0.0.0.0"
    }
  ]
}
```

Rebuild containers:
```
./vendor/bin/sail down
./vendor/bin/sail build --no-cache
./vendor/bin/sail up
```

