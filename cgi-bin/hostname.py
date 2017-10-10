#! /usr/bin/env python
import os,serial
print "Content-Type: text/html"  # HTML is following
print    # blank line, end of headers
#print "<html><header><title>Test CGI Python</title></header><body>"
command = "";
hostname = "detector1";
if os.environ.has_key("REQUEST_METHOD") and os.environ["REQUEST_METHOD"] == "GET":
	query_string = os.environ["QUERY_STRING"].split("&");
	for i in query_string:
		f=i.split("=");
		if (f[0] == "command"):
			command = f[1];
		elif (f[0] == "hostname"):
			hostname = f[1];
	if (command == "get"):
		hostname_file = open('/proc/sys/kernel/hostname','rb');
		try:
			 hostname = hostname_file.read();
		finally:
			 hostname_file.close();
		print hostname;
	elif (command == "set"):
		if hostname != "":
			hostname_file = open('/proc/sys/kernel/hostname','wb');
			try:
				 hostname = hostname_file.write(hostname)
			finally:
				 hostname_file.close();
			ret_value = system("uci set system.@system[0].hostname="+hostname+";uci commit;echo "+hostname+" >  /proc/sys/kernel/hostname&&/etc/init.d/avahi-daemon restart");
			#It is dangerous without any protection in shell.
			if(ret_value != 0):
				print "Return:"+ret_value;
			else:
				print hostname;
	elif (command == "username"):
		print "Username ";
		print os.getlogin();
	else:
		print "Please give command."
else:
	print "No else request method support now.";
#print os.environ
#print "</body>"
