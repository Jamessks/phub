FROM nginx:latest

RUN apt-get update && apt-get install -y procps

WORKDIR /var/www/phub

COPY ./nginx/nginx.conf /etc/nginx/conf.d/default.conf

COPY . /var/www/phub

RUN chown -R www-data:www-data /var/www/phub/public
RUN chmod -R 755 /var/www/phub/public

EXPOSE 80