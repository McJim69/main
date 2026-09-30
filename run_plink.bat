@echo off
echo y | plink -ssh root@10.0.10.51 -pw McJim654123 "cyberpanel createDNS --domainName victoryfreewifi.net --recordName uisp --recordType A --recordValue 10.0.10.130" > d:\Server\www\plink_out.txt 2>&1
