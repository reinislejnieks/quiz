create table answers
(
  id         int unsigned auto_increment
    primary key,
  answer     varchar(100)         null,
  questionId smallint(5) unsigned null,
  isCorrect  tinyint(1)           null,
  constraint answers_id_UNIQUE
  unique (id)
);

create table questions
(
  id       int unsigned auto_increment
    primary key,
  question varchar(250) null,
  quizId   tinyint      null
);

create table quizzes
(
  id   tinyint unsigned auto_increment
    primary key,
  name varchar(30) null
);

create table results
(
  id        int auto_increment
    primary key,
  userId    int                                null,
  quizId    tinyint                            null,
  score     tinyint                            null,
  createdAt datetime default CURRENT_TIMESTAMP null
  on update CURRENT_TIMESTAMP,
  ip        varchar(45)                        null
);

create table userAnswers
(
  id        int unsigned auto_increment
    primary key,
  userId    int                                null,
  quizId    tinyint                            null,
  answerId  int                                null,
  createdAt datetime default CURRENT_TIMESTAMP null
  on update CURRENT_TIMESTAMP
);

create table users
(
  id                int unsigned auto_increment
    primary key,
  name              varchar(100)                       null,
  createdAt         datetime default CURRENT_TIMESTAMP null
  on update CURRENT_TIMESTAMP,
  lastQuestionIndex smallint(6)                        null
);


