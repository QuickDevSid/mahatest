ALTER TABLE docs_videos
    add COLUMN source_type varchar(50) DEFAULT NULL AFTER type;