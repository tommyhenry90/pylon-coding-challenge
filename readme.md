# Pylon Interview Challenge

<!-- MDTOC maxdepth:6 firsth1:2 numbering:0 flatten:0 bullets:1 updateOnSave:1 -->

- [Setup](#setup)   
   - [Using Docker Compose](#using-docker-compose)   
   - [Without Docker](#without-docker)   
      - [Requirements](#requirements)   
      - [Running the backend](#running-the-backend)   
- [Tasks](#tasks)   
   - [1. Backend bug](#1-backend-bug)   
   - [2. Frontend bug](#2-frontend-bug)   
   - [3. New backend feature](#3-new-backend-feature)   
   - [4. New frontend feature](#4-new-frontend-feature)   
   - [5. Questions](#5-questions)   

<!-- /MDTOC -->

## Setup

### Using Docker Compose

```bash
docker-compose up -d
```

Wait until you see this message:
```
backend_1  | Laravel development server started: http://0.0.0.0:8000
```

Then you can run the setup scripts:

```
docker-compose exec backend php artisan key:generate
docker-compose exec backend php artisan config:cache
docker-compose exec backend php artisan migrate
docker-compose exec backend php artisan db:seed
```

### Without Docker

#### Requirements

- PHP 7.2
- Composer
- A Mysql server with a database ready to use

#### Running the backend

Fill in the appropriate Mysql configuration values in `backend/.env` keys `DB_HOST` to `DB_PASSWORD`.

```bash
composer install
php artisan key:generate
php artisan config:cache
php artisan migrate
php artisan db:seed
php artisan serve
```

Open <localhost:8000> in your browser

## A tour of the application

### Overview

The example application is a very simple solar project management tool.
The application keeps a list of your solar design projects, and a list of your contacts.
Contacts might be customers, your salespeople, or installer subcontractors.

Projects and contacts have a many-many relationship between them; it's not uncommon for customers to order multiple commercial solar systems if they manage more than one building, and of course your salespeople and installers might be assigned to more than one project.

The application as it stands can do a few things:

- Show a list of solar projects
- Show the details of a solar project and the contacts assigned to it
- Delete a project

The API is capable of more actions, but the frontend doesn't have everything implemented yet.

### Backend

The

### Frontend

## Tasks

- Not everything has to be perfect; if you know you're deliberately something you think is relevant, leave a TODO comment
- Don't refactor the existing application structure; try to work within it as much as possible. Refactoring is too much effort for this task!
- When asked to justify things or describe your choices, a couple of sentences or bullet points are fine
- You don't have to add additional tests that aren't mentioned in the requirements
- On the frontend, don't worry about compatibility with browsers that aren't the latest Chrome. Write modern JavaScript and assume code will be transpiled later

### 1. Backend bug

TODO

### 2. Frontend bug

TODO

### 3. New backend feature

- Add batch delete API for projects
- Justify choice of method, describe advantages and disadvantages

### 4. New frontend feature

- Add a create/edit page

### 5. Questions

- What are the benefits and downsides of the API as it's currently implemented? What do you like and dislike? Would you make any changes?
- Tests currently run against the local database. What are the advantages and disadvantages? Would you make any changes?
