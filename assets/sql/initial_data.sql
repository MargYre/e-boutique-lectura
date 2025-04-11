-- Catégories
INSERT INTO category (name, slug) VALUES 
('Roman', 'roman'),
('BD', 'bd'),
('Scolaire', 'scolaire');

-- Livres Romans
INSERT INTO book (title, author, price, description, stock, category_id) VALUES
('Le Petit Prince', 'Antoine de Saint-Exupéry', 12.50, 'Un classique sur l\'amitié et la poésie du regard', 25, 1),
('L\'Étranger', 'Albert Camus', 9.90, 'Roman existentialiste sur l\'absurdité de la vie', 18, 1),
('La Nuit des temps', 'René Barjavel', 14.99, 'Science-fiction et amour tragique sous la glace', 12, 1);

-- Livres BD
INSERT INTO book (title, author, price, description, stock, category_id) VALUES
('Astérix chez les Bretons', 'Goscinny et Uderzo', 10.90, 'Astérix et Obélix partent en Bretagne moderne', 30, 2),
('Persepolis', 'Marjane Satrapi', 18.00, 'Récit autobiographique d\'une enfance en Iran', 15, 2),
('Le Château des étoiles', 'Alex Alice', 13.50, 'Steampunk et aventure spatiale au XIXe siècle', 22, 2);

-- Livres Scolaires
INSERT INTO book (title, author, price, description, stock, category_id) VALUES
('Mathématiques 3ème', 'Collectif Hatier', 19.99, 'Manuel conforme au programme 2024', 40, 3),
('Bescherelle Français', 'Louis-Nicolas Bescherelle', 8.90, 'Grammaire, conjugaison et orthographe', 35, 3),
('Atlas du Monde', 'National Geographic', 24.50, 'Cartes physiques et politiques actualisées', 10, 3);