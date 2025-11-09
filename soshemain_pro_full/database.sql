-- SOSHEMAIN database schema and demo content

DROP TABLE IF EXISTS audit_logs;
DROP TABLE IF EXISTS webhook_logs;
DROP TABLE IF EXISTS settings;
DROP TABLE IF EXISTS contacts;
DROP TABLE IF EXISTS media;
DROP TABLE IF EXISTS shipments;
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS cart_items;
DROP TABLE IF EXISTS carts;
DROP TABLE IF EXISTS addresses;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS shipping_methods;
DROP TABLE IF EXISTS tax_rates;
DROP TABLE IF EXISTS coupons;
DROP TABLE IF EXISTS product_category;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS variants;
DROP TABLE IF EXISTS product_images;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS faqs;
DROP TABLE IF EXISTS testimonials;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS pages;
DROP TABLE IF EXISTS menus;
DROP TABLE IF EXISTS redirects;
DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS team_members;
DROP TABLE IF EXISTS company_values;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(180) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'admin',
  last_login_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  permissions JSON NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE pages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(200) NOT NULL UNIQUE,
  excerpt TEXT,
  body MEDIUMTEXT,
  hero_image VARCHAR(255),
  meta_title VARCHAR(200),
  meta_description VARCHAR(255),
  status ENUM('draft','published') NOT NULL DEFAULT 'published',
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(200) NOT NULL UNIQUE,
  excerpt TEXT,
  body MEDIUMTEXT,
  hero_image VARCHAR(255),
  status ENUM('draft','scheduled','published') NOT NULL DEFAULT 'published',
  published_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  summary VARCHAR(255) NOT NULL,
  description TEXT,
  icon VARCHAR(80),
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  sort_order INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE testimonials (
  id INT AUTO_INCREMENT PRIMARY KEY,
  author_name VARCHAR(150) NOT NULL,
  author_title VARCHAR(150) NOT NULL,
  quote TEXT NOT NULL,
  sort_order INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE faqs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category VARCHAR(100) NOT NULL,
  question VARCHAR(255) NOT NULL,
  answer TEXT NOT NULL,
  sort_order INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE company_values (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  description TEXT NOT NULL,
  sort_order INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE team_members (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  role VARCHAR(150) NOT NULL,
  bio TEXT NOT NULL,
  photo VARCHAR(150) NOT NULL,
  sort_order INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  slug VARCHAR(200) NOT NULL UNIQUE,
  short_description VARCHAR(255),
  description MEDIUMTEXT,
  price DECIMAL(10,2) NOT NULL,
  sku VARCHAR(100) NOT NULL,
  status ENUM('draft','published') NOT NULL DEFAULT 'published',
  featured TINYINT(1) NOT NULL DEFAULT 0,
  stock_status VARCHAR(50) DEFAULT 'In stock',
  tags VARCHAR(255),
  total_sales INT DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  meta_description VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE product_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  path VARCHAR(255) NOT NULL,
  alt VARCHAR(255),
  sort_order INT DEFAULT 0,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE variants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  sku VARCHAR(100) NOT NULL,
  attributes VARCHAR(255) NOT NULL,
  price_override DECIMAL(10,2) NULL,
  stock INT DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  slug VARCHAR(150) NOT NULL UNIQUE,
  type ENUM('product','post') NOT NULL,
  parent_id INT NULL,
  FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE product_category (
  product_id INT NOT NULL,
  category_id INT NOT NULL,
  PRIMARY KEY (product_id, category_id),
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE coupons (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(100) NOT NULL UNIQUE,
  type ENUM('fixed','percent') NOT NULL,
  value DECIMAL(10,2) NOT NULL,
  min_amount DECIMAL(10,2) DEFAULT 0,
  start_at DATETIME NULL,
  end_at DATETIME NULL,
  usage_limit INT NULL,
  usage_count INT DEFAULT 0,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE tax_rates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  country VARCHAR(100) NOT NULL,
  region VARCHAR(100) NULL,
  rate_percent DECIMAL(5,2) NOT NULL,
  is_default TINYINT(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE shipping_methods (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  type ENUM('flat','table','free') NOT NULL,
  cost DECIMAL(10,2) DEFAULT 0,
  min_total DECIMAL(10,2) DEFAULT 0,
  regions JSON NULL,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  sort_order INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(50) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE addresses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  type ENUM('billing','shipping') NOT NULL,
  line1 VARCHAR(255) NOT NULL,
  line2 VARCHAR(255) NULL,
  city VARCHAR(150) NOT NULL,
  region VARCHAR(150) NULL,
  postal_code VARCHAR(30) NOT NULL,
  country VARCHAR(100) NOT NULL,
  FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE carts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NULL,
  session_id VARCHAR(120) NULL,
  total DECIMAL(10,2) DEFAULT 0,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE cart_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cart_id INT NOT NULL,
  product_id INT NOT NULL,
  variant_id INT NULL,
  quantity INT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (variant_id) REFERENCES variants(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NULL,
  order_number VARCHAR(50) NOT NULL UNIQUE,
  customer_name VARCHAR(150) NOT NULL,
  customer_email VARCHAR(150) NOT NULL,
  status ENUM('pending','paid','completed','refunded') NOT NULL DEFAULT 'pending',
  payment_status ENUM('pending','paid','refunded') NOT NULL DEFAULT 'pending',
  total DECIMAL(10,2) NOT NULL,
  tax_total DECIMAL(10,2) DEFAULT 0,
  shipping_total DECIMAL(10,2) DEFAULT 0,
  payment_reference VARCHAR(150) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  variant_id INT NULL,
  name VARCHAR(200) NOT NULL,
  quantity INT NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL,
  FOREIGN KEY (variant_id) REFERENCES variants(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  provider VARCHAR(50) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  status ENUM('pending','paid','refunded') NOT NULL DEFAULT 'pending',
  transaction_id VARCHAR(150) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE shipments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  carrier VARCHAR(100) NOT NULL,
  tracking_number VARCHAR(150) NULL,
  status VARCHAR(100) NOT NULL DEFAULT 'processing',
  shipped_at DATETIME NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE media (
  id INT AUTO_INCREMENT PRIMARY KEY,
  filename VARCHAR(200) NOT NULL,
  mime_type VARCHAR(100) NOT NULL,
  size INT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL,
  company VARCHAR(150) NULL,
  phone VARCHAR(50) NULL,
  message TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(100) NOT NULL UNIQUE,
  `value` TEXT NULL
) ENGINE=InnoDB;

CREATE TABLE webhook_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  provider VARCHAR(50) NOT NULL,
  payload LONGTEXT,
  status_code INT DEFAULT 200,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE audit_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  action VARCHAR(150) NOT NULL,
  context TEXT,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE menus (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  items JSON NOT NULL
) ENGINE=InnoDB;

CREATE TABLE redirects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  source VARCHAR(200) NOT NULL,
  target VARCHAR(200) NOT NULL,
  status_code INT NOT NULL DEFAULT 301
) ENGINE=InnoDB;

CREATE TABLE jobs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  slug VARCHAR(150) NOT NULL UNIQUE,
  location VARCHAR(150) NOT NULL,
  employment_type VARCHAR(100) NOT NULL,
  summary TEXT NOT NULL,
  status ENUM('open','closed') NOT NULL DEFAULT 'open',
  posted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Seed data
INSERT INTO roles (name, permissions) VALUES
('Administrator', '{"cms":true,"commerce":true,"settings":true}'),
('Editor', '{"cms":true,"commerce":false,"settings":false}');

INSERT INTO users (name, email, password, role, last_login_at) VALUES
('Avery Morgan', 'admin@soshemain.com', '$2y$12$1PCQNlTa2pWVp5ADt2lRR.7nNOrGxE7s/3GMK5bzP7ejm6qg7UGLO', 'Administrator', NULL),
('Jordan Lee', 'editor@soshemain.com', '$2y$12$1PCQNlTa2pWVp5ADt2lRR.7nNOrGxE7s/3GMK5bzP7ejm6qg7UGLO', 'Editor', NULL);

INSERT INTO pages (title, slug, excerpt, body, meta_description) VALUES
('About SOSHEMAIN', 'about', 'Innovation studio blending strategy, design, and engineering.', '<p>SOSHEMAIN partners with ambitious teams to build data-backed experiences.</p>', 'About SOSHEMAIN innovation studio'),
('Privacy Policy', 'privacy-policy', 'How we protect your data.', '<p>Your privacy matters to SOSHEMAIN.</p>', 'Privacy policy for SOSHEMAIN'),
('Terms of Service', 'terms-of-service', 'Terms governing our relationship.', '<p>These terms describe the rules for using SOSHEMAIN.</p>', 'SOSHEMAIN terms of service'),
('Returns & Refunds', 'returns-policy', 'How returns and refunds work.', '<p>We aim to make returns straightforward for every customer.</p>', 'SOSHEMAIN returns policy');

INSERT INTO posts (title, slug, excerpt, body, hero_image, published_at) VALUES
('AI and the Future of Customer Experience', 'ai-future-cx', 'How AI is reshaping digital experiences.', '<p>Artificial intelligence is powering every touchpoint.</p>', 'ai-future.jpg', NOW()),
('Design Systems that Accelerate Growth', 'design-systems-growth', 'Build design systems that unlock speed.', '<p>Design systems align teams.</p>', 'design-systems.jpg', NOW()),
('Marketing Automation Playbooks', 'marketing-automation-playbooks', 'Automation that scales personalization.', '<p>Automation drives efficient growth.</p>', 'marketing-automation.jpg', NOW()),
('The Innovation Mindset', 'innovation-mindset', 'Culture that drives experimentation.', '<p>Innovation is a team sport.</p>', 'innovation-mindset.jpg', NOW()),
('Responsible AI Implementation', 'responsible-ai', 'Ethical guardrails for AI.', '<p>Responsible AI keeps humans in control.</p>', 'responsible-ai.jpg', NOW());

INSERT INTO services (title, summary, description, icon, is_featured, sort_order) VALUES
('Growth Strategy Sprints', 'Align leadership around measurable outcomes.', 'Workshops and research to prioritise the highest-impact initiatives.', 'bi-graph-up', 1, 1),
('Experience Design Studio', 'Design customer journeys that convert.', 'UX, UI, and service design for modern products.', 'bi-window-stack', 1, 2),
('Commerce Operations', 'Modernize ecommerce and fulfillment operations.', 'Implementation across Shopify, Magento, and custom stacks.', 'bi-bag-check', 1, 3),
('Performance Marketing Labs', 'Scale acquisition with data-backed experiments.', 'Campaign architecture, attribution, and CRO.', 'bi-broadcast', 1, 4),
('Data Infrastructure', 'Make better decisions with reliable data.', 'Warehousing, dashboards, and analytics workflows.', 'bi-database', 0, 5),
('Automation Engineering', 'Automate operations with AI and RPA.', 'Build intelligent workflows for support and finance.', 'bi-cpu', 0, 6),
('Brand Systems', 'Identity, messaging, and content strategy.', 'Define the storytelling toolkit for your brand.', 'bi-bezier', 0, 7),
('Innovation Advisory', 'Fractional leadership for ambitious teams.', 'Interim CPO, CMO, and CTO support.', 'bi-lightning', 0, 8);

INSERT INTO testimonials (author_name, author_title, quote, sort_order) VALUES
('Jordan Ellis', 'Chief Revenue Officer, Velocity Labs', 'SOSHEMAIN doubled our qualified pipeline in under 90 days.', 1),
('Priya Gupta', 'VP Product, Northwind Apps', 'The team delivered a complete product launch playbook.', 2),
('Leo Kim', 'Founder, Stellar Commerce', 'Their automation work reduced operational overhead by 40%.', 3),
('Maya Thompson', 'CMO, Brightline Health', 'The reimagined brand experience unlocked our next stage of growth.', 4),
('Alicia Romero', 'Head of CX, Horizon Travel', 'We finally have the analytics clarity our executives demanded.', 5),
('Marcus Reed', 'COO, Apex Manufacturing', 'SOSHEMAIN orchestrated our digital transformation roadmap.', 6);

INSERT INTO faqs (category, question, answer, sort_order) VALUES
('services', 'How quickly can a project begin?', 'Discovery can begin in as few as ten business days.', 1),
('services', 'Do you offer retainers?', 'Yes. Growth retainers provide ongoing optimization and experimentation.', 2),
('services', 'What industries do you support?', 'We partner with B2B, B2C, and nonprofit organisations.', 3),
('services', 'How do you handle analytics?', 'We build unified dashboards and reporting workflows.', 4),
('services', 'Can you integrate with our stack?', 'Yes, our engineers work across modern commerce and martech platforms.', 5),
('services', 'How do you secure data?', 'We follow industry best practices and compliance standards.', 6),
('services', 'What is your payment schedule?', 'Engagements typically bill monthly with milestone alignment.', 7),
('services', 'Do you support global teams?', 'Absolutely. Our remote-first model spans multiple time zones.', 8),
('services', 'Can you train our internal team?', 'We provide enablement workshops and documentation.', 9),
('services', 'How do you measure success?', 'Every engagement includes a KPI scorecard aligned to outcomes.', 10),
('services', 'Do you assist with hiring?', 'We help recruit and onboard critical hires during transformation.', 11),
('services', 'Is maintenance included?', 'Yes, we offer ongoing optimisation packages.', 12);

INSERT INTO company_values (title, description, sort_order) VALUES
('Clarity', 'We communicate the why behind every decision.', 1),
('Velocity', 'Speed matters when momentum is on the line.', 2),
('Evidence', 'Every recommendation is backed by insight and data.', 3),
('Craft', 'We obsess over the quality of our craft.', 4),
('Partnership', 'Great outcomes come from working in lockstep.', 5),
('Integrity', 'We protect trust through transparency.', 6);

INSERT INTO team_members (name, role, bio, photo, sort_order) VALUES
('Avery Morgan', 'Founder & CEO', 'Strategist leading transformation programmes.', 'avery-morgan.jpg', 1),
('Camila Ortiz', 'Chief Experience Officer', 'Design leader crafting seamless journeys.', 'camila-ortiz.jpg', 2),
('Ethan Brooks', 'Head of Engineering', 'Builds scalable platforms for ecommerce leaders.', 'ethan-brooks.jpg', 3),
('Noah Patel', 'Director of Data', 'Transforms analytics into everyday decisions.', 'noah-patel.jpg', 4),
('Sofia Bennett', 'VP Growth', 'Creates repeatable demand generation engines.', 'sofia-bennett.jpg', 5),
('Miles Chen', 'Principal Strategist', 'Guides organisations through innovation change.', 'miles-chen.jpg', 6);

INSERT INTO categories (name, slug, type) VALUES
('AI', 'ai', 'post'),
('Marketing', 'marketing', 'post'),
('Design', 'design', 'post'),
('Strategy', 'strategy', 'post'),
('Automation', 'automation', 'product'),
('Analytics', 'analytics', 'product'),
('Experience', 'experience', 'product'),
('Enablement', 'enablement', 'product');

INSERT INTO products (name, slug, short_description, description, price, sku, featured, stock_status, meta_description, total_sales) VALUES
('AI Readiness Blueprint', 'ai-readiness-blueprint', 'Assess and activate AI across your organisation.', '<p>A comprehensive assessment and roadmap.</p>', 799.00, 'AI-BLUEPRINT', 1, 'In stock', 'AI readiness blueprint', 120),
('Commerce Conversion Toolkit', 'commerce-conversion-toolkit', 'Optimization playbooks for ecommerce teams.', '<p>Testing sequences, messaging templates, and dashboards.</p>', 499.00, 'COM-TOOLKIT', 1, 'In stock', 'Conversion toolkit for commerce teams', 95),
('Experience Research Sprint', 'experience-research-sprint', 'Two-week discovery to align your product roadmap.', '<p>Mixed-method research to surface critical insights.</p>', 2899.00, 'EXP-RESEARCH', 1, 'Limited', 'Experience research sprint', 40),
('Lifecycle Automation Canvas', 'lifecycle-automation-canvas', 'Turnkey automation workflows for retention.', '<p>Email, SMS, and in-app sequences.</p>', 699.00, 'LIFE-AUTO', 0, 'In stock', 'Lifecycle automation kit', 60),
('Data Foundation Jumpstart', 'data-foundation-jumpstart', 'Launch your analytics warehouse in 30 days.', '<p>Blueprint, connectors, and dashboards.</p>', 3499.00, 'DATA-JUMP', 0, 'In stock', 'Data foundation jumpstart', 30),
('CX Diagnostics Audit', 'cx-diagnostics-audit', 'Holistic review of your customer experience.', '<p>Uncover quick wins and long-term improvements.</p>', 1299.00, 'CX-AUDIT', 1, 'In stock', 'Customer experience diagnostics audit', 55),
('Innovation Governance Playbook', 'innovation-governance-playbook', 'Frameworks to manage experimentation at scale.', '<p>Governance templates and training modules.</p>', 399.00, 'INNOV-GOV', 0, 'In stock', 'Innovation governance guide', 20),
('Marketing Analytics Dashboard Pack', 'marketing-analytics-dashboard-pack', 'Ready-to-use dashboards for campaign performance.', '<p>Connect to your data sources in minutes.</p>', 599.00, 'MKT-DASH', 0, 'In stock', 'Marketing analytics dashboards', 47),
('Customer Journey Workshop', 'customer-journey-workshop', 'Facilitated session to map and improve journeys.', '<p>Full-day collaborative workshop.</p>', 2499.00, 'CJ-WORKSHOP', 1, 'In stock', 'Customer journey workshop', 33),
('Team Enablement Series', 'team-enablement-series', 'Six-week enablement programme for internal teams.', '<p>Upskill your organisation with hands-on training.</p>', 2199.00, 'ENABLE-SERIES', 0, 'In stock', 'Team enablement series', 18);

INSERT INTO product_images (product_id, path, alt, sort_order) VALUES
(1, 'ai-readiness-blueprint-1.jpg', 'AI readiness blueprint cover', 1),
(2, 'commerce-conversion-toolkit-1.jpg', 'Conversion toolkit', 1),
(3, 'experience-research-sprint-1.jpg', 'Research sprint', 1),
(4, 'lifecycle-automation-canvas-1.jpg', 'Automation canvas', 1),
(5, 'data-foundation-jumpstart-1.jpg', 'Data foundation', 1),
(6, 'cx-diagnostics-audit-1.jpg', 'CX audit', 1),
(7, 'innovation-governance-playbook-1.jpg', 'Innovation playbook', 1),
(8, 'marketing-analytics-dashboard-pack-1.jpg', 'Analytics dashboard', 1),
(9, 'customer-journey-workshop-1.jpg', 'Journey workshop', 1),
(10, 'team-enablement-series-1.jpg', 'Enablement series', 1);

INSERT INTO variants (product_id, sku, attributes, price_override, stock) VALUES
(1, 'AI-BLUEPRINT-TEAM', 'Team license', 999.00, 15),
(1, 'AI-BLUEPRINT-ENTERPRISE', 'Enterprise license', 1499.00, 10),
(2, 'COM-TOOLKIT-PLUS', 'Plus edition', 699.00, 30),
(3, 'EXP-RESEARCH-VIRTUAL', 'Virtual delivery', 2799.00, 5),
(3, 'EXP-RESEARCH-ONSITE', 'Onsite delivery', 3299.00, 4),
(4, 'LIFE-AUTO-PLUS', 'Plus package', NULL, 25),
(6, 'CX-AUDIT-EXPRESS', 'Express audit', 999.00, 20),
(8, 'MKT-DASH-TEAM', 'Team license', 799.00, 25),
(9, 'CJ-WORKSHOP-VIRTUAL', 'Virtual workshop', 2299.00, 8),
(9, 'CJ-WORKSHOP-ONSITE', 'Onsite workshop', 2699.00, 6);

INSERT INTO product_category (product_id, category_id) VALUES
(1, 5),(2,5),(3,7),(4,5),(5,6),(6,7),(7,6),(8,6),(9,7),(10,8);

INSERT INTO coupons (code, type, value, min_amount, start_at, end_at, usage_limit, status) VALUES
('WELCOME20', 'percent', 20, 200, NOW(), DATE_ADD(NOW(), INTERVAL 90 DAY), 200, 'active'),
('VIP100', 'fixed', 100, 500, NOW(), DATE_ADD(NOW(), INTERVAL 120 DAY), 100, 'active'),
('SPRING25', 'percent', 25, 300, NOW(), DATE_ADD(NOW(), INTERVAL 60 DAY), 150, 'active'),
('FREESHIP', 'fixed', 50, 0, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), NULL, 'active'),
('LOYALTY15', 'percent', 15, 150, NOW(), DATE_ADD(NOW(), INTERVAL 180 DAY), NULL, 'active');

INSERT INTO tax_rates (name, country, region, rate_percent, is_default) VALUES
('US Standard Tax', 'United States', 'MA', 7.50, 1);

INSERT INTO shipping_methods (name, type, cost, min_total, status, sort_order) VALUES
('Standard Shipping', 'flat', 15.00, 0, 'active', 1),
('Free Shipping', 'free', 0.00, 500, 'active', 2);

INSERT INTO customers (name, email, phone) VALUES
('Harper Lewis', 'harper.lewis@example.com', '+1-617-555-0101'),
('Isla Turner', 'isla.turner@example.com', '+1-617-555-0102'),
('Carter Hughes', 'carter.hughes@example.com', '+1-617-555-0103'),
('Rowan Blake', 'rowan.blake@example.com', '+1-617-555-0104'),
('Nova Bryant', 'nova.bryant@example.com', '+1-617-555-0105');

INSERT INTO addresses (customer_id, type, line1, city, region, postal_code, country) VALUES
(1, 'billing', '500 Innovation Way', 'Boston', 'MA', '02110', 'USA'),
(1, 'shipping', '500 Innovation Way', 'Boston', 'MA', '02110', 'USA'),
(2, 'billing', '120 Market Street', 'San Francisco', 'CA', '94103', 'USA'),
(3, 'billing', '45 Ocean Ave', 'Miami', 'FL', '33139', 'USA'),
(4, 'billing', '88 King Street', 'Seattle', 'WA', '98101', 'USA'),
(5, 'billing', '12 Harbor Blvd', 'Chicago', 'IL', '60606', 'USA');

INSERT INTO orders (customer_id, order_number, customer_name, customer_email, status, payment_status, total, tax_total, shipping_total, payment_reference, created_at) VALUES
(1, 'SO-1001', 'Harper Lewis', 'harper.lewis@example.com', 'completed', 'paid', 3056.35, 142.35, 15.00, 'cs_demo_1001', DATE_SUB(NOW(), INTERVAL 20 DAY)),
(2, 'SO-1002', 'Isla Turner', 'isla.turner@example.com', 'paid', 'paid', 873.93, 59.93, 15.00, 'cs_demo_1002', DATE_SUB(NOW(), INTERVAL 14 DAY)),
(3, 'SO-1003', 'Carter Hughes', 'carter.hughes@example.com', 'pending', 'pending', 3776.43, 262.43, 15.00, 'cs_demo_1003', DATE_SUB(NOW(), INTERVAL 7 DAY)),
(4, 'SO-1004', 'Rowan Blake', 'rowan.blake@example.com', 'refunded', 'refunded', 536.43, 37.43, 0.00, 'cs_demo_1004', DATE_SUB(NOW(), INTERVAL 3 DAY));

INSERT INTO order_items (order_id, product_id, name, quantity, unit_price) VALUES
(1, 3, 'Experience Research Sprint', 1, 2899.00),
(2, 1, 'AI Readiness Blueprint', 1, 799.00),
(3, 5, 'Data Foundation Jumpstart', 1, 3499.00),
(4, 2, 'Commerce Conversion Toolkit', 1, 499.00);

INSERT INTO payments (order_id, provider, amount, status, transaction_id) VALUES
(1, 'stripe', 3056.35, 'paid', 'pi_1001'),
(2, 'stripe', 873.93, 'paid', 'pi_1002'),
(3, 'paypal', 3776.43, 'pending', 'pay_1003'),
(4, 'paypal', 536.43, 'refunded', 'pay_1004');

INSERT INTO shipments (order_id, carrier, tracking_number, status, shipped_at) VALUES
(1, 'FedEx', 'FDX123456', 'delivered', DATE_SUB(NOW(), INTERVAL 15 DAY)),
(2, 'UPS', '1Z999999', 'in_transit', DATE_SUB(NOW(), INTERVAL 10 DAY));

INSERT INTO contacts (name, email, company, phone, message, created_at) VALUES
('Mira Collins', 'mira.collins@example.com', 'Arcadia Ventures', '+1-617-555-0201', 'Interested in an AI readiness workshop.', NOW()),
('Elias Brown', 'elias.brown@example.com', 'Nimbus Retail', '+1-617-555-0202', 'Need help with conversion optimisation.', NOW());

INSERT INTO settings (`key`, `value`) VALUES
('site_name', 'SOSHEMAIN'),
('site_tagline', 'Innovation that drives results.'),
('support_email', 'hello@soshemain.com'),
('business_hours', 'Mon–Fri 9:00–18:00 EST'),
('primary_color', '#2563EB'),
('secondary_color', '#111827'),
('address', '500 Innovation Way, Boston, MA');

INSERT INTO webhook_logs (provider, payload, status_code) VALUES
('stripe', '{}', 200),
('paypal', '{}', 200);

INSERT INTO audit_logs (user_id, action, context) VALUES
(1, 'login', 'Administrator logged in'),
(1, 'update_settings', 'Updated site tagline');

INSERT INTO menus (name, items) VALUES
('primary', '[{"label":"Home","url":"/index.php"},{"label":"Services","url":"/services.php"},{"label":"Products","url":"/products.php"},{"label":"Blog","url":"/blog.php"}]');

INSERT INTO redirects (source, target, status_code) VALUES
('/old-services', '/services.php', 301);

INSERT INTO jobs (title, slug, location, employment_type, summary, status) VALUES
('Senior Product Strategist', 'senior-product-strategist', 'Remote - North America', 'Full-time', 'Lead discovery and strategy engagements for enterprise clients.', 'open'),
('Lifecycle Marketing Manager', 'lifecycle-marketing-manager', 'Boston, MA', 'Hybrid', 'Own retention marketing programmes and experimentation.', 'open'),
('Commerce Solutions Architect', 'commerce-solutions-architect', 'Remote - US', 'Full-time', 'Design and implement modern commerce architectures.', 'open');

INSERT INTO media (filename, mime_type, size) VALUES
('hero-collage.jpg', 'image/jpeg', 245678),
('about-team.jpg', 'image/jpeg', 198234);

