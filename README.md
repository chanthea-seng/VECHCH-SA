# Stop all containers
docker compose down

# Start all containers in the background
docker compose up -d

# Access your services:
# API
API: http://localhost:9080

# Database (phpMyAdmin)
phpMyAdmin: http://localhost:8081
Server: mysql
Username: root
Password: secret

# Frontend Services
User: http://localhost:9101
Admin: http://localhost:9102
Doctor: http://localhost:9103
