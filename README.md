# Logitech G Hub Tools

An app to make it easier to deal with managing the G Hub key binds.

Very much a work in progress.

## Features

- [x] Load from G Hub database
- [x] Save to temp file
- [x] Find a key code by key name
- [ ] View all JSON 
- [ ] `card`
    - [x] View All
    - [ ] Add New
    - [x] View Details
    - [x] Edit Details
    - [ ] Delete 
- [ ] `application`
    - [ ] View All
    - [ ] Add New
    - [ ] View Details
    - [ ] Edit Details
    - [ ] Delete
- [ ] `profile`
    - [ ] View All
    - [ ] Add New
    - [ ] View Details
    - [ ] Edit Details
    - [ ] Delete
- [ ] Write changes from temp file to database

## Platforms

- [x] MacOS
- [ ] Windows
- [ ] Linux
- [x] Docker

## Installation

Clone this repo to wherever you want to use it and then follow your platform's install instructions. If your platform is not listed, use the [Docker](#docker) instructions.

### MacOS

#### Requirements

- [PHP 8.1](https://www.php.net/manual/en/install.macosx.packages.php)
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
- [NodeJS](https://nodejs.org/en/download/)
- Minimal knowledge of MacOS Terminal

#### Instructions

Open Terminal and `cd` to where you cloned this repository.

Run the install script:

```bash
$ sh ./scripts/macos/install.sh
```

*Note: the install script will fail if you do not have the above requirements installed.*

After installation you can start the webapp! See [Starting Up](#starting-up)

---

### Docker

#### Requirements

- [Docker](https://www.docker.com/get-started/)
- Minimal knowledge of filesystem and terminal

#### Instructions

Open Terminal and `cd` to where you cloned this repository.

Build the docker image (this will take several minutes):

```bash
$ docker build .
```

Copy your G Hub settings database to `{Wherever you stored this repository}/storage/docker/settings.db`.

On MacOS the database is located in `~/Library/Application Support/lghub/settings.db` 


Whenever you want to open the application run:

```bash
$ docker compose up
```

You can use the webapp! See [Usage](#usage)

---

## Starting Up

Run the application server

```bash
$ php artisan serve
```

Will start the application and run it on `localhost:8000`

## Usage

Open your browser and visit `localhost:8000`


