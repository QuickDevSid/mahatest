ALTER TABLE docs_videos
    ADD COLUMN num_of_questions int(100) DEFAULT NULL AFTER views_count;
CREATE TABLE courses(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(120),
    description TEXT,
    sub_headings VARCHAR(120),
    banner_image VARCHAR(120),
    mrp VARCHAR(200),
    sale_price VARCHAR(120),
    discount VARCHAR(120),
    `status` varchar(20) DEFAULT 'Active',
    usage_count int DEFAULT 0,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE docs_videos
    add COLUMN course_id int(11) DEFAULT NULL;

