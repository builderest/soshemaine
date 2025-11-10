CREATE DATABASE IF NOT EXISTS `soshemain` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `soshemain`;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(60) NOT NULL DEFAULT 'admin',
  status ENUM('active','inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE,
  permissions JSON NULL
);

DROP TABLE IF EXISTS pages;
CREATE TABLE pages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  slug VARCHAR(160) NOT NULL UNIQUE,
  content LONGTEXT,
  featured_image VARCHAR(255) NULL,
  meta_title VARCHAR(180) NULL,
  meta_desc TEXT NULL,
  schema_json LONGTEXT NULL,
  status ENUM('draft','published') DEFAULT 'published',
  updated_at DATETIME NULL
);

DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  slug VARCHAR(160) NOT NULL UNIQUE,
  type ENUM('product','post') DEFAULT 'product',
  meta_data JSON NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS products;
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(180) NOT NULL,
  slug VARCHAR(160) NOT NULL UNIQUE,
  description LONGTEXT,
  price DECIMAL(10,2) DEFAULT 0,
  sku VARCHAR(120) NOT NULL,
  stock INT DEFAULT 0,
  category_id INT NULL,
  images JSON NULL,
  featured TINYINT(1) DEFAULT 0,
  meta_title VARCHAR(180) NULL,
  meta_desc TEXT NULL,
  meta_json LONGTEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

DROP TABLE IF EXISTS posts;
CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  excerpt TEXT,
  content LONGTEXT,
  author_id INT NULL,
  cover VARCHAR(255) NULL,
  status ENUM('draft','published') DEFAULT 'published',
  meta_title VARCHAR(180) NULL,
  meta_desc TEXT NULL,
  published_at DATETIME NULL,
  FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

DROP TABLE IF EXISTS media;
CREATE TABLE media (
  id INT AUTO_INCREMENT PRIMARY KEY,
  file_name VARCHAR(200) NOT NULL,
  alt VARCHAR(200) NULL,
  width INT DEFAULT 0,
  height INT DEFAULT 0,
  mime VARCHAR(120) NULL,
  size INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS contacts;
CREATE TABLE contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  email VARCHAR(160) NOT NULL,
  phone VARCHAR(60) NULL,
  message TEXT NOT NULL,
  source VARCHAR(80) DEFAULT 'website',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  handled_by INT NULL,
  status VARCHAR(40) DEFAULT 'nuevo',
  FOREIGN KEY (handled_by) REFERENCES users(id) ON DELETE SET NULL
);

DROP TABLE IF EXISTS settings;
CREATE TABLE settings (
  `key` VARCHAR(120) PRIMARY KEY,
  `value` LONGTEXT NULL
);

DROP TABLE IF EXISTS menus;
CREATE TABLE menus (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  items JSON NULL
);

DROP TABLE IF EXISTS redirects;
CREATE TABLE redirects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  from_path VARCHAR(180) NOT NULL,
  to_path VARCHAR(180) NOT NULL,
  code INT DEFAULT 301
);

DROP TABLE IF EXISTS jobs;
CREATE TABLE jobs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  area VARCHAR(120) NOT NULL,
  type VARCHAR(80) NOT NULL,
  location VARCHAR(160) NOT NULL,
  description LONGTEXT,
  apply_email VARCHAR(160) NOT NULL,
  status ENUM('open','closed') DEFAULT 'open',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO roles (name, permissions) VALUES
('admin', JSON_OBJECT('users', true, 'pages', true, 'products', true, 'posts', true, 'settings', true)),
('editor', JSON_OBJECT('pages', true, 'posts', true));

INSERT INTO users (name, email, password, role) VALUES
('Administrador SOSHEMAIN', 'admin@soshemain.com', '$2y$10$62yocOITkkpFmS6r30YIOCwRvDDDeWGPAHDq6cHruM3aMc2SGIN1C', 'admin');

