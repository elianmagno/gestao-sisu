FROM postgres:18.3-bookworm

RUN apt-get update && apt-get install -y locales && \
    localedef -i pt_BR -c -f UTF-8 -A /usr/share/locale/locale.alias pt_BR.UTF-8

ENV LANG pt_BR.UTF-8

CMD ["postgres", "-c", "lc_time=pt_BR.UTF-8"]
