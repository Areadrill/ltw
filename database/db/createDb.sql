CREATE TABLE User (
  uid INTEGER PRIMARY KEY AUTOINCREMENT,
  uname NVARCHAR(25),
  password NVARCHAR(256),
  salt NVARCHAR(256),
  email NVARCHAR(256)
);

CREATE TABLE Event (
  eid INTEGER PRIMARY KEY AUTOINCREMENT,
  ename NVARCHAR(25),
  edate DATE,
  description NVARCHAR(1000),
  type NVARCHAR(20),
  eimage INTEGER REFERENCES Image(iid),
  private BOOLEAN
);

CREATE TABLE EventOwner(
  uid INTEGER REFERENCES User(uid),
  eid INTEGER REFERENCES Event(eid),
  CONSTRAINT pk PRIMARY KEY (eid, uid)
);

CREATE TABLE EventFollower(
  eid INTEGER REFERENCES Event(eid),
  uid INTEGER REFERENCES User(uid),
  CONSTRAINT pk PRIMARY KEY(eid, uid)
);

CREATE TABLE Album (
  aid INTEGER PRIMARY KEY AUTOINCREMENT,
  nome NVARCHAR(50),
  eid INTEGER REFERENCES Event(eid)
);

CREATE TABLE Image (
  iid INTEGER PRIMARY KEY AUTOINCREMENT,
  fpath NVARCHAR(1000)
);

CREATE TABLE ImageAlbum (
  iid INTEGER REFERENCES Image(iid),
  aid INTEGER REFERENCES Album(aid),
  CONSTRAINT pk PRIMARY KEY(iid, aid)
);

CREATE TABLE Thread (
  tid INTEGER PRIMARY KEY AUTOINCREMENT,
  title NVARCHAR(50),
  creator INTEGER REFERENCES User(uid),
  event INTEGER REFERENCES Event(eid),
  fulltext NVARCHAR(1000)
);

CREATE TABLE Comment (
  cid INTEGER PRIMARY KEY AUTOINCREMENT,
  user INTEGER REFERENCES User(uid),
  thread INTEGER REFERENCES Thread(tid),
  content NVARCHAR(140)
);

CREATE TRIGGER cascadeDeleteEvent
AFTER DELETE ON Event
BEGIN
  DELETE FROM EventFollower WHERE eid= OLD.eid;
  DELETE FROM EventOwner WHERE eid=OLD.eid;
END;


.save ../database/db/EventagerDB.db
