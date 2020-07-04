<?php
$allFiles = glob("../newsletterImages/*");
$images = [];
for ($i = 0; $i < count($allFiles); $i++) {
    $imageName = $allFiles[$i];
    $support = array('gif', 'jpg', 'jpeg', 'png');
    $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    if (in_array($ext, $support)) {
        //echo '<a onclick="addImage(this)" href="#"><img class="ml-2 mr-2 mt-2 mb-2" width="200px" height="200px" src="' . $imageName . '" alt="' . $imageName . '" /></a>';
        $images[] = $imageName;
    } else {
        continue;
    }
}

echo json_encode($images);