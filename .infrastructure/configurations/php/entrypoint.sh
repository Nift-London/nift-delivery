set -e
php bin/composer.phar install
php bin/console assets:install
php bin/console d:m:m
php bin/console ca:cl
php bin/console ca:wa

export DD_AGENT_HOST=$(curl http://169.254.169.254/latest/meta-data/local-ipv4)

case ${ENTRY_POINT} in
php_fpm)
    php-fpm
    ;;
#http://localhost:8020/bundles/easyadmin/field-boolean.38cf4737.js
#worker)
#    printenv > /etc/environment
#    CURRENT_PATH=$(pwd)
#    echo "* * * * * cd $CURRENT_PATH && DD_TRACE_CLI_ENABLED=true DD_TRACE_AUTO_FLUSH_ENABLED=true DD_TRACE_GENERATE_ROOT_SPAN=false /usr/local/bin/php artisan schedule:run >> /var/log/scheduler.log 2>&1" > /etc/cron.d/laravel-scheduler
#    chmod 0644 /etc/cron.d/laravel-scheduler
#    crontab /etc/cron.d/laravel-scheduler
#    touch /var/log/cron.log
#    touch /var/log/scheduler.log
#    service cron start
#
#    DD_TRACE_CLI_ENABLED=true DD_TRACE_AUTO_FLUSH_ENABLED=true DD_TRACE_GENERATE_ROOT_SPAN=false php artisan queue:work sqs --tries=2 --no-ansi --no-interaction --quiet --memory=2048 --timeout="0"
#    ;;

*)
    echo $"Usage: $0 {php_fpm|worker}"
    exit 1
    ;;

esac
