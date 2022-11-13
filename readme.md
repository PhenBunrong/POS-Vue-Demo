## Database Stucture
+Users
	id,
	name,
	name_kh,
	gender,
	dob,
	address,
	phone,
	hire_date,
	position,
	photo,
	username,
	password,
	.....

+Customers
	id,
	name,
	gender,
	phone,
	address

+Tables
	id,
	name,
	dsc

+Categories
	id,
	name,
	name_kh,
	dsc
+Products
	id,
	name,
	name_kh,
	price,
	dsc,
	category => Categories,
