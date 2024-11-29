FROM nginx:latest

# Copy configuration and fix permissions
COPY nginx.conf /etc/nginx/conf.d/nginx.conf

EXPOSE 80
