FROM nginx:latest

COPY ../docker/nginx.conf /etc/nginx/conf.d/nginx.conf

EXPOSE 80