INSERT INTO settings (`key`, `value`) VALUES
('site_name', 'SOSHEMAIN'),
('logo', ''),
('favicon', ''),
('primary_color', '#0EA5E9'),
('secondary_color', '#111827'),
('accent_color', '#F59E0B'),
('meta_description', 'Innovación que impulsa resultados.'),
('address', 'Av. Paseo de la Reforma 123, Ciudad de México'),
('phone', '+52 55 1234 5678'),
('email', 'hola@soshemain.com'),
('schedule', 'Lunes a viernes 09:00 - 18:00'),
('whatsapp', '+52 55 9876 5432'),
('analytics_id', 'G-XXXXXX'),
('maintenance_mode', 'off'),
('social_links', JSON_OBJECT('LinkedIn','https://linkedin.com/company/soshemain','Instagram','https://instagram.com/soshemain','YouTube','https://youtube.com/@soshemain')),
('footer_intro', 'Innovación que impulsa resultados con estrategias digitales y soluciones tecnológicas a medida.'),
('testimonials', JSON_ARRAY(
    JSON_OBJECT('name','María Ortega','company','Aurora Ventures','industry','Tecnología','quote','SOSHEMAIN articuló una estrategia digital integral que multiplicó por dos nuestro pipeline en cuatro meses.'),
    JSON_OBJECT('name','Julián Herrera','company','Atlas Retail','industry','Retail','quote','La integración de canales y la automatización nos dieron visibilidad total y crecimiento sostenible.'),
    JSON_OBJECT('name','Diana Ruiz','company','Harmonia Health','industry','Salud','quote','El equipo de SOSHEMAIN entiende el negocio, los datos y el diseño de experiencias.'),
    JSON_OBJECT('name','Carlos Méndez','company','Lumen Energy','industry','Energía','quote','Su acompañamiento nos permitió lanzar una plataforma digital B2B en tiempo récord.')
)),
('faqs', JSON_ARRAY(
    JSON_OBJECT('question','¿Qué incluye una consultoría integral de SOSHEMAIN?','answer','Diagnóstico, roadmap estratégico, diseño de experiencias, implementación tecnológica y medición continua.'),
    JSON_OBJECT('question','¿Trabajan con empresas internacionales?','answer','Sí, colaboramos con organizaciones en América Latina, Estados Unidos y Europa.'),
    JSON_OBJECT('question','¿Ofrecen soporte continuo?','answer','Mantenemos células dedicadas de soporte y optimización continua según cada proyecto.'),
    JSON_OBJECT('question','¿Cuál es el tiempo promedio de implementación?','answer','Entre 8 y 12 semanas dependiendo del alcance del proyecto.'),
    JSON_OBJECT('question','¿Cómo manejan la seguridad de la información?','answer','Implementamos políticas de seguridad, cifrado, accesos segmentados y cumplimos estándares internacionales.'),
    JSON_OBJECT('question','¿Pueden integrarse con sistemas existentes?','answer','Sí, desarrollamos integraciones personalizadas con CRM, ERP y plataformas de analítica.'),
    JSON_OBJECT('question','¿Qué modelos de contratación ofrecen?','answer','Proyectos llave en mano, retainer estratégico, equipos dedicados y training in-company.'),
    JSON_OBJECT('question','¿Tienen experiencia en startups?','answer','Colaboramos con startups en etapas seed hasta series B, acelerando su time-to-market.')
)),
('team_members', JSON_ARRAY(
    JSON_OBJECT('name','Laura Santillán','role','Chief Experience Officer','photo','team-laura.jpg','bio','Especialista en estrategia de experiencia y diseño de servicios.'),
    JSON_OBJECT('name','Andrés Pardo','role','Head of Technology','photo','team-andres.jpg','bio','Arquitecto de soluciones cloud y automatización de procesos.'),
    JSON_OBJECT('name','Paula Méndez','role','Lead Strategist','photo','team-paula.jpg','bio','Diseña roadmaps de innovación basados en datos y tendencias.'),
    JSON_OBJECT('name','Rodrigo Sáenz','role','Innovation Director','photo','team-rodrigo.jpg','bio','Impulsa laboratorios de prototipado y co-creación con clientes.')
)),
('values', JSON_ARRAY(
    JSON_OBJECT('title','Innovación consciente','description','Soluciones que combinan creatividad y responsabilidad.'),
    JSON_OBJECT('title','Data con propósito','description','Decisiones guiadas por analítica y entendimiento profundo del usuario.'),
    JSON_OBJECT('title','Experiencias memorables','description','Diseñamos interacciones relevantes, humanas y consistentes.'),
    JSON_OBJECT('title','Co-creación','description','Trabajamos como una sola célula con nuestros clientes.'),
    JSON_OBJECT('title','Excelencia operacional','description','Procesos medibles, escalables y sostenibles.'),
    JSON_OBJECT('title','Impacto tangible','description','Cada entrega se conecta con objetivos de negocio claros.')
)),
('timeline', JSON_ARRAY(
    JSON_OBJECT('year','2018','title','Nacimiento de SOSHEMAIN','description','Unimos talento creativo, estratégico y tecnológico para impulsar marcas latinoamericanas.'),
    JSON_OBJECT('year','2019','title','Primeras implementaciones omnicanal','description','Lanzamos ecosistemas digitales para retail, turismo y educación.'),
    JSON_OBJECT('year','2021','title','Expansión regional','description','Abrimos operaciones en Bogotá, Buenos Aires y Madrid.'),
    JSON_OBJECT('year','2023','title','Laboratorio de experiencias inmersivas','description','Integramos realidad aumentada, data en tiempo real y personalización avanzada.')
)),
('newsletter_subscribers', JSON_ARRAY()),
('translations', JSON_OBJECT());

