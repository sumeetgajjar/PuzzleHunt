CREATE TABLE questions (
  id SERIAL NOT NULL,
  question text NOT NULL,
  answer text NOT NULL,
  destination int NOT NULL,
  code int NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE users (
  id SERIAL NOT NULL,
  name varchar(40) NOT NULL,
  phone_number varchar(10) NOT NULL,
  creation_date varchar(40) NOT NULL,
  completed int DEFAULT 0,
  hunt_completed_time varchar(40),
  PRIMARY KEY (id),
  UNIQUE(name,phone_number)
);

CREATE TABLE user_question_mapping (
  user_id int NOT NULL,
  destination int NOT NULL,
  code int NOT NULL,
  question_id int NOT NULL,
  rank int NOT NULL,
  status int DEFAULT 0,
  completed_time varchar(40),
  PRIMARY KEY (user_id,question_id)
) ;

create index user_id_user_question_mapping_idx on user_question_mapping (user_id) ;
create index user_id_question_id_user_question_mapping_idx on user_question_mapping (user_id,question_id) ;
