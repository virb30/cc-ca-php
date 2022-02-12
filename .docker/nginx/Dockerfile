FROM nginx:alpine

ARG USER_ID
ARG GROUP_ID

COPY nginx/default.conf /etc/nginx/conf.d
USER ${USER_ID}:${GROUP_ID}