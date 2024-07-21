<?php
include_once(__DIR__ . '/../set/func.php');

usercontrol();

$request = fpost('request');

if ($request == 'check-url') {
    $title = fpost('title');
    $slug = oes($title);

    $query = $db->prepare("SELECT COUNT(*) FROM products WHERE slug_url LIKE :slug");
    $query->execute(['slug' => $slug . '%']);
    $count = $query->fetchColumn();

    if ($count > 0) {
        $slug .= '-' . ($count + 1);
    }

    echo json_encode(['slug' => $slug]);
} else if ($request == 'product-add') {
    $cover_image = imageSave($_FILES['cover_image'], '/products/');
    $datas = [
        'name' => fpost('name'),
        'price' => fiyatKaydet(fpost('price')),
        'status' => post('status'),
        'p_order' => post('p_order'),
        'cover_image' => $cover_image,
        'slug_url' => fpost('slug_url'),
        'description' => fpost('description')
    ];

    $response = dbEkle('products', $datas);

    if ($response) {
        $productId = $db->lastInsertId();
        $galleryImages = $_FILES['gallery_images'];

        if ($galleryImages) {
            foreach ($galleryImages['tmp_name'] as $key => $tmp_name) {
                $image = [
                    'name' => $galleryImages['name'][$key],
                    'tmp_name' => $tmp_name,
                    'type' => $galleryImages['type'][$key],
                    'error' => $galleryImages['error'][$key],
                    'size' => $galleryImages['size'][$key],
                ];
                $imagePath = imageSave($image, '/gallery/');
                if ($imagePath) {
                    dbEkle('product_images', [
                        'product_id' => $productId,
                        'image_path' => $imagePath
                    ]);
                }
            }
        }

        echo json_encode(['success' => true, 'product_id' => $productId]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ürün eklenemedi.']);
    }
} else if ($request == 'product-update') {
    $id = decrypt(fpost('id'));
    numeric($id);

    if ($_FILES['cover_image']['size'] > 0) {
        $cover_image = imageSave($_FILES['cover_image'], '/products/', fpost('old_img'));
    } else {
        $cover_image = fpost('old_img');
    }

    $datas = [
        'name' => fpost('name'),
        'price' => fiyatKaydet(fpost('price')),
        'status' => post('status'),
        'p_order' => post('p_order'),
        'cover_image' => $cover_image,
        'slug_url' => fpost('slug_url'),
        'description' => fpost('description'),
        'id' => $id
    ];
    $sart = "(id=:id)";

    $response = dbGuncelle('products', $datas, $sart);

    if ($response) {
        $productId = $id;
        $galleryImages = $_FILES['gallery_images'];

        if ($galleryImages) {
            foreach ($galleryImages['tmp_name'] as $key => $tmp_name) {
                $image = [
                    'name' => $galleryImages['name'][$key],
                    'tmp_name' => $tmp_name,
                    'type' => $galleryImages['type'][$key],
                    'error' => $galleryImages['error'][$key],
                    'size' => $galleryImages['size'][$key],
                ];
                $imagePath = imageSave($image, '/gallery/');
                if ($imagePath) {
                    dbEkle('product_images', [
                        'product_id' => $productId,
                        'image_path' => $imagePath
                    ]);
                }
            }
        }

        echo json_encode(['success' => true, 'product_id' => $productId]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ürün eklenemedi.']);
    }
} else if ($request == 'get-all-products') {
    $response = [];

    $draw = kelimeTemizle($_POST['draw']);
    $row = kelimeTemizle($_POST['start']);
    $rowperpage = kelimeTemizle($_POST['length']);
    $columnIndex = kelimeTemizle($_POST['order'][0]['column']);
    $columnName = kelimeTemizle($_POST['columns'][$columnIndex]['data']);
    $columnSortOrder = kelimeTemizle($_POST['order'][0]['dir']);
    $searchValue = kelimeTemizle($_POST['search']['value']);

    $searchArray = array();

    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " (name LIKE :name OR price LIKE :price) ";
        $searchArray = array(
            'name' => "%$searchValue%",
            'price' => "%$searchValue%"
        );
    } else {
        $searchQuery = " 1 ";
    }

    $stmt = $db->prepare("SELECT COUNT(*) as allcount FROM products");
    $stmt->execute();
    $records = $stmt->fetch();
    $response['recordsTotal'] = $records['allcount'];

    $stmt = $db->prepare("SELECT COUNT(*) as allcount FROM products WHERE $searchQuery");
    $stmt->execute($searchArray);
    $records = $stmt->fetch();
    $response['recordsFiltered'] = $records['allcount'];

    $stmt = $db->prepare("SELECT id, name, price, cover_image, status, p_order FROM products WHERE $searchQuery ORDER BY $columnName $columnSortOrder LIMIT :limit,:offset");

    foreach ($searchArray as $key => $search) {
        $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
    }

    $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
    $stmt->execute();
    $datas = $stmt->fetchAll();
    $data = array();
    $response['data'] = [];
    foreach ($datas as $data) {
        $response['data'][] = [
            'id' => encrypt($data['id']),
            'name' => kelimeTemizle($data['name']),
            'price' => kelimeTemizle($data['price']) . ' ₺',
            'status' => kelimeTemizle($data['status']) == 1 ? '<badge class="badge badge-success">Aktif</bage>' : '<badge class="badge badge-danger">Pasif</bage>',
            'p_order' => kelimeTemizle($data['p_order']),
            'img' => '<img src="../../' . $data['cover_image'] . '" alt="-" style="width:50px;height:auto;">',
            'buttons' => '<a href="urun-duzenle-' . encrypt($data['id']) . '.html" class="btn btn-secondary btn-sm">Düzenle</a><a href="javascript:;" onclick="removeProduct(\'' . encrypt($data['id']) . '\');" class="btn btn-danger btn-sm ml-2">Sil</a>'
        ];
    }

    echo json_encode($response);
    exit;
} else if ($request == 'remove-image') {
    $imageId = decrypt(fpost('image_id'));

    $stmt = $db->prepare("SELECT image_path FROM product_images WHERE id=:id");
    $stmt->bindValue(':id', $imageId, PDO::PARAM_INT);
    $stmt->execute();
    $image = $stmt->fetch();

    if ($image) {
        $stmt = $db->prepare("DELETE FROM product_images WHERE id=:id");
        $stmt->bindValue(':id', $imageId, PDO::PARAM_INT);
        $stmt->execute();

        $imagePath = __DIR__ . '/../../' . $image['image_path'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Resim bulunamadı.']);
        exit;
    }
} else if ($request == 'remove-product') {
    $id = decrypt(fpost('i'));
    numeric($id);

    $stmt=$db->prepare("SELECT * FROM products WHERE id=:id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $image=$stmt->fetch();

    $imagePath=__DIR__ . '/../../' . $image['cover_image'];  
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    $stmt=$db->prepare("DELETE FROM products WHERE id=:id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $stmt = $db->prepare("SELECT * FROM product_images WHERE product_id=:product_id");
    $stmt->bindValue(':product_id', $id, PDO::PARAM_INT);
    $stmt->execute();

    while ($image = $stmt->fetch()) {
        $imagePath = __DIR__ . '/../../' . $image['image_path'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $deleteStmt = $db->prepare("DELETE FROM product_images WHERE id=:id");
        $deleteStmt->bindValue(':id', $image['id'], PDO::PARAM_INT);
        $deleteStmt->execute();
    }

    echo json_encode(['success' => true]);
    exit;
}
