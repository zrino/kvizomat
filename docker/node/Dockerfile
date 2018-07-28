FROM node:8.11-stretch

RUN mkdir /scripts

COPY scripts/* /scripts/
# Update npm to latest version
RUN npm install npm@5.6 -g

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
 && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

WORKDIR /var/www
