import MySQLdb
import urllib2
import csv
from bs4 import BeautifulSoup
from datetime import datetime
from fractions import Fraction

db = MySQLdb.connect(host="segomo.cizo6tr1olvl.us-east-1.rds.amazonaws.com",user="root",passwd="Kingtut1",db="segomo")
cursor = db.cursor()
id_num = 1000
# play_name = "John Rourke"
# sql = "SELECT shares_sold FROM users WHERE name=play_name"
# sql = "UPDATE users SET coins=num_coins WHERE id=6'"
# sql = ("""SELECT coins FROM users WHERE id=%s""", (id_num,))
# cursor.execute("""UPDATE users SET coins=%s""", (id_num,))
# print cursor.fetchone()
# cursor.execute("""SELECT shares_bought FROM players WHERE name=%s""", (play_name,))
# result = cursor.fetchall()
# for row in result:
# 	print row[0]
# db.close()

def getSharesSold(player_name):
    cursor.execute("""SELECT shares_sold FROM players WHERE name=%s""", (player_name,))
    result = cursor.fetchall()
    for row in result:
    	return row[0]

def getSharesBought(player_name):
    cursor.execute("""SELECT shares_bought FROM players WHERE name=%s""", (player_name,))
    result = cursor.fetchall()
    for row in result:
    	return row[0]

def algo( GP,  G,  A, PEN, W,  L,  T):
	price = 100.0 + GP + (2.0*G) + (2.0*A) + (PEN*(-0.25)) + (W*1.5) + (L*(-1.5)) + (T*0.75)
	return price

def GKalgo(GA, S, W, L, T, PeriodsPlayed):
	price = (-1.0*GA) + (0.2*S) + (1.5*W) + (-1.5*L) + (0.75*T)+(0.25*PeriodsPlayed)
	return price

def checkNull(value):
	if (value == ''):
		return 0.0
	else:
		return float(value)

quote_page_colby = 'http://www.collegehockeystats.net/1819/teamstats/clbm'
quote_page_amherst = 'http://www.collegehockeystats.net/1819/teamstats/amhm'
quote_page_bowdoin = 'http://www.collegehockeystats.net/1819/teamstats/bowm'
quote_page_conn = 'http://www.collegehockeystats.net/1819/teamstats/ctcm'
quote_page_midd = 'http://www.collegehockeystats.net/1819/teamstats/midm'
quote_page_tufts = 'http://www.collegehockeystats.net/1819/teamstats/tufm'
quote_page_trinity = 'http://www.collegehockeystats.net/1819/teamstats/trnm'
quote_page_williams = 'http://www.collegehockeystats.net/1819/teamstats/wilm'
quote_page_wesleyan = 'http://www.collegehockeystats.net/1819/teamstats/wesm'
quote_page_hamilton = 'http://www.collegehockeystats.net/1819/teamstats/hamm'
record_page = 'http://www.collegehockeystats.net/1819/standings/nescacm'


page = urllib2.urlopen(quote_page_colby)
page2 = urllib2.urlopen(quote_page_amherst)
page3 = urllib2.urlopen(quote_page_bowdoin)
page4 = urllib2.urlopen(quote_page_conn)
page5 = urllib2.urlopen(quote_page_midd)
page6 = urllib2.urlopen(quote_page_tufts)
page7 = urllib2.urlopen(quote_page_trinity)
page8 = urllib2.urlopen(quote_page_williams)
page9 = urllib2.urlopen(quote_page_wesleyan)
page10 = urllib2.urlopen(quote_page_hamilton)
records = urllib2.urlopen(record_page)

soup = BeautifulSoup(page, 'html.parser')
soup2 = BeautifulSoup(page2, 'html.parser')
soup3 = BeautifulSoup(page3, 'html.parser')
soup4 = BeautifulSoup(page4, 'html.parser')
soup5 = BeautifulSoup(page5, 'html.parser')
soup6 = BeautifulSoup(page6, 'html.parser')
soup7 = BeautifulSoup(page7, 'html.parser')
soup8 = BeautifulSoup(page8, 'html.parser')
soup9 = BeautifulSoup(page9, 'html.parser')
soup10 = BeautifulSoup(page10, 'html.parser')
record_soup = BeautifulSoup(records, 'html.parser')

