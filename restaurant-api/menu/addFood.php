<?php

include_once(
__DIR__ .
"/../config/cors.php"
);

include_once(
__DIR__ .
"/../config/db.php"
);

$food_name =
$_POST['food_name']
?? '';

$category =
$_POST['category']
?? '';

$section =
$_POST['section']
?? '';

$food_type =
$_POST['food_type']
?? '';

$price =
$_POST['price']
?? '';

$imageName = "";

if(
isset($_FILES['image'])
){

$imageName =
time()
. "_"
.
basename(
$_FILES['image']['name']
);

$target =
__DIR__
.
"/../uploads/images/"
.
$imageName;

move_uploaded_file(
$_FILES['image']['tmp_name'],
$target
);
}

$query =
"
INSERT INTO foods
(
food_name,
category,
section,
food_type,
price,
image
)
VALUES
(
'$food_name',
'$category',
'$section',
'$food_type',
'$price',
'$imageName'
)
";

$result =
mysqli_query(
$conn,
$query
);

echo json_encode([
"success" =>
$result,
"message" =>
$result
? "Food Added Successfully"
: mysqli_error($conn)
]);

?>