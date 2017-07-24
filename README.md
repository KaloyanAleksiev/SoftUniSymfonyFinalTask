.checkout
=========

A Symfony project created on June 15, 2017, 6:40 pm.

Individual Project Assignment for the Symfony 3 course @ SoftUni


Design and implement Products bundle. Your project must meet all the requirements listed below.

Requirements

●	Use fresh installed Symfony 3.2
●	Use version control system
o	Use GitHub or other source control system as project collaboration platform and commit your daily work
Project
Required functionalities:
Products bundle with the following functionalities:
●	(required) The SoftUni namespace must be used for the module's name.
●	Product entity:
◦	(required, 5pts) Models + DB tables with fields: id, slug, title, subtitle, descritpion, image(optional), price, rank, created_at, updated_at
◦	(required, 5pts) CRUD operations with url prefix “admin/product”.
◦	(5pts)Images have to be uploaded in web/uploads/product directory
●	ProductCategory entity:
◦	(required, 5pts) Models + DB tables with fields: slug, title, description, image(optional), rank, parent(optional), children(optional), created_at, updated_at
◦	(5pts)Parent and children have to be implemented by creating a self referencing
relationship
◦	(8pts) CRUD operations with url prefix “admin/product-category”.
◦	(5pts)Images have to be uploaded in web/uploads/product-category directory
●	Many to many relation between Product and ProductCategory entities
●	Create two services ProductManager and ProductCategoryManager
◦	(required, 3pts)In both services inject EntityManager and Service Container and referencing Class (e.g Product, ProductCategory)
◦	(required, 5pts)ProductManager have to implement methods: getClass,
getEntityManager, createProduct, removeProduct, findProductBy which have to use criteria for selecting products and repository. You can add as many other methods as you want
◦	(required, 5pts)ProductCategoryManager have to implement methods: getClass,
getEntityManager, createCategory, removeCategory, findCategoryBy which have to use criteria for selecting products and repository, addProduct, You can add as many other methods as you   want.

●	(5pts)Create service for sending emails to notify list of predefined email addresses for new products in application.
 
●	(15pts) Create actions for listing already created categories /category/list with image and title ordered by rank.
◦	If category has children, title and image should to be links to listing with children of this cateogry otherwise title and image should to be links to listing containing products which are related to this category(product/list).
◦	Produtcs listing (product/list) should have image and titile of product and shoud be link to product/{id}/view ordered by rank. Here we show category title and description above listing of products.
●	(9pts) Create product view actoion product/{id}/view. Show title, subtitle, slug, price, description and image fields.
