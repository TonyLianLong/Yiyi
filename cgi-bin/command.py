#! /usr/bin/env python
import os,sys,serial
print "Content-Type: text/html"  # HTML is following
print    # blank line, end of headers
RETURN_CHAR = "\n";
#print "<html><header><title>Test CGI Python</title></header><body>"
command = "";
if os.environ.has_key("REQUEST_METHOD") and os.environ["REQUEST_METHOD"] == "GET":
	query_string = os.environ["QUERY_STRING"].split("&");
	for i in query_string:
		f=i.split("=");
		if (f[0] == "command"):
			command = f[1];
else:
	if len(sys.argv) > 1:
		command = sys.argv[1];
try:
	ser = serial.Serial('/dev/ttyACM0',115200,timeout = 1);
except Exception,e:
	print e;
ser.write(command);
ser.write(RETURN_CHAR);
data=ser.readline();
ser.timeout = 0.2;
data+=ser.read();
#ser.timeout = 1;
print data;
ser.close();
#print os.environ
#print "</body>"
