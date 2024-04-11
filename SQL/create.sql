CREATE TABLE Blog_Users(
    userID INTEGER,
    userName CHAR(250) NOT NULL,
    birthday CHAR(10),
    userPassword CHAR(250) NOT NULL,
    ban_status INTEGER NOT NULL,
    PRIMARY KEY(userID)
);


CREATE TABLE VIP(
    vipID INTEGER,
    vip_level INTEGER NOT NULL,
    preferred_color CHAR(250),
    PRIMARY KEY(vipID),
    FOREIGN KEY(vipID) REFERENCES Blog_Users(userID) ON DELETE CASCADE
);

CREATE TABLE SecurityInfo_Of(
    userID INTEGER NOT NULL,
    email CHAR(250),
    security_question CHAR(250) NOT NULL,
    answer CHAR(250) NOT NULL,
    PRIMARY KEY(email),
    FOREIGN KEY(userID) REFERENCES Blog_Users(userID) ON DELETE CASCADE
);

CREATE TABLE Community(
    communityID INTEGER,
    community_level INTEGER NOT NULL,
    PRIMARY KEY(communityID)
);

CREATE TABLE Admin_Monitor(
    adminID INTEGER,
    avatar CHAR(10) NOT NULL,
    adminPassword CHAR(250) NOT NULL,
    communityID INTEGER NOT NULL,
    PRIMARY KEY(adminID),
    FOREIGN KEY(communityID) REFERENCES Community(communityID) ON DELETE CASCADE
);

CREATE TABLE Ban(
    userID INTEGER,
    adminID INTEGER,
    PRIMARY KEY(userID,adminID),
    FOREIGN KEY(userID) REFERENCES Blog_Users(userID) ON DELETE CASCADE,
    FOREIGN KEY(adminID) REFERENCES Admin_Monitor(adminID) ON DELETE CASCADE
);


CREATE TABLE Topic(
    topic_name CHAR(250),
    PRIMARY KEY(topic_name)
);

CREATE TABLE Subscribe(
    userID INTEGER,
    communityID INTEGER,
    PRIMARY KEY(userID,communityID),
    FOREIGN KEY(userID) REFERENCES Blog_Users(userID) ON DELETE CASCADE,
    FOREIGN KEY(communityID) REFERENCES Community(communityID) ON DELETE CASCADE
);

CREATE TABLE CID_DATETIME_Title(
    communityID INTEGER,
    DATETIME_record DATE,
    title CHAR(250),
    content CHAR(250) NOT NULL,
    PRIMARY KEY(communityID,DATETIME_record,title),
    FOREIGN KEY(communityID) REFERENCES Community(communityID) ON DELETE CASCADE
);

CREATE TABLE UID_CID_DATETIME(
    userID INTEGER,
    communityID INTEGER,
    DATETIME_record DATE,
    title CHAR(250) NOT NULL,
    PRIMARY KEY(userID,communityID,DATETIME_record),
    FOREIGN KEY(userID) REFERENCES Blog_Users(userID) ON DELETE CASCADE, 
    FOREIGN KEY(communityID, DATETIME_record, title) REFERENCES CID_DATETIME_Title(communityID, DATETIME_record, title) ON DELETE CASCADE
);

CREATE TABLE BID(
    blogId INTEGER,
    userID INTEGER NOT NULL,
    communityID INTEGER NOT NULL,
    DATETIME_record DATE NOT NULL,
    PRIMARY KEY(blogId),
    FOREIGN KEY(userID,communityID, DATETIME_record) REFERENCES UID_CID_DATETIME(userID, communityID, DATETIME_record) ON DELETE CASCADE
);

CREATE TABLE Comment_Create_Follows(
    comment_order INTEGER,
    blogID INTEGER,
    userID INTEGER NOT NULL,
    content CHAR(250) NOT NULL,
    PRIMARY KEY(comment_order,blogID),
    FOREIGN KEY(blogID) REFERENCES BID(blogId) ON DELETE CASCADE,
    FOREIGN KEY(userID) REFERENCES Blog_Users(userID) ON DELETE CASCADE
);


CREATE TABLE About(
    communityID INTEGER,
    topic_name CHAR(250),
    PRIMARY KEY(communityID,topic_name),
    FOREIGN KEY(communityID) REFERENCES Community(communityID) ON DELETE CASCADE,
    FOREIGN KEY(topic_name) REFERENCES Topic(topic_name) ON DELETE CASCADE
);