record_table = record_soup.find('pre')
table = soup.find('table', attrs={'class','chssmallreg'})
# GKtable = soup.find('tr', attrs={'class', 'chswhite10'})
table2 = soup2.find('table', attrs={'class','chssmallreg'})
table3 = soup3.find('table', attrs={'class','chssmallreg'})
table4 = soup4.find('table', attrs={'class','chssmallreg'})
table5 = soup5.find('table', attrs={'class','chssmallreg'})
table6 = soup6.find('table', attrs={'class','chssmallreg'})
table7 = soup7.find('table', attrs={'class','chssmallreg'})
table8 = soup8.find('table', attrs={'class','chssmallreg'})
table9 = soup9.find('table', attrs={'class','chssmallreg'})
table10 = soup10.find('table', attrs={'class','chssmallreg'})

# record_data = []
# for d in record_table:
# 	record_data.append(d)
# 
# print record_data[1][10]

# GKdata = GKtable.findAll('td')
data = table.findAll('td')
data2 = table2.findAll('td')
data3 = table3.findAll('td')
data4 = table4.findAll('td')
data5 = table5.findAll('td')
data6 = table6.findAll('td')
data7 = table7.findAll('td')
data8 = table8.findAll('td')
data9 = table9.findAll('td')
data10 = table10.findAll('td')
# print GKdata

allData = []
allData2 = []
allData3 = []
allData4 = []
allData5 = []
allData6 = []
allData7 = []
allData8 = []
allData9 = []
allData10 = []

headers = []

for d in data[4:32]:
	headers.append(d.text.strip())

for d in data:
	allData.append(d.text.strip())

for d in data2:
	allData2.append(d.text.strip())

for d in data3:
	allData3.append(d.text.strip())

for d in data4:
	allData4.append(d.text.strip())

for d in data5:
	allData5.append(d.text.strip())

for d in data6:
	allData6.append(d.text.strip())

for d in data7:
	allData7.append(d.text.strip())

for d in data8:
	allData8.append(d.text.strip())

for d in data9:
	allData9.append(d.text.strip())

for d in data10:
	allData10.append(d.text.strip())

newHeaders = ["id", "name", "price", "school", "shares_bought", "shares_sold"]
newData = []
prices = []
prices2 = []
prices3 = []
prices4 = []
prices5 = []
prices6 = []
prices7 = []
prices8 = []
prices9 = []
prices10 = []
names = []
names2 = []
names3 = []
names4 = []
names5 = []
names6 = []
names7 = []
names8 = []
names9 = []
names10 = []

counter = 1
count1 = 32
count2 = 60
for x in range(24):
	gp = checkNull((allData[count1+14]))
	g = checkNull((allData[count1+15]))
	a = checkNull((allData[count1+16]))
	if (allData[count1+18] == ''):
		pen = 0.0
	else:
		denom = str(allData[count1+18])
		pen = float(denom[-1])
	w = checkNull((allData[2][25]))
	print w
	l = checkNull((allData[2][27]))
	t = checkNull((allData[2][29]))
	names.append(allData[count1+1])
	# if(allData[count1+2] == G):
# 		prices.append(GKalgo())
# 	else:
	prices.append(algo(gp, g, a, pen, w, l, t))
#	 print algo(gp, g, a, pen, w, l,t)
	count1 += 28
	count2 += 28

count1 = 32
count2 = 60
for x in range(24):
	gp = checkNull((allData2[count1+14]))
	g = checkNull((allData2[count1+15]))
	a = checkNull((allData2[count1+16]))
	if (allData2[count1+18] == ''):
		pen = 0.0
	else:
		denom = str(allData2[count1+18])
		pen = float(denom[-1])
	w = checkNull((allData2[2][25]))
	l = checkNull((allData2[2][27]))
	t = checkNull((allData2[2][29]))
	names2.append(allData2[count1+1])
	prices2.append(algo(gp, g, a, pen, w, l, t))
#	 print algo(gp, g, a, pen, w, l,t)
	count1 += 28
	count2 += 28

count1 = 32
count2 = 60
for x in range(29):
	gp = checkNull((allData3[count1+14]))
	g = checkNull((allData3[count1+15]))
	a = checkNull((allData3[count1+16]))
	if (allData3[count1+18] == ''):
		pen = 0.0
	else:
		denom = str(allData3[count1+18])
		pen = float(denom[-1])
	w = checkNull((allData3[2][25]))
	l = checkNull((allData3[2][27]))
	t = checkNull((allData3[2][29]))
	names3.append(allData3[count1+1])
	prices3.append(algo(gp, g, a, pen, w, l, t))
