#! /usr/bin/env python
import os,serial;
print "Content-Type: text/html";  # HTML is following
print;    # blank line, end of headers
try:
	f=open("/root/www/log/datalog","w");
	f.close();
	print "s";
except Exception as e:
	print "n";
	print e;