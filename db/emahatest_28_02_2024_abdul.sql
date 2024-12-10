
CREATE TABLE quizs(
    id int AUTO_INCREMENT PRIMARY KEY,
    section_id int(11),
    section varchar(50),
    title varchar(120),
    image_url varchar(200),
    pdf_url varchar(200),
    can_download varchar(10),
    no_of_question int(10),
    marks_per_question int(10),
    total_mark int(10),
    `time` int(10),
    description text,
    attempt_count int(11) DEFAULT null,
    `status` varchar(20) NULL COMMENT 'Active / Inactive' DEFAULT NULL,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE questions(
	id int(11) AUTO_INCREMENT PRIMARY KEY,
    quiz_id int(11) DEFAULT NULL,
    question varchar(200),
    option1 varchar(200) DEFAULT NULL,
    option2 varchar(200) DEFAULT NULL,
    option3 varchar(200) DEFAULT NULL,
    option4 varchar(200) DEFAULT NULL,
    answer varchar(200) DEFAULT NULL,
    `status` varchar(20) NULL COMMENT 'Active / Inactive' DEFAULT NULL,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime DEFAULT CURRENT_TIMESTAMP
);