#	 print algo(gp, g, a, pen, w, l,t)
	count1 += 28
	count2 += 28

count1 = 32
count2 = 60
for x in range(27):
	gp = checkNull((allData4[count1+14]))
	g = checkNull((allData4[count1+15]))
	a = checkNull((allData4[count1+16]))
	if (allData4[count1+18] == ''):
		pen = 0.0
	else:
		denom = str(allData4[count1+18])
		pen = float(denom[-1])
	w = checkNull((allData4[2][25]))
	l = checkNull((allData4[2][27]))
	t = checkNull((allData4[2][29]))
	names4.append(allData4[count1+1])
	prices4.append(algo(gp, g, a, pen, w, l, t))
#	 print algo(gp, g, a, pen, w, l,t)
	count1 += 28
	count2 += 28

count1 = 32
count2 = 60
for x in range(25):
	gp = checkNull((allData5[count1+14]))
	g = checkNull((allData5[count1+15]))
	a = checkNull((allData5[count1+16]))
	if (allData5[count1+18] == ''):
		pen = 0.0
	else:
		denom = str(allData5[count1+18])
		pen = float(denom[-1])
	w = checkNull((allData5[2][25]))
	l = checkNull((allData5[2][27]))
	t = checkNull((allData5[2][29]))
	names5.append(allData5[count1+1])
	prices5.append(algo(gp, g, a, pen, w, l, t))
#	 print algo(gp, g, a, pen, w, l,t)
	count1 += 28
	count2 += 28

count1 = 32
count2 = 60
for x in range(30):
	gp = checkNull((allData6[count1+14]))
	g = checkNull((allData6[count1+15]))
	a = checkNull((allData6[count1+16]))
	if (allData6[count1+18] == ''):
		pen = 0.0
	else:
		denom = str(allData6[count1+18])
		pen = float(denom[-1])
	w = checkNull((allData6[2][25]))
	l = checkNull((allData6[2][27]))
	t = checkNull((allData6[2][29]))
	names6.append(allData6[count1+1])
	prices6.append(algo(gp, g, a, pen, w, l, t))
#	 print algo(gp, g, a, pen, w, l,t)
	count1 += 28
	count2 += 28

count1 = 32
count2 = 60
for x in range(26):
	gp = checkNull((allData7[count1+14]))
	g = checkNull((allData7[count1+15]))
	a = checkNull((allData7[count1+16]))
	if (allData7[count1+18] == ''):
		pen = 0.0
	else:
		denom = str(allData7[count1+18])
		pen = float(denom[-1])
	w = checkNull((allData7[2][25]))
	l = checkNull((allData7[2][27]))
	t = checkNull((allData7[2][29]))
	names7.append(allData7[count1+1])
	prices7.append(algo(gp, g, a, pen, w, l, t))
#	 print algo(gp, g, a, pen, w, l,t)
	count1 += 28
	count2 += 28

count1 = 32
count2 = 60
for x in range(24):
	gp = checkNull((allData8[count1+14]))
	g = checkNull((allData8[count1+15]))
	a = checkNull((allData8[count1+16]))
	if (allData8[count1+18] == ''):
		pen = 0.0
	else:
		denom = str(allData8[count1+18])
		pen = float(denom[-1])
	w = checkNull((allData8[2][25]))
	l = checkNull((allData8[2][27]))
	t = checkNull((allData8[2][29]))
	names8.append(allData8[count1+1])
	prices8.append(algo(gp, g, a, pen, w, l, t))
#	 print algo(gp, g, a, pen, w, l,t)
	count1 += 28
	count2 += 28

count1 = 32
count2 = 60
for x in range(25):
	gp = checkNull((allData9[count1+14]))
	g = checkNull((allData9[count1+15]))
	a = checkNull((allData9[count1+16]))
	if (allData9[count1+18] == ''):
		pen = 0.0
	else:
		denom = str(allData9[count1+18])
		pen = float(denom[-1])
	w = checkNull((allData9[2][25]))
	l = checkNull((allData9[2][27]))
	t = checkNull((allData9[2][29]))
	names9.append(allData9[count1+1])
	prices9.append(algo(gp, g, a, pen, w, l, t))
#	 print algo(gp, g, a, pen, w, l,t)
	count1 += 28
	count2 += 28

