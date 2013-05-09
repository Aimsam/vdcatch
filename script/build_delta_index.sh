#!/bin/sh
#建立增量索引
/usr/local/coreseek/bin/indexer -c /usr/local/coreseek/etc/sphinx-vd.conf delta --rotate
#合并索引
/usr/local/coreseek/bin/indexer --merge video delta --merge-dst-range deleted 0 0 --rotate -c /usr/local/coreseek/etc/sphinx-vd.conf
