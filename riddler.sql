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

insert into questions (question,answer,destination,code) values
('you can look right through the wall using me who am i ?','window','1','33122'),
('u look at me to see yourself','mirror','1','33122'),
('I start with an e, I end with an e, but I usually contain only one letter? ','Envelope','1','33122'),
('tear off my skin and I wont cry, but you will','onion','2','77784'),
('I have to be broken down before I am of use','Egg','2','77784'),
('I have a sound that goes beep, and while the time I do keep, my main function is to heat!','microwave,oven','2','77784'),
('What has a ring but no finger?','telephone,phone,mobile','3','28063'),
('Time to chill, time to think; please go here for a cool, cool drink.','refrigerator,fridge','3','28063'),
('Idiot box, eye, and telly are names for this machine. CID, Crime Patrol, and sooryavansham.  on it are weekly seen.','TV, television','3','28063'),
('Runs, but cannot walk, Lacks arms, has hands; lacks a head but has a face.','clock,watch','4','38006'),
('What is white when its dirty and black when its clean?','blackboard,chalkboard','4','38006'),
('I am so simple that I only point; yet I guide men all over the world.','compass','4','38006'),
('i come down but cannot go up, i come for just 3 months in a year','rain,monsoon, rains','5','27821'),
('What do you call your father-in-laws only childs mother-in-law?','mom,mummy,mother,mommy','5','27821'),
('What building has the most stories','library','5','27821'),
('Mr. Smith has 4 daughters. Each of his daughters has a brother. How many children does Mr. Smith have?','5,five','6','44849'),
('A seven letter word containing thousands of letters','mailbox,postbox','6','44849'),
('Wednesday, Tom and Joe went to a restaurant and ate dinner. When they were done they paid for the food and left. But Tom and Joe didnt pay for the food. Who did?','wednesday','6','44849'),
('What begins with T, ends with T and has T in it?','teapot,','7','55031'),
('Marys father has 4 children; three are named Nana, Nene, and Nini. So what is the 4th childs name?','mary','7','55031'),
('What has four legs, but cant walk?','table,chair','7','55031'),
('What body part is pronounced as one letter but written with three, only two different letters are used?','eye','8','59794'),
('What is as big as you are and yet does not weigh anything?','shadow','8','59794'),
('If there are four apples and you take away three, how many do you have?','3,three','8','59794'),
('How many eggs of 10 cm diameter can you put in an empty basket 200cm in diameter?','1,one','9','59877'),
('Complete the sequence 1=3, 3=5, 4=4, 5=4, 12=?','6,six','9','59877'),
('How many months have 28 days?','12,twelve,all','9','59877'),
('find the 12 number in the sequence 0, 1, 1, 2, 3, 5, 8, 13 , ...................','89,eightynine,eighty-nine eighty nine','10','57577'),
('who is the president of india ?','Pranab Mukherjee','10','57577'),
('which is the most played movie on Set Max  ?','Sooryavansham','10','57577');