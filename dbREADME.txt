SQLite code:
CREATE TABLE "Users" (
	"UserID"	INTEGER NOT NULL UNIQUE,
	"First"	TEXT NOT NULL,
	"Last"	TEXT NOT NULL,
	"Username"	TEXT NOT NULL UNIQUE,
	"Password"	TEXT NOT NULL,
	"Role"	TEXT NOT NULL,
	PRIMARY KEY("UserID" AUTOINCREMENT)
)
CREATE TABLE "Classes" (
	"ClassID"	INTEGER NOT NULL UNIQUE,
	"Name"	TEXT NOT NULL,
	"StartDate"	TEXT NOT NULL,
	"EndDate"	TEXT NOT NULL,
	"Days"	TEXT NOT NULL,
	"StartTime"	TEXT NOT NULL,
	"EndTime"	TEXT NOT NULL,
	"Price"	INTEGER NOT NULL,
	"MemPrice"	INTEGER NOT NULL,
	"Location"	INTEGER NOT NULL,
	"Style"	TEXT,
	"MaxSize"	INTEGER,
	"Description"	TEXT NOT NULL,
	"Prerequisites"	TEXT,
	PRIMARY KEY("ClassID"),
)
CREATE TABLE "EnrollmentRecords" (
	"User"	INTEGER NOT NULL,
	"Class"	INTEGER NOT NULL,
	"EnrollmentDate"	TEXT,
	"Status"	TEXT,
	PRIMARY KEY("User","Class"),
	FOREIGN KEY("Class") REFERENCES "Classes",
	FOREIGN KEY("User") REFERENCES "Users"
)



Assumptions:
-Users:
	* Username will be emailAddress, which will make notifying the customer of cancellations easier.
	* Role will be used to determine non-member, member, and employee. (employees should get the same discount as members when enrolling)
	* employee access can only be granted by an administrator, furthermore administrator(us) should create all employee accounts.
	* userID will be the unique ID, while username could be a uniqueID this makes the EnrollmentRecords a little bit more readable.
-Classes:
	* Days will be delimited by a comma for easier parsing.
	* Pre-requisites will be a name for a class, this will allow for classes of the same name in a calender
	* Pre-requisites will require a check in enrollment records for the user.
	* Style is an optional repetition checker, is the class offered only once or multiple times.
-EnrollmentRecords:
	* The primary key is a tuple of User and Class which represent the userID and the ClassID in their respective cases.
	* Status is used to check for completion of a class. If a person is currently enrolled, completed, or failed.
	* EnrollmentDate is potentially for later. Might be needed. 