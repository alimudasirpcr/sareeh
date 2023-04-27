-- covert_customer_phone_to_alphanumeric --
update phppos_people set phone_number = alphanumplus(phone_number);