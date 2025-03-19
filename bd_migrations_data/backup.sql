INSERT INTO "users" ("name", "surname", "email", "role")
VALUES
    ('Равиль', 'Ибаков', 'RavilIbakov102@yandex.ru', 1),
    ('Радис', 'Афлятунов', 'RadisAflyatunov@example.com', 2),
    ('Газинур', 'Уразбаев', 'gazinururaz@example.com', 2),
    ('Евгений', 'Петров', 'alexinnn@gmail.com', 2);

insert into categories(name) values ('Телефоны'), ('Аксессуары');

INSERT INTO public.products
(product_name, categories_id, product_price, product_color, product_description)
VALUES
    ('Apple iPhone 15 Pro 128 ГБ', 1, 75000, 'Black',
     'Экран: Без дефектов; Корпус: Без дефектов; Комплект: Коробка, Провод зарядки; Состояние: Отличное;'),
    ('Apple iPhone 15 128 ГБ', 1, 60000, 'Black',
     'Экран: Без дефектов; Корпус: Без дефектов; Комплект: Коробка, Провод зарядки; Состояние: Отличное;'),
    ('Apple iPhone 13 256 ГБ', 2, 60000, 'White',
     'Экран: Без дефектов; Корпус: Без дефектов; Комплект: Коробка, Провод зарядки; Состояние: Отличное;'),
    ('Apple iPhone 13 Pro 256 ГБ', 1, 45000, 'White',
     'Экран: Без дефектов; Корпус: Без дефектов; Комплект: Коробка, Провод зарядки; Состояние: Отличное;');



