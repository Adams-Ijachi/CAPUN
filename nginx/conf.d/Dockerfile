FROM nginx:stable-alpine

COPY ./nginx/conf.d/app.conf /etc/nginx/conf.d/

# Copy files from the build stage
COPY ./src /var/www/html
