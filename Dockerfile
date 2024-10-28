# Use an official Nginx image as the base image
FROM nginx:latest

# Install procps for access to ps command
RUN apt-get update && apt-get install -y procps

# Set the working directory inside the container
WORKDIR /var/www/phub

# Copy the Nginx configuration file from the local machine to the container
COPY ./nginx/nginx.conf /etc/nginx/conf.d/default.conf

# Copy the application files from the local machine to the container
COPY . /var/www/phub

# Set permissions for the application files (optional, but recommended)
RUN chown -R www-data:www-data /var/www/phub/public
RUN chmod -R 755 /var/www/phub/public
# Expose the port that Nginx listens on
EXPOSE 80