#city
INSERT INTO city (`name`,`zipcode`) VALUES ("Marrakech","42312");
INSERT INTO city (`name`,`zipcode`) VALUES ("Casablanca","23145");
INSERT INTO city (`name`,`zipcode`) VALUES ("Safi","39032");
#user
INSERT INTO user (`city_id_id`,`username`,`password`) VALUES (1,"mohammedchoulla","choulla");
INSERT INTO user (`city_id_id`,`username`,`password`) VALUES (2,"ousamarachid","ousama");
INSERT INTO user (`city_id_id`,`username`,`password`) VALUES (3,"ngolokante","kante");
#restaurant
INSERT INTO restaurant (`city_id_id`,`name`,`description`) VALUES (1,"dary food","the one and only marrakech restaurant you can find him in elmassira");
INSERT INTO restaurant (`city_id_id`,`name`,`description`) VALUES (1,"fast and furious","e Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard ");
INSERT INTO restaurant (`city_id_id`,`name`,`description`) VALUES (2,"fasiya","l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre");
INSERT INTO restaurant (`city_id_id`,`name`,`description`) VALUES (3,"addarisa restau"," mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années");
#restaurant_picture
INSERT INTO restaurant_picture (`restaurant_id_id`,`filename`) VALUES (1,"r1.jpg");
INSERT INTO restaurant_picture (`restaurant_id_id`,`filename`) VALUES (2,"r2.jpg");
INSERT INTO restaurant_picture (`restaurant_id_id`,`filename`) VALUES (3,"r3.jpg");
INSERT INTO restaurant_picture (`restaurant_id_id`,`filename`) VALUES (4,"r4.jpg");
#review
INSERT INTO review (`restaurant_id_id`,`user_id_id`,`message`,`rating`) VALUES (1,1,"Les tacos sont bons mais évitez les salades et les frites sont trop salées, bon service",3);
INSERT INTO review (`restaurant_id_id`,`user_id_id`,`message`,`rating`) VALUES (2,3,"Super déçu de ce snack. On avait envie de casser la croûte on a commandé des tacos et composés une salade et grosse déception ! Frites à l'intérieur froides et salade pas fraîche avec une sauce qui pue l'ail! Je ne le recommande pas!",4);
INSERT INTO review (`restaurant_id_id`,`user_id_id`,`message`,`rating`) VALUES (3,2,"Cadre agréable, service impeccable et plats très bien faits.",4);
INSERT INTO review (`restaurant_id_id`,`user_id_id`,`message`,`rating`) VALUES (4,1,"Un bon couscous vendredi. Prix abordable",4);