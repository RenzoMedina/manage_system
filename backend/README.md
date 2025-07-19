# 📦 Administrative System API

Modular API for administrative resource management, developed in PHP with focus on backend best practices and deployment with Docker.

## 🚀 Main features

- Native PHP-based architecture
- Custom Docker container (backend-php:1.0)
- Environment variables managed with .env and docker-compose
- Integration with MySQL as database
- Configuration of ports and volumes for local development

## 🛠️ Technologies used

| Technology             | Main usage                                                               |
| ----------------- | ------------------------------------------------------------------ |
| PHP | Backend logic |
| PHP | Micro-framework for RESTful APIs |
| Medoo | Lightweight ORM for PHP database management |
| Guzzle | PHP HTTP client that makes it easy to send HTTP requests and trivial to integrate with web services |
| Docker  | Containerization and deployment |
| MySQL | Data persistence |
| GitHub Actions | Automated CI/CD |
| Azure DevOps | Task management and scheduling with Azure Boards |

## 📁 Structure

```plaintext
system_admin_api/
├─── app/
├─── core/
├─── routes/
├─── test/
│   ├─── index.php
│   ├─── .env
│   ├─── .htaccess
│   ├─── Dockerfile
│   └─── ...
└── README.md
```

## ⚙️ Quick Configuration

* Clones the repository

```bash
git clone https://github.com/RenzoMedina/system_admin_api.git
cd system_admin_api
```
*  Create your .env file in ./backend/.env:
```env
TOKEN=you token
DBNAME=sistema_administrable
DBTYPE=mysql
DBHOST=you host
DBUSER=you user
DBPASS=you user
```
## 🧪 Testing

```php
composer run-script tests
```
## 📚 Main Endpoint
route v1 "/api/v1"
| Method| Endpoint                                  | Description                                   |
|-------|-------------------------------------------|-----------------------------------------------|
| GET   | /users                                    | List all registered users                     |
| GET   | /user/@id                                 | Get user data by ID                           |
| POST  | /user                                     | Create a new user                             |
| PUT   | /user/@id                                 | Update user data                              |
| GET   | /role                                     | List all registered rol                       |
| POST  | /role                                     | Create a new rol                              |
| PUT   | /role/@id                                 | Update rol data                               |
| GET   | /patient                                  | List all registered patient                   |
| GET   | /patient@id                               | Get patient data by ID                        |
| POST  | /patient/@id/contact                      | Create a new contact by id patient            |
| PUT   | /patient/@id/contact/@contact_id          | Update user contact by id patient             |
| POST  | /patient/@id/details-clinical             | Create a new details clinical by patient      |
| PUT   | /patient/@id/details-clinical/@details_id | Update user details clinical by id patient    |


## 👨‍💻 Autor

Renzo Steven Medina Olaya
Backend Developer transitioning into DevOps

