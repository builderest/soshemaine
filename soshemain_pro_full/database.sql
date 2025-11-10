-- SOSHEMAIN database schema and seed data
SET NAMES utf8mb4;
SET time_zone = '+00:00';

DROP TABLE IF EXISTS audit_log;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS contacts;
DROP TABLE IF EXISTS media;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS portfolio;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS testimonials;
DROP TABLE IF EXISTS stats;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS pages;
DROP TABLE IF EXISTS menus;
DROP TABLE IF EXISTS settings;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(60) NOT NULL DEFAULT 'admin',
  permissions JSON DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(120) UNIQUE NOT NULL,
  `value` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE menus (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  location VARCHAR(60) NOT NULL,
  items JSON NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(160) NOT NULL UNIQUE,
  excerpt TEXT,
  hero JSON NULL,
  sections JSON NULL,
  seo JSON NULL,
  status ENUM('draft','published') DEFAULT 'draft',
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(220) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  excerpt TEXT,
  content LONGTEXT,
  categories VARCHAR(200) DEFAULT NULL,
  tags VARCHAR(200) DEFAULT NULL,
  featured_image VARCHAR(255) DEFAULT NULL,
  author VARCHAR(120) DEFAULT 'Team',
  status ENUM('draft','published','scheduled') DEFAULT 'draft',
  published_at DATETIME DEFAULT NULL,
  meta JSON NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  description TEXT,
  icon VARCHAR(120) DEFAULT 'bi-stars',
  status ENUM('draft','published') DEFAULT 'draft',
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  description LONGTEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  sku VARCHAR(100) DEFAULT NULL,
  stock INT DEFAULT 0,
  status ENUM('draft','published') DEFAULT 'draft',
  featured TINYINT(1) DEFAULT 0,
  gallery JSON NULL,
  variants JSON NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE portfolio (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(200) UNIQUE,
  category VARCHAR(100),
  description MEDIUMTEXT,
  thumbnail VARCHAR(255),
  images JSON,
  video_url VARCHAR(255),
  client VARCHAR(150),
  link VARCHAR(255),
  featured TINYINT(1) DEFAULT 0,
  status ENUM('draft','published') DEFAULT 'published',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE media (
  id INT AUTO_INCREMENT PRIMARY KEY,
  filename VARCHAR(255) NOT NULL,
  mime VARCHAR(120) NOT NULL,
  size INT NOT NULL,
  alt VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  email VARCHAR(160) NOT NULL,
  message TEXT NOT NULL,
  status ENUM('new','in_progress','done') DEFAULT 'new',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_number VARCHAR(60) NOT NULL,
  status ENUM('pending','paid','failed') DEFAULT 'pending',
  total_amount DECIMAL(10,2) DEFAULT 0,
  customer_email VARCHAR(160) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE testimonials (
  id INT AUTO_INCREMENT PRIMARY KEY,
  quote TEXT NOT NULL,
  author VARCHAR(160) NOT NULL,
  role VARCHAR(160) DEFAULT NULL,
  status ENUM('draft','published') DEFAULT 'published',
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE stats (
  id INT AUTO_INCREMENT PRIMARY KEY,
  label VARCHAR(160) NOT NULL,
  value VARCHAR(120) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE audit_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  entity VARCHAR(120) NOT NULL,
  entity_id INT NULL,
  action VARCHAR(60) NOT NULL,
  changes JSON NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed data
INSERT INTO users (name, email, password, role) VALUES
('Site Admin', 'admin@soshemaine.net', '$2y$12$B1ZaM9EXeZ66muV8izfgOu3QJbMkqN1ZN7lDM6hpk4/nNytQQoewW', 'admin');

INSERT INTO settings (`key`, `value`) VALUES
('company_name', 'SOSHEMAIN'),
('company_email', 'hello@soshemaine.net'),
('company_phone', '+1 207 555 0199'),
('company_address', '123 Innovation Way, Portland, ME'),
('theme_default', 'dark'),
('brand_colors', '{"primary":"#e91e63","secondary":"#0b0f19"}'),
('font_primary', 'Inter'),
('meta_description', 'SOSHEMAIN partners with leaders to deliver modern digital products and services.'),
('social_links', '[{"platform":"LinkedIn","url":"https://linkedin.com/company/soshemaine"},{"platform":"Twitter","url":"https://twitter.com/soshemaine"}]');

INSERT INTO menus (name, location, items) VALUES
('Primary navigation', 'primary', '[{"label":"Home","url":"/index.php"},{"label":"About","url":"/about.php"},{"label":"Services","url":"/services.php"},{"label":"Portfolio","url":"/portfolio.php"},{"label":"Products","url":"/products.php"},{"label":"Blog","url":"/blog.php"},{"label":"Contact","url":"/contact.php"}]'),
('Footer navigation', 'footer', '[{"label":"Careers","url":"/careers.php"},{"label":"Privacy","url":"/privacy.php"},{"label":"Terms","url":"/terms.php"},{"label":"Returns","url":"/returns.php"}]');

INSERT INTO pages (title, slug, excerpt, hero, sections, seo, status, sort_order) VALUES
('Home', 'home', 'Modern strategy for Maine organizations',
  '{"title":"Build meaningful digital experiences","subtitle":"SOSHEMAIN blends strategy, creativity, and technology to accelerate your growth.","cta":{"label":"Start project","url":"contact.php"}}',
  '[{"title":"Strategic transformation","body":"Pair executive vision with digital expertise to unlock new growth opportunities.","cta":{"label":"See services","url":"services.php"},"image":"images/hero-team.svg"}]',
  '{"meta_title":"Home","meta_description":"SOSHEMAIN is a full-service digital partner for ambitious teams."}',
  'published', 1),
('About', 'about', 'Get to know the team behind SOSHEMAIN.', NULL, NULL, '{"meta_title":"About","meta_description":"Learn about the people and mission guiding SOSHEMAIN."}', 'published', 2),
('Services', 'services', 'Solutions designed to scale impact.', NULL, NULL, '{"meta_title":"Services","meta_description":"Explore SOSHEMAIN consulting and delivery services."}', 'published', 3),
('Products', 'products', 'Modular products to accelerate transformation.', NULL, NULL, '{"meta_title":"Products","meta_description":"Browse SOSHEMAIN productized service offerings."}', 'published', 4),
('Contact', 'contact', 'Start a project conversation with our team.', NULL, NULL, '{"meta_title":"Contact","meta_description":"Connect with SOSHEMAIN consultants."}', 'published', 5),
('404', '404', 'We could not find the page requested.', NULL, NULL, '{"meta_title":"Page not found"}', 'published', 99);

INSERT INTO posts (title, slug, excerpt, content, categories, tags, status, published_at, author, meta) VALUES
('Five principles for human-centered transformation', 'human-centered-transformation', 'How we guide organizations toward better digital outcomes.', '<p>Transformation succeeds when teams start with empathy, iterate with evidence, and stay aligned on outcomes.</p>', 'Strategy', 'transformation,design', 'published', '2024-05-10 09:00:00', 'Avery Collins', '{"og_image":"images/blog-placeholder.svg"}'),
('Building resilient digital teams in public sector', 'resilient-digital-teams', 'What Maine agencies can learn from modern delivery practices.', '<p>Digital services thrive when empowered cross-functional teams can ship, learn, and adapt quickly.</p>', 'Public Sector', 'teams,delivery', 'published', '2024-04-18 09:00:00', 'Morgan Ellis', '{"og_image":"images/blog-placeholder.svg"}'),
('Why modular product ops accelerate ROI', 'modular-product-ops', 'Operational discipline turns ideas into continuous value.', '<p>Modular product operations bring clarity to portfolios and help teams invest in what works.</p>', 'Operations', 'product,ops', 'published', '2024-03-06 09:00:00', 'Riley Hart', '{"og_image":"images/blog-placeholder.svg"}');

INSERT INTO services (name, description, icon, status, sort_order) VALUES
('Digital strategy &amp; roadmapping', 'Align leaders around a clear vision, north star metrics, and an executable roadmap.', 'bi-bezier', 'published', 1),
('Product discovery sprints', 'Rapid discovery engagements uncover user needs, validate solutions, and de-risk investment.', 'bi-lightning-charge', 'published', 2),
('Experience design systems', 'Establish accessible design languages, component libraries, and governance frameworks.', 'bi-columns-gap', 'published', 3),
('Modern engineering enablement', 'Upskill teams in DevOps, CI/CD, and cloud-native patterns to accelerate delivery.', 'bi-cpu', 'published', 4),
('Data &amp; insight activation', 'Turn raw data into actionable insight with modern data platforms and analytics.', 'bi-graph-up', 'published', 5),
('Change management coaching', 'Equip leaders and teams with the playbooks to sustain transformation momentum.', 'bi-people', 'published', 6);

INSERT INTO products (name, slug, description, price, sku, stock, status, featured, gallery, variants) VALUES
('Strategic Advisory Package', 'strategic-advisory-package', '<p>A six-week engagement to define your digital strategy, prioritize initiatives, and align your leadership team.</p>', 2499.00, 'SAP-001', 10, 'published', 1, '["images/product-placeholder.svg"]', '[{"name":"Executive workshop","price":699.00},{"name":"Leadership coaching","price":899.00}]'),
('Implementation Sprint', 'implementation-sprint', '<p>Cross-functional experts design, build, and launch a pilot in 30 days using agile delivery practices.</p>', 1299.00, 'IMS-002', 12, 'published', 1, '["images/product-placeholder.svg"]', '[]'),
('Customer Journey Mapping Lab', 'customer-journey-mapping-lab', '<p>Interactive workshops to uncover friction, illuminate opportunities, and prioritize service improvements.</p>', 1599.00, 'CJM-003', 8, 'published', 0, '["images/product-placeholder.svg"]', '[]');

INSERT INTO portfolio (title, slug, category, description, thumbnail, images, video_url, client, link, featured, status, created_at) VALUES
('Maine Service Blueprint Initiative', 'maine-service-blueprint', 'Public Sector', '<p>We partnered with statewide program leaders to align teams, capture citizen journeys, and deploy a responsive services portal in twelve weeks.</p>', 'portfolio-strategy.svg', '["portfolio-strategy.svg","portfolio-platform.svg"]', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'State of Maine Digital Services', 'https://example.com/blueprint', 1, 'published', '2024-05-12 09:00:00'),
('Pine Harbor Telehealth Launch', 'pine-harbor-telehealth-launch', 'Healthcare', '<p>Clinicians, designers, and engineers co-created a HIPAA-compliant telehealth experience that expanded access across rural communities.</p>', 'portfolio-lab.svg', '["portfolio-lab.svg","portfolio-strategy.svg"]', 'https://vimeo.com/76979871', 'Pine Harbor Health', 'https://example.com/telehealth', 1, 'published', '2024-04-04 10:30:00'),
('Coastal Credit Experience Platform', 'coastal-credit-experience-platform', 'Financial Services', '<p>A modular design system, modern APIs, and personalized insights increased adoption and satisfaction for members statewide.</p>', 'portfolio-platform.svg', '["portfolio-platform.svg","portfolio-lab.svg"]', '', 'Coastal Credit Union', 'https://example.com/platform', 1, 'published', '2024-03-15 14:00:00');

INSERT INTO testimonials (quote, author, role, status, sort_order) VALUES
('SOSHEMAIN gave our statewide program the clarity and momentum it needed to launch successfully.', 'Jordan Michaels', 'Director of Digital Services, Maine DHHS', 'published', 1),
('From discovery to delivery, the team unlocked collaboration across departments we thought impossible.', 'Casey Lee', 'Chief Operating Officer, Pine Harbor Health', 'published', 2),
('Their coaching helped our leaders steward change with confidence and measurable results.', 'Taylor Nguyen', 'VP Innovation, Coastal Credit Union', 'published', 3);

INSERT INTO stats (label, value) VALUES
('Projects delivered', '120+'),
('Transformation specialists', '45'),
('Average NPS', '72'),
('Client retention', '94%');

INSERT INTO orders (order_number, status, total_amount, customer_email) VALUES
('SO-1025', 'paid', 2499.00, 'client@example.com'),
('SO-1008', 'pending', 1299.00, 'teams@example.com');

INSERT INTO contacts (name, email, message, status) VALUES
('Jesse Carter', 'jesse@maine.gov', 'Interested in a discovery sprint for our permitting portal.', 'in_progress'),
('Priya Desai', 'priya@northcoast.io', 'Would love to talk about design system support.', 'new');

INSERT INTO media (filename, mime, size, alt) VALUES
('hero-team.svg', 'image/svg+xml', 2048, 'Team illustration'),
('product-placeholder.svg', 'image/svg+xml', 2048, 'Product placeholder');

