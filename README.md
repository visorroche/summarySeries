# Summary Series

This project is a PHP Symfony + Boodstrap project with TMDB API and ChatGPT. It helps you remember the stories of the series you have watched.

## Getting Started

To get started with this project, follow the steps below:

### Prerequisites

Make sure you have the following software installed on your machine:

- PHP (version 8.1.27)
- Symfony (version 6.1.12)
- Node.js (version 20.11.1)
- NPM (version 10.5.0)

### Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/visorroche/summarySeries.git
    ```

2. Navigate to the project directory:

    ```bash
    cd summarySeries
    ```

3. Install the PHP dependencies:

    ```bash
    composer install
    ```

4. Install the JavaScript dependencies:

    ```bash
    npm install
    ```

5. Build the assets:

    ```bash
    npm run build
    ```

### Configuration

1. Create a new `.env` file by copying the `.env.example` file:

    ```bash
    cp .env.example .env
    ```

2. Open the `.env` file and configure the necessary environment variables, such as database connection details and API keys.

### Run the migrations to create the database tables
php bin/console doctrine:migrations:migrate

### Usage

1. Start the Symfony development server:

    ```bash
    php -S localhost:8000 -t public/
    ```

2. Access the application in your web browser at `http://localhost:8000`.

## GET CREDENTIALS IN TMDB

1. Visit the TMDB website at https://www.themoviedb.org/.
2. Sign in or create a new account if you don't have one already.
3. Once signed in, navigate to your account settings.
4. Look for the API section or API keys.
5. Generate a new API key by following the provided instructions.
6. Copy the generated API key.
7. Open the .env file in your project directory.
8. Replace API_KEY_TMDB with the copied API key.
9. Save the .env file.

## GET CREDENTIALS IN OPEN.AI

1. Visit the OpenAI website at https://www.openai.com/.
2. Sign in or create a new account if you don't have one already.
3. Once signed in, navigate to your account settings.
4. Look for the API section or API keys.
5. Generate a new API key by following the provided instructions.
5. Copy the generated API key.
6. Open the .env file in your project directory.
7. Replace GPT_TOKEN with the copied API key.
8. Save the .env file.

# Using Docker

If you want to use this project with Docker, you can do so using the Dockerfile and docker-compose.yml; just follow the steps below:
1. Install Docker on your machine https://docs.docker.com/get-docker/ 
2. Open the project directory in your terminal
3. Create your image with the command: 
```bash 
docker-compose build
```
4. Start your image with the command: 
```bash 
docker-compose up -d
```
5. Acess the terminal of contair with the command:
```bash 
docker-compose exec app bash
```
6. Play migrations using the command:
```bash 
php bin/console doctrine:migrations:migrate
```
7. Open the application in your browser at http://localhost:8000/

## Others Instructions

If you want drop your container use the command:
```bash 
docker-compose down
```

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please open an issue or submit a pull request.

