#!/bin/sh
#停止searchd
/usr/local/coreseek/bin/searchd -c /usr/local/coreseek/etc/sphinx-vd.conf --stop
#建立主索引
/usr/local/coreseek/bin/indexer -c /usr/local/coreseek/etc/sphinx-vd.conf video
#启动daemon
/usr/local/coreseek/bin/searchd -c /usr/local/coreseek/etc/sphinx-vd.conf

