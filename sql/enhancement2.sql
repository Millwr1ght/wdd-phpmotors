USE phpmotors;

-- add tony stark to the client table
INSERT INTO client (first_name, last_name, email, password, comment)
VALUES ('Tony', 'Stark', 'tony@starkent.com', 'Iam1ronM@n', 'I am the real Ironman');

-- update tony stark's client level
UPDATE client
SET clientLevel = '3'
WHERE first_name = 'Tony' AND last_name = 'Stark';

-- modify GM Hummer description to read 'spacious interior' with one query
UPDATE inventory
SET invDescription = replace(invDescription, 'small interior', 'spacious interior')
WHERE invMake = 'GM' and invModel = 'Hummer';

-- use an INNER JOIN to SELECT the invModel field from the inventory 
-- table and the classificationName field from the carclassification table
-- for items that belong to the SUV category
SELECT i.invModel, c.classificationName
FROM inventory i INNER JOIN carclassification c
ON i.classificationID = c.classificationID
WHERE c.classificationName = 'SUV';

-- drop the jeep wrangler
DELETE FROM inventory
WHERE invMake = 'Jeep' AND invModel = 'Wrangler';

-- use update to prepend '/phpmotors' to each image file path on the inventory table
UPDATE inventory
SET invImage = CONCAT('/phpmotors', invImage), invThumbnail = CONCAT('/phpmotors', invThumbnail)
WHERE 1;