count1 = 32
count2 = 60
for x in range(26):
	gp = checkNull((allData10[count1+14]))
	g = checkNull((allData10[count1+15]))
	a = checkNull((allData10[count1+16]))
	if (allData10[count1+18] == ''):
		pen = 0.0
	else:
		denom = str(allData10[count1+18])
		pen = float(denom[-1])
	w = checkNull((allData10[2][25]))
	l = checkNull((allData10[2][27]))
	t = checkNull((allData10[2][29]))
	names10.append(allData10[count1+1])
	prices10.append(algo(gp, g, a, pen, w, l, t))
#	 print algo(gp, g, a, pen, w, l,t)
	count1 += 28
	count2 += 28


theData = []
theData2 = []

for x in range(24):
	theData.append(counter)
	name = names[x].replace("'","")
	theData.append(name)
	theData.append(prices[x])
	theData.append('Colby')
	theData.append(getSharesBought(name))
	theData.append(getSharesSold(name))
# 	theData.append('0')
# 	theData.append('0')
	counter += 1

for x in range(24):
	theData.append(counter)
	name = names2[x].replace("'","")
	theData.append(name)
	theData.append(prices2[x])
	theData.append('Amherst')
	theData.append(getSharesBought(name))
	theData.append(getSharesSold(name))
	# theData.append('0')
# 	theData.append('0')

	counter += 1

for x in range(29):
	theData.append(counter)
	name = names3[x].replace("'","")
	theData.append(name)
	theData.append(prices3[x])
	theData.append('Bowdoin')
	theData.append(getSharesBought(name))
	theData.append(getSharesSold(name))
	# theData.append('0')
# 	theData.append('0')
	counter += 1

for x in range(27):
	theData.append(counter)
	name = names4[x].replace("'","")
	theData.append(name)
	theData.append(prices4[x])
	theData.append('Conn')
	theData.append(getSharesBought(name))
	theData.append(getSharesSold(name))
	# theData.append('0')
# 	theData.append('0')
	counter += 1

for x in range(25):
	theData.append(counter)
	name = names5[x].replace("'","")
	theData.append(name)
	theData.append(prices5[x])
	theData.append('Midd')
	theData.append(getSharesBought(name))
	theData.append(getSharesSold(name))
	# theData.append('0')
# 	theData.append('0')
	counter += 1

for x in range(30):
	theData.append(counter)
	name = names6[x].replace("'","")
	theData.append(name)
	theData.append(prices6[x])
	theData.append('Tufts')
	theData.append(getSharesBought(name))
	theData.append(getSharesSold(name))
	# theData.append('0')
# 	theData.append('0')
	counter += 1

for x in range(26):
	theData.append(counter)
	name = names7[x].replace("'","")
	theData.append(name)
	theData.append(prices7[x])
	theData.append('Trinity')
	theData.append(getSharesBought(name))
	theData.append(getSharesSold(name))
	# theData.append('0')
# 	theData.append('0')
	counter += 1

for x in range(24):
	theData.append(counter)
	name = names8[x].replace("'","")
	theData.append(name)
	theData.append(prices8[x])
	theData.append('Williams')
	theData.append(getSharesBought(name))
	theData.append(getSharesSold(name))
	# theData.append('0')
# 	theData.append('0')
	counter += 1

for x in range(25):
	theData.append(counter)
	name = names9[x].replace("'","")
	theData.append(name)
	theData.append(prices9[x])
	theData.append('Wesleyan')
	theData.append(getSharesBought(name))
	theData.append(getSharesSold(name))
	# theData.append('0')
# 	theData.append('0')
	counter += 1

for x in range(26):
	theData.append(counter)
	name = names10[x].replace("'","")
	theData.append(name)
	theData.append(prices10[x])
	theData.append('Hamilton')
	theData.append(getSharesBought(name))
	theData.append(getSharesSold(name))
	# theData.append('0')
# 	theData.append('0')
	counter += 1

# with open('stats.csv','w') as csv_file:
# 	writer = csv.DictWriter(csv_file,newHeaders)
# 	writer.writeheader()
# 
# with open('stats.csv','a') as csv_file:
# 	writer = csv.writer(csv_file)
# 	start = 0
# 	end = 6
# 	for x in range(260):
# 		writer.writerow(theData[start:end])
# 		start += 6
# 		end += 6

