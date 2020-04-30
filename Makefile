dev:
        @echo "make Dev php-server..." ;\
        php Integration.php ;\
        mv main.phar /home/demo/main.phar ;\
        echo "make dev php-server ok";

pro:
        @echo "make Pro php-server..." ;\
        php Integration.php ;\
        echo "make pro php-server ok" ;