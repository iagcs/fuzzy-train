# News Aggregator Project

## Overview
This is a **news aggregation system** that automatically retrieves and consolidates news articles from multiple external news APIs. The articles are stored in a local PostgreSQL database and indexed using Elasticsearch for fast and efficient searching. The project also provides endpoints to retrieve articles based on user preferences like authors, categories, and sources.

## Technologies Used
- **Backend Framework**: [Laravel](https://laravel.com/) (PHP)
- **Database**: PostgreSQL
- **Search Engine**: [Elasticsearch](https://www.elastic.co/elasticsearch/)
- **API Client**: Laravel HTTP Client
- **Task Scheduling**: Laravel Command Scheduler for automated data fetching
- **Docker**: To containerize the application and its dependencies
- **Swagger**: API documentation for easy interaction and testing

## Features
- **Automatic News Fetching**: Articles are automatically fetched daily from external APIs such as NewsAPI, The Guardian, and New York Times.
- **Elasticsearch Integration**: Articles are indexed in Elasticsearch to allow for fast and relevant searches.
- **User Preferences**: The system can filter and retrieve articles based on the user's preferences, such as favorite authors, categories, and sources.
- **API Endpoints**:
    - Fetch a single article by ID.
    - Search for articles based on user preferences.

## Installation

### Prerequisites
- Docker
- Docker Compose
- PostgreSQL or compatible database
- Elasticsearch running in a Docker container (configured via Docker Compose)

### Steps to Use Docker

1. **Clone the Repository**
   ```bash
   git clone https://github.com/iagcs/fuzzy-train.git
   cd fuzzy-train

2. **Create .env File Copy the .env.example to .env and set your environment variables, such as database credentials and Elasticsearch settings.**
   ```bash
   p .env.example .env
   ```

3. **Run the docker container eith sail**
   ```bash
    /vendor/bin/sail up
   ```
   
4. Access the Application Once the containers are running, you can access the application at http://localhost:8000.

5. Run Migrations Run the migrations to set up the database tables:
    ```bash
    ./vendor/bin/sail artisan migrate
   ```

### Stopping the Containers

To stop the running Docker containers, use the following command:

```bash
./vendor/bin/sail down
```

### Testing
You can run the tests inside the container:

```bash
./vendor/bin/sail artisan test
```

## API Documentation
For detailed information on the API endpoints, refer to the [Swagger API Documentation](https://app.swaggerhub.com/apis-docs/IAGO3220_1/fuzzy-train/0.0.1-oas3#/User/user.store).
