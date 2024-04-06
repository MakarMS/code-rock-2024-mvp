FROM node:21-alpine

WORKDIR /var/www/app

ENTRYPOINT ["sh", "-c", "cd public && npm install && npm run dev & wait"]