INSERT INTO categories (name, slug, type, meta_data) VALUES
('Transformación digital', 'transformacion-digital', 'product', JSON_OBJECT('description','Estrategias integrales para modernizar procesos y modelos de negocio.','benefits',JSON_ARRAY('Mapeo de procesos clave','Roadmap 90 días','Activación de squads híbridos'),'deliverables',JSON_ARRAY('Diagnóstico inmersivo','Plan maestro 90 días','Acompañamiento ejecutivo'))),
('Experiencias omnicanal', 'experiencias-omnicanal', 'product', JSON_OBJECT('description','Diseño y ejecución de experiencias conectadas entre canales físicos y digitales.','benefits',JSON_ARRAY('Cartografía de journeys','Arquitectura de datos','KPIs de experiencia'),'deliverables',JSON_ARRAY('Blueprint omnicanal','Configuración de plataformas','Plan de medición CX'))),
('Automatización inteligente', 'automatizacion-inteligente', 'product', JSON_OBJECT('description','Automatizaciones impulsadas por datos para marketing, ventas y servicio.','benefits',JSON_ARRAY('Bots conversacionales','Orquestador de leads','Alertas inteligentes'),'deliverables',JSON_ARRAY('Stack tecnológico recomendado','Workflows automatizados','Panel de seguimiento'))),
('Growth marketing', 'growth-marketing', 'product', JSON_OBJECT('description','Experimentación continua enfocada en adquisición y retención.','benefits',JSON_ARRAY('Plan de experimentos','Optimización creativa','Reporte semanal'),'deliverables',JSON_ARRAY('Matriz de experimentos','Librería creativa optimizada','Reporte semanal de impacto'))),
('Tendencias e innovación', 'tendencias-innovacion', 'post', NULL),
('Cultura digital', 'cultura-digital', 'post', NULL);

INSERT INTO products (name, slug, description, price, sku, stock, category_id, images, featured, meta_title, meta_desc, meta_json)
VALUES
('Estrategia 360° Experience', 'estrategia-360-experience', '<p>Programa integral que conecta insights, data y diseño de experiencias personalizadas.</p>', 28500.00, 'SOS-EX-001', 10, 1, JSON_ARRAY('producto-experience.jpg'), 1, 'Estrategia 360° Experience', 'Programa integral de estrategia y experiencia.', JSON_OBJECT('segment','Enterprise','includes',JSON_ARRAY('Discovery colaborativo','Roadmap 90 días','Blueprint de experiencia'),'outcomes',JSON_ARRAY('Incremento de NPS','Mejor adopción digital'))),
('Hub Omnicanal Elevate', 'hub-omnicanal-elevate', '<p>Implementación llave en mano de un centro omnicanal con personalización y analítica.</p>', 32000.00, 'SOS-OM-002', 8, 2, JSON_ARRAY('hub-omnicanal.jpg'), 1, 'Hub Omnicanal Elevate', 'Solución omnicanal para servicio al cliente.', JSON_OBJECT('segment','B2C','includes',JSON_ARRAY('Orquestador de journeys','Automatización CRM','Panel de control'),'outcomes',JSON_ARRAY('Reducción de tiempos de respuesta','Incremento de conversión'))),
('Inteligencia Comercial Predict', 'inteligencia-comercial-predict', '<p>Motor de analítica que pronostica demanda, prioriza leads y propone acciones.</p>', 19800.00, 'SOS-IA-003', 12, 3, JSON_ARRAY('predict-analytics.jpg'), 0, 'Inteligencia Comercial Predict', 'Modelo avanzado de analítica y IA.', JSON_OBJECT('segment','B2B','includes',JSON_ARRAY('Modelos predictivos','Integración CRM','Dashboard en tiempo real'),'outcomes',JSON_ARRAY('Mejor forecast','Prioridad de oportunidades'))),
('Performance Labs', 'performance-labs', '<p>Growth marketing con experimentación continua, optimización creativa y automatización.</p>', 12500.00, 'SOS-GR-004', 20, 4, JSON_ARRAY('performance-labs.jpg'), 1, 'Performance Labs', 'Growth marketing y experimentación.', JSON_OBJECT('segment','Scaleups','includes',JSON_ARRAY('Experimentación multicanal','Automatización de leads','Reporting semanal'),'outcomes',JSON_ARRAY('Incremento CAC/LTV','Aceleración de funnel')));

