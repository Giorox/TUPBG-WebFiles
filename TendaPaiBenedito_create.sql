-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2018-10-13 22:41:51.181

-- tables
-- Table: articles
CREATE TABLE articles (
    id smallint unsigned NOT NULL AUTO_INCREMENT,
    publicationDate date NOT NULL,
    title varchar(255) NOT NULL,
    summary text NOT NULL,
    content mediumtext NOT NULL,
    imageExtension varchar(255) NOT NULL,
    tagString varchar(255) NOT NULL,
    CONSTRAINT articles_pk PRIMARY KEY (id)
) COMMENT 'Table that references all articles maintained and their specific info.';

-- Table: books
CREATE TABLE books (
    bookID smallint unsigned NOT NULL AUTO_INCREMENT,
    bookTitle varchar(255) NOT NULL,
    bookMedium varchar(255) NULL,
    bookAuthor varchar(255) NULL,
    ISBN varchar(13) NOT NULL,
    bookLink varchar(1000) NOT NULL,
    CONSTRAINT books_pk PRIMARY KEY (bookID)
) COMMENT 'Table that keeps all recommended books information, such as title, year of publishing, author, ISBN.';

-- Table: courses
CREATE TABLE courses (
    courseID smallint unsigned NOT NULL AUTO_INCREMENT,
    courseName varchar(255) NOT NULL,
    courseInstructor varchar(255) NOT NULL,
    courseStartDate date NOT NULL,
    courseEndDate date NOT NULL,
    courseDescription varchar(255) NOT NULL,
    coursePrice varchar(255) NOT NULL,
    courseStatus int NOT NULL,
    CONSTRAINT courses_pk PRIMARY KEY (courseID)
) COMMENT 'Table that references all courses and related information';

-- Table: news
CREATE TABLE news (
    newsID smallint unsigned NOT NULL AUTO_INCREMENT,
    imageExtension_news varchar(255) NOT NULL,
    content varchar(500) NULL,
    title varchar(255) NULL,
    CONSTRAINT news_pk PRIMARY KEY (newsID)
) COMMENT 'Table that keeps new entries for the entry-card news carrousel';

-- End of file.

