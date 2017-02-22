#Front End 101 -  Introduction to Database
Things that I wish I know before I dive into the ORM model concept of django. I got them from the book 'Fundamentals of Database System' by Elmasri & Navathe.

##About Relational Database
### Chapter 3
 - Each value in a tuple is an atomic value; that is, it is not divisible into components within the framework of the basic relational model. Hence, composite and multivalued attributes are not allowed.Much of the theory behind the relational model was developed with this assumption in mind, which is called the **first normal form** assumption.
 - An important concept is that of **NULL** values, which are used to represent the values of attributes that may be unknown or may not apply to a tuple. A special value, called NULL, is used in these cases. During database design, it is best to **avoid** NULL values as much as possible. 
 - The relational model represents facts about both **entities** and **relationships** uniformly as relations.
 - An important category of constraints is data dependencies, which include functional dependencies and multivalued dependencies. They are used mainly for testing the “goodness” of the design of a relational database and are utilized in a process called **normalization**.
 - a key is a minimal superkey. (In django, it has a default primary key as integer.)
 - In general, a relation schema may have more than one key. In this case, each of the keys is called a candidate key. It is common to designate one of the candidate keys as the primary key of the relation. (think about the grid system project, we should use **'caseId + feederId + busId + loadId'** as the primary key for a load element)
 - Notice that a foreign key can refer to its own relation. (like a dBus' parent could be another dBus)
 - Several options are available if a deletion operation causes a violation. The first option, called **restrict**, is to reject the deletion. The second option, called **cascade**, is to attempt to cascade (or propagate) the deletion by deleting tuples that reference the tuple that is being deleted.A third option, called **set null** or **set default**, is to modify the referencing attribute values that cause the violation; each such value is either set to NULL or changed to reference another default valid tuple. Notice that if a referencing attribute that causes a violation is part of the primary key, it cannot be set to NULL; otherwise, it would violate entity integrity.


##Important Questions:
- How does database indexing work? Basically, indexing is a data structure for better searching algorithm.[stackoverflows](http://stackoverflow.com/questions/1108/how-does-database-indexing-work)