INSERT INTO pages (title, slug, content, featured_image, meta_title, meta_desc, schema_json, status, updated_at) VALUES
('Inicio', 'inicio', JSON_OBJECT('hero','Innovación que impulsa resultados'), '', 'SOSHEMAIN | Innovación que impulsa resultados', 'Consultora de innovación, tecnología y experiencias digitales.', '', 'published', NOW()),
('Sobre nosotros', 'sobre-nosotros', '<p>SOSHEMAIN es un colectivo de estrategas que impulsa la evolución digital de marcas en LATAM.</p>', '', 'Sobre SOSHEMAIN', 'Historia, misión y visión de SOSHEMAIN.', '', 'published', NOW()),
('Privacidad', 'privacidad', '<p>Protegemos tus datos personales conforme a la legislación vigente.</p>', '', 'Aviso de privacidad', 'Aviso de privacidad SOSHEMAIN.', '', 'published', NOW()),
('Términos y condiciones', 'terminos', '<p>Condiciones de uso de los servicios y plataformas SOSHEMAIN.</p>', '', 'Términos SOSHEMAIN', 'Condiciones de uso del sitio SOSHEMAIN.', '', 'published', NOW());

INSERT INTO posts (title, slug, excerpt, content, author_id, cover, status, meta_title, meta_desc, published_at)
VALUES
('Cómo diseñar experiencias phygital memorables', 'experiencias-phygital-memorables', 'Un framework para integrar canales físicos y digitales con consistencia.', '<p>Integra tecnología, datos y storytelling para crear experiencias phygital memorables.</p>', 1, 'post-phygital.jpg', 'published', 'Experiencias phygital memorables', 'Framework phygital SOSHEMAIN', NOW()),
('KPIs que transforman tu estrategia omnicanal', 'kpis-estrategia-omnicanal', 'Selecciona indicadores que conectan experiencia y negocio.', '<p>Define KPIs que conecten experiencia de cliente y objetivos comerciales.</p>', 1, 'post-kpi.jpg', 'published', 'KPIs omnicanales', 'Indicadores omnicanales clave.', NOW()),
('Cultura de innovación centrada en personas', 'cultura-innovacion-personas', 'Tips para activar una cultura que prioriza la co-creación.', '<p>La cultura de innovación requiere liderazgo empático y metodologías colaborativas.</p>', 1, 'post-cultura.jpg', 'published', 'Cultura de innovación centrada en personas', 'Activa cultura de innovación centrada en personas.', NOW()),
('Tendencias digitales que marcarán 2025', 'tendencias-digitales-2025', 'Un vistazo a tecnologías y hábitos que redefinirán la próxima ola digital.', '<p>Explora las tendencias emergentes que cambiarán la manera de conectar con los usuarios.</p>', 1, 'post-tendencias.jpg', 'published', 'Tendencias digitales 2025', 'Tendencias clave para 2025.', NOW());

INSERT INTO jobs (title, area, type, location, description, apply_email, status, created_at)
VALUES
('Lead Product Strategist', 'Estrategia', 'Tiempo completo', 'Ciudad de México · Híbrido', '<p>Define roadmaps de producto y coordina squads multidisciplinarios.</p>', 'talento@soshemain.com', 'open', NOW()),
('Creative Technology Specialist', 'Innovación', 'Tiempo completo', 'Bogotá · Remoto', '<p>Desarrolla prototipos de experiencias interactivas con tecnologías emergentes.</p>', 'talento@soshemain.com', 'open', NOW()),
('Data Experience Analyst', 'Data & Insights', 'Tiempo completo', 'Madrid · Híbrido', '<p>Diseña modelos de analítica y visualizaciones centradas en experiencia de usuario.</p>', 'talento@soshemain.com', 'open', NOW());

INSERT INTO menus (name, items) VALUES
('principal', JSON_ARRAY(
    JSON_OBJECT('label','Inicio','url','/public/index.php'),
    JSON_OBJECT('label','Sobre','url','/public/about.php'),
    JSON_OBJECT('label','Servicios','url','/public/services.php'),
    JSON_OBJECT('label','Soluciones','url','/public/products.php'),
    JSON_OBJECT('label','Blog','url','/public/blog.php'),
    JSON_OBJECT('label','Contacto','url','/public/contact.php')
));
