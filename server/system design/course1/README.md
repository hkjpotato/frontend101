# Course 1: Introduction to System Design & News Feed System #
## Overview ##
1. What is database, what is SQL and NoSQL databases?
2. What is the core consideration for designing Twitter/Weibo?
3. What is Memcache?
4. What happen when Lady Gaga post a new tweet?

## 4S solution ##
* Scenario
	* what features/functionalities are required
	* DAU (Daily Active Users)
	* Concurrent User
	* READ/WRITE QPS (Queries Per Second)

* Service
 * split big system into small modules

* Storage
 * unlike algorithm, where all the data are stored in memory, system design requires data to be store in disk/ssd(IO)
 * thus we need to know how to store/read/manipulate the data

* Scale
 * how to optimize special case
 * optimize vs maintanance

## comment ##
	* important infor prefer sql than nosql
	* nosql can be scaled better
	* file system is for image/video

## design news feed
	* push vs pull
	* key considerations: "watch/unwatch" &
	"content is different for different people"
	* 

## Reference ##
[What is NoSQL Database?Learn By Writing One in Python](https://jeffknupp.com/blog/2014/09/01/what-is-a-nosql-database-learn-by-writing-one-in-python/)