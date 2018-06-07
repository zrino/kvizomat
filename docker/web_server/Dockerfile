FROM nginx:1.15

COPY ./etc/vhost.conf /etc/nginx/sites-available/vhost.template.conf

WORKDIR /etc/nginx

EXPOSE 80

RUN apt-get update && apt-get install -y \
    nano \
    vim \
    sed

CMD sed 's:{{DOMAINS}}:'"$DOMAINS"':' sites-available/vhost.template.conf >\
 conf.d/default.conf && nginx -g "daemon off;"
